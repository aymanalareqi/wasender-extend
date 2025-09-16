<?php

namespace Alareqi\WasenderExtend\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\App;
use App\Models\Device;
use App\Models\Smstransaction;
use Auth;
use Illuminate\Http\Request;

class AppsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $apps = App::where('user_id', Auth::id())->with('device')->withCount('liveMessages')->latest()->paginate(20);
        $devices = Device::where('user_id', Auth::id())->latest()->get();
        $total = Smstransaction::where('user_id', Auth::id())->where('app_id', '!=', null)->count();
        $last30_messages = Smstransaction::where('user_id', Auth::id())
            ->where('app_id', '!=', null)
            ->where('created_at', '>', now()
                ->subDays(30)
                ->endOfDay())
            ->count();
        $total_app = App::where('user_id', Auth::id())->count();

        $limit = json_decode(Auth::user()->plan);
        $limit = $limit->apps_limit ?? 0;
        if ($limit == '-1') {
            $limit = number_format($total_app);
        } else {
            $limit = number_format($total_app).'/'.$limit;
        }

        return view('wacore::user.apps.index', compact('apps', 'devices', 'total', 'last30_messages', 'total_app', 'limit'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if (getUserPlanData('apps_limit') == false) {
            return response()->json([
                'message' => __('Maximum App Limit Is Exceeded'),
            ], 401);
        }

        $validated = $request->validate([
            'name' => 'required|max:50',
            'device' => 'required',
            'website' => 'required|max:80|url',
        ]);

        $device = Device::where('user_id', Auth::id())->findorFail($request->device);

        $app = new App;
        $app->user_id = Auth::id();
        $app->title = $request->name;
        $app->website = $request->website;
        $app->device_id = $request->device;
        $app->save();

        return response()->json([
            'redirect' => route('user.app.integration', $app->uuid),
            'message' => __('App created successfully.'),
        ]);
    }
}
