<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Sms;
use Illuminate\Http\Request;


class SmsApiController extends Controller
{

    public function smsSend(Request $request)
    {
        $result = array(
            "status" => "fail",
            "number" => "null",
            "msg" => "null"
        );
          if ($request->pass === '3605a8cb7e1a0673') {
            $sms = Sms::where('status', '=', '0')->where('number', '!=', '')->where('msg', '!=', '')->orderBy('id', 'asc')->first();
            if ($sms !== null) {
                $result["status"] = "success";
                $result["id"] = $sms->id;
                $result["number"] = $sms->number;
                $result["msg"] = $sms->msg;
            }
        }

        return response()->json($result);

    }

    public function smsSent(Request $request)
    {
        $result = array(
            "status" => "fail"
        );
         if ($request->pass === '3605a8cb7e1a0673') {
            $sms = Sms::where('id', $request->id)->orderBy('id', 'asc')->first();
            $sms->status = '1';
            $sms->save();

            if ($sms !== null) {
                $result["status"] = "success";
            }
        }

        return response()->json($result);

    }
}
