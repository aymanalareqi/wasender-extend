<?php

namespace Alareqi\WasenderExtend\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\App;
use App\Models\Device;
use App\Models\Smstransaction;
use Auth;

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
}
