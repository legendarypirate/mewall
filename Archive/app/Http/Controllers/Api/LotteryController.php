<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Lottery;
use App\Sms;
use Illuminate\Http\Request;


class LotteryController extends Controller
{

    public function lottery(Request $request)
    {
//        $user = Auth::user();
        $sms = new Sms();
        $sms->number = $request->phone;
        $sms->msg = $request->msg;
        $sms->status = '0';
        $sms->type = 'lottery';
        $sms->user = 'lottery';
        $sms->date = date('Y-m-d H:i:s');
        $sms->save();

        if ($sms != null) {
            $lEntry = new Lottery();
            $lEntry->number = $request->number;
            $lEntry->phone = $request->phone;
            $lEntry->msg = $request->msg;
            $lEntry->status = 'Y';
            $lEntry->save();
        }

        $result = array(
            "status" => "200",
            "msg" => "success"
        );
        return response()->json($result);
    }

    public function getlastlottery()
    {
        $lnumber = 0;
        $lott = Lottery::where('status', '=', 'Y')->orderBy('id', 'desc')->first();
        if ($lott !== null) {
            $lnumber = $lott->number;
        }
        $lnumber = $lnumber + 1;
        $nnn = "";
        for ($x = 0; $x < 6 - strlen($lnumber . ''); $x++) {
            $nnn = $nnn . '0';
        }
        $nnn = $nnn . $lnumber;

        $result = array(
            "status" => "200",
            "number" => $nnn,
            "orgn" => $lnumber,
            "msg" => "success"
        );

        return response()->json($result);

    }


}
