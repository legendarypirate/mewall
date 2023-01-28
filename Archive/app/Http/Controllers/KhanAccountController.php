<?php

namespace App\Http\Controllers;

use App\KhanAccount;
use App\Statment;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class KhanAccountController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $isupdate = false;
        $last = KhanAccount::orderBy('created_at', 'desc')->first();

        if ($last === null) {
            $isupdate = true;
        } else {
            $updatedAt = Carbon::parse(date('Y-m-d H:i:s'));
            $playedAt = Carbon::parse($last->created_at);
            $minutes = $updatedAt->diffInMinutes($playedAt);

            if ($minutes > 30) {
                $isupdate = true;
            }
        }

        $accounts = KhanAccount::all();
        return view('admin.loan.khanAccount', ['accounts' => $accounts, 'isupdate' => $isupdate]);
    }


    public function syncaccount()
    {
        ini_set("allow_url_fopen", 1);
        $sendURL = "https://api.khanbank.com/v1/auth/token?grant_type=client_credentials";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, "Tf1voa2DyyrobYByVFkmvOb4JPtrV2eX" . ":" . "JpXdvgCfqdKhsLkF");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $sendURL);
        $result2 = curl_exec($ch);
        curl_close($ch);
        $obj2 = json_decode($result2);

        $authorization = "Authorization: Bearer $obj2->access_token";
        ini_set("allow_url_fopen", 1);
        $sendURL = "https://api.khanbank.com/v1/accounts";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $sendURL);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', $authorization));
        $res = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        $status = 300;
        if ($httpcode === 200) {
            $status = 200;
            KhanAccount::truncate();
            $response = json_decode($res);
            $accounts = $response->accounts;

            foreach ($accounts as $account) {
                $accountEntry = new KhanAccount();
                $accountEntry->number = $account->number;
                $accountEntry->type = $account->type;
                $accountEntry->currency = $account->currency;
                $accountEntry->status = $account->status;
                $accountEntry->balance = $account->balance;
                $accountEntry->name = $account->name;
                $accountEntry->hold_balance = $account->holdBalance;
                $accountEntry->avalaible_balance = $account->avalaibleBalance;
                $accountEntry->save();
            }
        }
        return response()->json([
            'msg' => "success",
            'success' => "true",
            'status' => $status,

        ]);
    }


    public function statments(Request $request, $number)
    {

        $isupdate = false;
        $lastitem = Statment::where('number', '=', $number)->orderBy('record', 'desc')->first();
        if ($lastitem === null) {
            $isupdate = true;
        } else {
            $updatedAt = Carbon::parse(date('Y-m-d H:i:s'));
            $playedAt = Carbon::parse($lastitem->created_at);
            $minutes = $updatedAt->diffInMinutes($playedAt);

            if ($minutes > 30) {
                $isupdate = true;
            }
        }

        $start_date = '2019-01-01';
        $end_date = '2060-01-01';
        $filterdates = $request['dateeee'];

        if (strpos($filterdates, '-') !== false) {
            $lpos = strpos($filterdates, "-");
            $start_date = substr($filterdates, 0, $lpos);
            $end_date = substr($filterdates, $lpos + 1, strlen($filterdates));

            $start_date = Carbon::parse($start_date)->format('Y-m-d');
            $end_date = Carbon::parse($end_date)->format('Y-m-d');

//            print_r($start_date . '++++++' . $end_date);
//            return;
        }


        $statments = Statment::leftJoin('changed_statments', 'changed_statments.record', '=', 'statments.record')
            ->select(
                'statments.*',
                DB::raw('count(changed_statments.id) as record_used_count')
            )
            ->where([
                ['statments.number', '=', $number],
                ["statments.description", "like", "%" . "" . "%"],
                ["statments.post_date", ">", $start_date],
                ["statments.post_date", "<", $end_date]
            ])
            ->groupBy(
                'statments.id',
                'statments.number',
                'statments.record',
                'statments.tran_date',
                'statments.post_date',
                'statments.time',
                'statments.branch',
                'statments.teller',
                'statments.journal',
                'statments.code',
                'statments.amount',
                'statments.balance',
                'statments.debit',
                'statments.correction',
                'statments.description',
                'statments.related_account',
                'statments.created_at',
                'statments.updated_at'
            )->orderBy('record', 'desc')->paginate(40)->appends(request()->except('page'));


//        $statments = Statment::select("*")
//            ->where([
//                ['number', '=', $number],
//                ["description", "like", "%" . "" . "%"],
//                ["post_date", ">", $start_date],
//                ["post_date", "<", $end_date]
//            ])->orderBy('record', 'desc')->paginate(40)->appends(request()->except('page'));

        return view('admin.loan.khanStatments', ['statments' => $statments, 'number' => $number, 'isupdate' => $isupdate]);
    }

    public function syncstatements($number)
    {
        $lastrecord = 0;

        $lastitem = Statment::where('number', '=', $number)->orderBy('record', 'desc')->first();

        if ($lastitem !== null) {
            $lastrecord = $lastitem->record;
        }

        ini_set("allow_url_fopen", 1);
        $sendURL = "https://api.khanbank.com/v1/auth/token?grant_type=client_credentials";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, "Tf1voa2DyyrobYByVFkmvOb4JPtrV2eX" . ":" . "JpXdvgCfqdKhsLkF");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $sendURL);
        $result2 = curl_exec($ch);
        curl_close($ch);
        $obj2 = json_decode($result2);


        $authorization = "Authorization: Bearer $obj2->access_token";
        ini_set("allow_url_fopen", 1);
        $sendURL = "https://api.khanbank.com/v1/statements/" . $number . "?record=" . $lastrecord;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $sendURL);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', $authorization));
        $res = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        $newrecordcount = 0;
        $status = $httpcode;
        if ($httpcode === 200) {
            $response = json_decode($res);
            $transactions = $response->transactions;
            foreach ($transactions as $transaction) {

                $stEntry = new Statment();
                $stEntry->number = $response->account;
                $stEntry->record = isset($transaction->record) ? $transaction->record : '0';
                $stEntry->tran_date = isset($transaction->tranDate) ? $transaction->tranDate : '0';
                $stEntry->post_date = isset($transaction->postDate) ? $transaction->postDate : '0';
                $stEntry->time = isset($transaction->time) ? $transaction->time : '0';
                $stEntry->branch = isset($transaction->branch) ? $transaction->branch : '0';
                $stEntry->teller = isset($transaction->teller) ? $transaction->teller : '0';
                $stEntry->journal = isset($transaction->journal) ? $transaction->journal : '0';
                $stEntry->code = isset($transaction->code) ? $transaction->code : '0';
                $stEntry->amount = isset($transaction->amount) ? $transaction->amount : '0';
                $stEntry->balance = isset($transaction->balance) ? $transaction->balance : '0';
                $stEntry->debit = isset($transaction->debit) ? $transaction->debit : '0';
                $stEntry->correction = isset($transaction->correction) ? $transaction->correction : '0';
                $stEntry->description = isset($transaction->description) ? $transaction->description : '0';
                $stEntry->related_account = isset($transaction->relatedAccount) ? $transaction->relatedAccount : '0';
                $stEntry->save();
                $newrecordcount++;
            }
        }

        return response()->json([
            'msg' => "success",
            'success' => "true",
            'status' => $status,
            'record' => $newrecordcount

        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\KhanAccount $khanAccount
     * @return \Illuminate\Http\Response
     */
    public function show(KhanAccount $khanAccount)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\KhanAccount $khanAccount
     * @return \Illuminate\Http\Response
     */
    public function edit(KhanAccount $khanAccount)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\KhanAccount $khanAccount
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, KhanAccount $khanAccount)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\KhanAccount $khanAccount
     * @return \Illuminate\Http\Response
     */
    public function destroy(KhanAccount $khanAccount)
    {
        //
    }
}
