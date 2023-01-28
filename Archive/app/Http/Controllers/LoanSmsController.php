<?php

namespace App\Http\Controllers;

use App\Invoices;
use Illuminate\Http\Request;
use App\LoanSms;
use Illuminate\Support\Facades\Auth;
use App\Credit;
use DB;

class LoanSmsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function manage(Request $request)
    {
        $mobi = $request->query('mobicom', 'false');

        $results = [];
        if ($mobi === 'false') {
            $results = Credit::leftJoin('invoices', 'invoices.credit_id', '=', 'credits.credit_id')
                ->select(
                    'credits.*',
                    DB::raw('sum(case when invoices.type in ("9","5","2") then 1 else 0 end) as khuusent'),
                    DB::raw('sum(case when invoices.status = "1" then 1 else 0 end) as pending'),
                    DB::raw('sum(case when (invoices.status = "2" or invoices.status = "3") then 1 else 0 end) as paid'),
                    DB::raw('sum(case when (invoices.honog > -1 and invoices.honog < 60) then 1 else 0 end) as honog_first'),
                    DB::raw('sum(case when (invoices.honog > 59 and invoices.honog < 90) then 1 else 0 end) as honog_second'),
                    DB::raw('sum(case when (invoices.honog > 89) then 1 else 0 end) as honog_last')
                )
                ->groupBy(
                    'credits.id',
                    'credits.credit_id',
                    'credits.number',
                    'credits.phone',
                    'credits.duusah_honog',
                    'credits.lastname',
                    'credits.amount',
                    'credits.huramtlagdsankhuu',
                    'credits.aldangi',
                    'credits.khuu',
                    'credits.assessment',
                    'credits.zeeluldegdel',
                    'credits.khetersenkhonog',
                    'credits.honog',
                    'credits.created_at',
                    'credits.updated_at'
                )
                ->get();
        } else {
            $results = Credit::leftJoin('invoices', 'invoices.credit_id', '=', 'credits.credit_id')
                ->leftJoin('mobicoms', function ($join) {
                    $join->on('mobicoms.desc', 'like', DB::raw("concat('%',credits.phone,'%')"));
                })
                ->select(
                    'credits.*',
                    DB::raw('sum(case when invoices.type in ("9","5","2") then 1 else 0 end) as khuusent'),
                    DB::raw('sum(case when invoices.status = "1" then 1 else 0 end) as pending'),
                    DB::raw('sum(case when (invoices.status = "2" or invoices.status = "3") then 1 else 0 end) as paid'),
                    DB::raw('sum(case when (invoices.honog > -1 and invoices.honog < 60) then 1 else 0 end) as honog_first'),
                    DB::raw('sum(case when (invoices.honog > 59 and invoices.honog < 90) then 1 else 0 end) as honog_second'),
                    DB::raw('sum(case when (invoices.honog > 89) then 1 else 0 end) as honog_last')
                )
                ->whereNull(DB::raw('mobicoms.desc'))
                ->groupBy(
                    'credits.id',
                    'credits.credit_id',
                    'credits.number',
                    'credits.phone',
                    'credits.duusah_honog',
                    'credits.lastname',
                    'credits.amount',
                    'credits.huramtlagdsankhuu',
                    'credits.aldangi',
                    'credits.khuu',
                    'credits.assessment',
                    'credits.zeeluldegdel',
                    'credits.khetersenkhonog',
                    'credits.honog',
                    'credits.created_at',
                    'credits.updated_at'
                )
                ->get();
        }


//        dd(DB::getQueryLog());
        return view('admin.loan.loanSms', ['datas' => $results]);

    }


    public function paidlist()
    {
        $results = Invoices::select("*")
            ->whereIn("status", ["2", "3"])->orderBy("created_at", "desc")
            ->get();
        return view('admin.loan.loanPaidList', ['results' => $results]);
    }
}
