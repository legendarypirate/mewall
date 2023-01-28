<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Lottery;
use App\Sms;
use Illuminate\Http\Request;


class LotteryController extends Controller
{

    public function lotteries()
    {
        $lotteries = Lottery::select("*")
            ->where([
                ["status", "=", "N"]
            ])->orderBy('id', 'desc')->get();
        return view('admin.sms.lotteries', ['lotteries' => $lotteries]);
    }

    public function removelott(Request $request)
    {
        $id = $request->id;
        $sDelete = Lottery::find($id);
        $sDelete->delete();

        return response()->json([
            'msg' => 'success',
            'success' => true,
            'status' => 200
        ]);
    }

}
