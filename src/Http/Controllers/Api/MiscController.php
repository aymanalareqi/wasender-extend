<?php

namespace Alareqi\WasenderExtend\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\App;
use App\Models\User;
use App\Traits\Whatsapp;
use Http;
use Illuminate\Http\Request;

class MiscController extends Controller
{
    use Whatsapp;

    /**
     * sent message
     *
     * @return \Illuminate\Http\Response
     */
    public function onWhatsapp(Request $request)
    {
        $user = User::where('status', 1)->where('will_expire', '>', now())->where('authkey', $request->authkey)->first();

        $app = App::where('key', $request->appkey)->whereHas('device')->with('device')->where('status', 1)->first();

        if ($user == null || $app == null) {
            return response()->json(['error' => 'Invalid Auth and AppKey'], 401);
        }

        $inputs = $request->all();
        $validator = validator($inputs, [
            'whatsapp_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(
                [
                    'message' => __('Validation error'),
                    'errors' => $validator->errors(),
                ],
                401,
            );
        }

        return $this->whatsappIdOnWhatsapp($app->device->id, $inputs['whatsapp_id']);
    }

    public function Qr(Request $request)
    {
        $user = User::where('status', 1)->where('will_expire', '>', now())->where('authkey', $request->authkey)->first();

        $app = App::where('key', $request->appkey)->whereHas('device')->with('device')->where('status', 1)->first();

        if ($user == null || $app == null) {
            return response()->json(['error' => 'Invalid Auth and AppKey'], 401);
        }

        $inputs = $request->all();
        $validator = validator($inputs, [
            'whatsapp_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(
                [
                    'message' => __('Validation error'),
                    'errors' => $validator->errors(),
                ],
                401,
            );
        }
    }

    public function getQr(Request $request)
    {
        $user = User::where('status', 1)->where('will_expire', '>', now())->where('authkey', $request->authkey)->first();

        $app = App::where('key', $request->appkey)->whereHas('device')->with('device')->where('status', 1)->first();

        if ($user == null || $app == null) {
            return response()->json(['error' => 'Invalid Auth and AppKey'], 401);
        }

        $device = $app->device;

        if (! $device) {
            return response()->json([
                'message' => __('Device not found'),
            ], 404);
        }

        $id = $device->id;
        $response = Http::post(env('WA_SERVER_URL').'/sessions/add', [
            'id' => 'device_'.$id,
            'isLegacy' => false,
        ]);

        if ($response->status() == 200) {
            $body = json_decode($response->body());
            $data['qr'] = $body->data->qr;
            $data['message'] = $body->message;
            $device->qr = $body->data->qr;
            $device->save();

            return response()->json($data);
        } elseif ($response->status() == 409) {
            $data['qr'] = $device->qr;
            $data['message'] = __('QR code received, please scan the QR code');

            return response()->json($data);
        }
    }

    public function checkSession(Request $request)
    {
        $user = User::where('status', 1)->where('will_expire', '>', now())->where('authkey', $request->authkey)->first();

        $app = App::where('key', $request->appkey)->whereHas('device')->with('device')->where('status', 1)->first();

        if ($user == null || $app == null) {
            return response()->json(['error' => 'Invalid Auth and AppKey'], 401);
        }

        $device = $app->device;

        if (! $device) {
            return response()->json([
                'message' => __('Device not found'),
            ], 404);
        }

        $id = $device->id;
        $response = Http::get(env('WA_SERVER_URL').'/sessions/status/device_'.$id);

        $device->status = $response->status() == 200 ? 1 : 0;
        if ($response->status() == 200) {
            $res = json_decode($response->body());
            if (isset($res->data->userinfo)) {
                $device->user_name = $res->data->userinfo->name ?? '';
                $phone = str_replace('@s.whatsapp.net', '', $res->data->userinfo->id);
                $phone = explode(':', $phone);
                $phone = $phone[0] ?? null;

                $device->phone = $phone;
                $device->qr = null;
            }
        }
        $device->save();

        $message = $response->status() == 200 ? __('Device Connected Successfully') : null;

        return response()->json([
            'message' => $message,
            'connected' => $response->status() == 200 ? true : false,
            'phone' => $device->phone,
        ]);
    }
}
