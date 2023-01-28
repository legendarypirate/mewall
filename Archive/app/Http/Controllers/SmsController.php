<?php

namespace App\Http\Controllers;

use App\Autosms;
use App\Credit;
use App\Invoices;
use App\Lottery;
use App\Massmsg;
use App\Sms;
use App\SmsTemplate;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class SmsController extends Controller
{
    public function manage(Request $request)
    {
        $start_date = '2019-01-01';
        $end_date = '2060-01-01';
        $filterdates = $request['dateeee'];

        if (strpos($filterdates, '-') !== false) {
            $lpos = strpos($filterdates, "-");
            $start_date = substr($filterdates, 0, $lpos);
            $end_date = substr($filterdates, $lpos + 1, strlen($filterdates));

            $start_date = Carbon::parse($start_date)->format('Y-m-d');
            $end_date = Carbon::parse($end_date)->format('Y-m-d');

        }

        $sms = Sms::select("*")
            ->where([
                ["date", ">=", $start_date],
                ["date", "<=", $end_date]
            ])->orderBy('id', 'desc')->paginate(50)->appends(request()->except('page'));


        return view('admin.sms.smsManage', ['sms' => $sms]);
    }

    public function index()
    {
        return view('admin.loan.loanSms');
    }

    public function qpaypaid(Request $request)
    {

        $bill_no = $request->query('bill_no', '0');

//        print_r($bill_no);
//        return;

        $status = 200;
        $msg = "success";
        $success = true;
        $proinfo = "";

        $amount = -1;
        $payed_date = "";
        $pay_status = "";
        if ($bill_no === '0') {
            $status = 305;
            $msg = "fail";
            $success = false;
        } else {
            $data3 = '{
            "client_id": "qpay_altanbumba",
            "client_secret": "Y3pqNGG9",
            "grant_type":"client",
            "refresh_token":""
            }';

            ini_set("allow_url_fopen", 1);
            $sendURL = "https://api.qpay.mn/v1/auth/token";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data3);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL, $sendURL);
            $result2 = curl_exec($ch);
            curl_close($ch);
            $obj2 = json_decode($result2);

            $data5 = '{
              "merchant_id": "ALTANBUMBA",
              "bill_no": "' . $bill_no . '"
            }';

//            $data5 = '{
//              "merchant_id": "TEST_MERCHANT",
//              "bill_no": "' . $bill_no . '"
//            }';

//            $token = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJvcGVyYXRvcl9jb2RlIjoiVEVTVF9NRVJDSEFOVCIsImlkIjoiVEVTVF9NRVJDSEFOVCIsImlhdCI6MTYwOTIxNTY3MCwiZXhwIjoxNjEwMDc5NjcwfQ.xy0hQL_ddsMEuq7q4xFp9ntYpD_H37HkMT4AkF2R6ok';
//            $authorization = "Authorization: Bearer $token";
            $authorization = "Authorization: Bearer $obj2->access_token";
            ini_set("allow_url_fopen", 1);

            $sendURL = "https://api.qpay.mn/v1/bill/check";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data5);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', $authorization));
            curl_setopt($ch, CURLOPT_URL, $sendURL);
            $res = curl_exec($ch);
            $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($httpcode === 200) {
                $response = json_decode($res);
                $pay_status = $response->payment_info->payment_status;
                if ($pay_status === 'PAID') {
                    $payed_date = $response->payment_info->last_payment_date;
                    $amount = $response->payment_info->transactions[0]->transaction_amount;
                    $transaction_no = $response->payment_info->transactions[0]->transaction_no;
                    $invoice = Invoices::where('bill_no', $bill_no)->first();
                    $uphone = "";
                    if ($invoice !== null) {
                        $uphone = $invoice->phone;
                        if ($invoice->status === "1") {
                            $invoice->transaction_no = $transaction_no;
                            $invoice->transaction_date = $payed_date;
                            $invoice->transaction_amount = $amount;
                            $invoice->status = "2";
                            $invoice->save();
                        }
                    } else {
                        $name = $response->merchant_customer_info->name;
                        $register_no = $response->merchant_customer_info->register_no;
                        $email = $response->merchant_customer_info->email;
                        $phone_number = $response->merchant_customer_info->phone_number;
                        $note = $response->merchant_customer_info->note;
                        $uphone = $phone_number;

                        $invoiceEntry = new Invoices();
                        $invoiceEntry->name = $name;
                        $invoiceEntry->number = $bill_no;
                        $invoiceEntry->type = "0";
                        $invoiceEntry->pid = "";
                        $invoiceEntry->date_at = date('Y-m-d H:i:s');
                        $invoiceEntry->amount = $amount;
                        $invoiceEntry->status = "2";
                        $invoiceEntry->honog = "0";
                        $invoiceEntry->invhonog = "0";

                        $invoiceEntry->desc = "";
                        $invoiceEntry->phone = $phone_number;
                        $invoiceEntry->bill_no = $bill_no;
                        $invoiceEntry->credit_id = "";
                        $invoiceEntry->client = "qpay";
                        $invoiceEntry->date = date('Y-m-d H:i:s');
                        $invoiceEntry->transaction_no = $transaction_no;
                        $invoiceEntry->transaction_date = $payed_date;
                        $invoiceEntry->transaction_amount = $amount;
                        $invoiceEntry->khuu = 0;
                        $invoiceEntry->aldangi = 0;
                        $invoiceEntry->save();
                    }

                    if ($uphone !== "" && $invoice !== null) {
                        $message = "Tany tulult amjilttai hiigdlee. Tand bayrlalaa.";
                        $bdata = explode("-", $bill_no);
                        $btype = $bdata[1];
                        $credit = Credit::where('number', $invoice->number)->first();
                        $guch_honog_codes = "WBS1,AUS1,WBS5,AUS4,WM61,WM81,CBS1,CBS5,CB61,CB71,CB81,CBQ1,WM71";
                        $hurimt_huu_codes = "WBS2,WB12,AUS2,AUS3,WBS6,WBS7,WBS8,CBS2,CBS6,CBS7,CBS8,CBQ2";
                        $hasalt_codes = "WBS3,CBS3,CBQ3";
                        $haalt_codes = "WBS4,WBS9,CBS4,CBQ4";

                        $proinfo = $proinfo . 'orson';


                        //omno ni hasaltiin medeelel awsan bj boloh uchiraas status zowhon 2 uyd l hasal hiine
                        if ($invoice->status === '2' && (strpos($guch_honog_codes, $btype) !== false
                                || strpos($hurimt_huu_codes, $btype) !== false
                                || strpos($hasalt_codes, $btype) !== false
                                || strpos($haalt_codes, $btype) !== false)) {

                            if (strpos($guch_honog_codes, $btype) !== false || strpos($hurimt_huu_codes, $btype) !== false) {
                                $lnumber = 0;
                                $lott = Lottery::where('status', '=', 'N')->orderBy('id', 'desc')->first();
                                if ($lott !== null) {
                                    $lnumber = $lott->number;
                                }
                                $lnumber = $lnumber + 1;
                                $nnn = "";
                                for ($x = 0; $x < 6 - strlen($lnumber . ''); $x++) {
                                    $nnn = $nnn . '0';
                                }
                                $nnn = $nnn . $lnumber;
                                $lEntry = new Lottery();
                                $lEntry->number = $lnumber;
                                $lEntry->phone = $uphone;
                                $lEntry->msg = '';
                                $lEntry->bill_no = $bill_no;
                                $lEntry->status = 'N';
                                $lEntry->save();
                            }


                            //procredit bichilt start
                            $minusdata = '';
                            if (strpos($guch_honog_codes, $btype) !== false) {
                                $minusdata = '{
                                    "id": 423,
                                    "dept_id": 192,
                                    "api_user": "altanbumba",
                                    "psswrd": "PqJXg5toT3",
                                    "credit_id": "' . $invoice->credit_id . '",
                                    "zeeld": "0",
                                    "khuu": "' . $amount . '",
                                    "hetersenkhuu": "0",
                                    "useddays": "30"
                                }';
                            } else if (strpos($hurimt_huu_codes, $btype) !== false) {
                                $aldangi = $invoice->aldangi;
                                $khuu = $invoice->khuu;
                                if (number_format($amount, 0) === number_format(($aldangi + $khuu), 0)) {

                                    $minusdata = '{
                                        "id": 423,
                                        "dept_id": 192,
                                        "api_user": "altanbumba",
                                        "psswrd": "PqJXg5toT3",
                                        "credit_id": "' . $invoice->credit_id . '",
                                        "zeeld": "0",
                                        "khuu": "' . $khuu . '",
                                        "hetersenkhuu": "' . $aldangi . '",
                                        "useddays": "' . $invoice->honog . '"
                                    }';
                                }
                            } else if (strpos($hasalt_codes, $btype) !== false) {

                                $minusdata = '{
                                        "id": 423,
                                        "dept_id": 192,
                                        "api_user": "altanbumba",
                                        "psswrd": "PqJXg5toT3",
                                        "credit_id": "' . $invoice->credit_id . '",
                                        "zeeld": "' . $amount . '",
                                        "khuu": "0",
                                        "hetersenkhuu": "0",
                                        "useddays": "0"
                                    }';

                            } else if (strpos($haalt_codes, $btype) !== false) {
                                $date_current = new DateTime(date("Y/m/d"));
                                $datetime1 = new DateTime($credit->duusah_honog);
                                $interval = $datetime1->diff($date_current);
                                $days = $interval->format('%a');
                                $curhonog = 0;
                                if ($credit->khetersenkhonog === '0')
                                    $curhonog = (30 - ($days));
                                else
                                    $curhonog = $credit->khetersenkhonog + 30;
//
//                                print_r($curhonog . '==' . $invoice->honog);
//                                return;
                                if ($curhonog . '' === $invoice->honog) {
//                                    $zeeld = $amount - ($invoice->aldangi + $invoice->khuu);
                                    $zeeld = $amount - ($invoice->aldangi + $credit->huramtlagdsankhuu);
//                                    $zeeld = $amount - $credit->huramtlagdsankhuu;

//                                    print_r('aldangi:'.$invoice->aldangi.' huramtlagdsankhuu:'.$credit->huramtlagdsankhuu . '= =' . number_format((-1 * $credit->zeeluldegdel), 0) . '= =' . number_format($zeeld, 0));
//                                    return;
                                    if (number_format((-1 * $credit->zeeluldegdel), 0) === number_format($zeeld, 0)) {
//                                        $khuu = 0;
//                                        if (!$credit->khetersenkhonog === '0') {
//                                            $khuu = $invoice->khuu;
//                                        }
                                        $minusdata = '{
                                            "id": 423,
                                            "dept_id": 192,
                                            "api_user": "altanbumba",
                                            "psswrd": "PqJXg5toT3",
                                            "credit_id": "' . $invoice->credit_id . '",
                                            "zeeld": "' . $zeeld . '",
                                            "khuu": "' . $credit->huramtlagdsankhuu . '",
                                            "hetersenkhuu": "' . $invoice->aldangi . '",
                                            "useddays": "' . $invoice->honog . '"
                                        }';
                                    }
                                }
                            }
                            if (strlen($minusdata) > 0) {
                                ini_set("allow_url_fopen", 1);
                                $sendURLMinus = "https://procreditor.mn/api/api.php";
                                $chminus = curl_init();
                                curl_setopt($chminus, CURLOPT_SSL_VERIFYPEER, false);
                                curl_setopt($chminus, CURLOPT_RETURNTRANSFER, true);
                                curl_setopt($chminus, CURLOPT_POSTFIELDS, $minusdata);
                                curl_setopt($chminus, CURLOPT_URL, $sendURLMinus);
                                $minusresult = curl_exec($chminus);
                                curl_close($chminus);
                                $mresult = json_decode($minusresult);
                                if ($mresult->status === 'OK') {
                                    if ($credit !== null) {
                                        if (strpos($guch_honog_codes, $btype) !== false || strpos($hurimt_huu_codes, $btype) !== false) {
                                            $credit->duusah_honog = $mresult->result->duusah;
                                            $credit->khuu = $mresult->result->khuumoney;
                                            $credit->aldangi = $mresult->result->aldangi;
                                            $credit->secondphone = $credit->secondphone;
                                            $credit->save();
                                        } else if (strpos($hasalt_codes, $btype) !== false) {
                                            $credit->zeeluldegdel = -1 * ((-1 * $credit->zeeluldegdel) - $mresult->result->zeeld);
                                            $credit->amount = $credit->amount - $mresult->result->zeeld;
                                            $credit->save();
                                        } else if (strpos($haalt_codes, $btype) !== false) {
                                            if (isset($mresult->result->duusah))
                                                $credit->duusah_honog = $mresult->result->duusah;
                                            if (isset($mresult->result->khuumoney))
                                                $credit->khuu = $mresult->result->khuumoney;
                                            if (isset($mresult->result->aldangi))
                                                $credit->aldangi = $mresult->result->aldangi;
                                            $credit->save();
                                        }
                                    }
                                    $invoice->status = "3";
                                    $invoice->save();
                                }
//                            procredit bichilt end
                            }
                        }
                        if ($btype === 'WB11') {
                            $message = "Таny " . $invoice->number . " zeeliin " . $invoice->invhonog . "-honogiin " . number_format($invoice->amount, 1) . " tug amjilttai tulugdluu.";
                        }
                        if ($btype === 'WB12') {
                            $message = "Таny " . $invoice->number . " zeeliin tohiroltscon " . number_format($invoice->amount, 1) . " tug amjilttai tulugdluu.";
                        }
                        if ($btype === 'WBS1') {
                            $message = "Tany " . $invoice->number . " gereet zeeliin 30 honogiin huu " . number_format($invoice->amount, 1) . " tug amjilttai tulugdluu. Tand bayrlalaa.";
                        }
                        if ($btype === 'WBS2') {
                            $message = "Tany " . $invoice->number . " gereet zeeliin hurimtlagdsan huu " . number_format($invoice->amount, 1) . " tug amjilttai tulugdluu. Tand bayrlalaa.";
                        }
                        if ($btype === 'WBS3') {
//                            $message = "Tany " . $invoice->number . " gereet zeeliin uldegdlees " . number_format($invoice->amount, 1) . "tug amjilttai hasagdaj " . number_format((-1 * $credit->zeeluldegdel) - $invoice->amount, 1) . " tug bolloo.";
                            $message = "Tany " . $invoice->number . " gereet zeeliin uldegdlees " . number_format($invoice->amount, 1) . "tug amjilttai hasagdaj " . number_format((-1 * $credit->zeeluldegdel), 1) . " tug bolloo.";

                        }
                        if ($btype === 'WBS4') {
                            $message = "Tany " . $invoice->number . "gereet zeeliin uldegdel " . number_format($invoice->amount, 1) . " tug amjilttai tulugduj tanii zeel haagdlaa. Tand bayrlalaa.";
                        }
                        if ($btype === 'WBS5') {
                            $message = "Tany " . $invoice->number . " gereet zeeliin 30 honogiin huu " . number_format($invoice->amount, 1) . " tug amjilttai tulugdluu. Tand bayrlalaa.";
                        }
                        if ($btype === 'WBS6') {
                            //hurimtlagdsan towch 61-69 honog
                            $message = "Tany " . $invoice->number . " gereet zeeliin " . $invoice->honog . " honogiin huu " . number_format($invoice->amount, 1) . " tug amjilttai tulugdluu. Tand bayrlalaa.";
                        }
                        if ($btype === 'WBS7') {
                            //hurimtlagdsan towch 71-89 honog
                            $message = "Tany " . $invoice->number . " gereet zeeliin " . $invoice->honog . " honogiin huu " . number_format($invoice->amount, 1) . " tug amjilttai tulugdluu. Tand bayrlalaa.";
                        }
                        if ($btype === 'WBS8') {
                            //hurimtlagdsan towch 90-ees deesh
                            $message = "Tany " . $invoice->number . " gereet zeeliin " . $invoice->honog . " honogiin huu " . number_format($invoice->amount, 1) . " tug amjilttai tulugdluu. Tand bayrlalaa.";
                        }
                        if ($btype === 'WBS9') {
                            //90ees deesh honog haalt towch
                        }
                        if ($btype === 'WM61') {
                            $message = "Tany" . $invoice->number . " gereet zeeliin 30 honogiin huu " . number_format($invoice->amount, 1) . " tug amjilttai tulugdluu. Tand bayrlalaa.";
                        }
                        if ($btype === 'WM71') {
                            $message = "Tany" . $invoice->number . " gereet zeeliin 30 honogiin huu " . number_format($invoice->amount, 1) . " tug amjilttai tulugdluu. Tand bayrlalaa.";
                        }
                        if ($btype === 'WM81') {
                            $message = "Tany" . $invoice->number . " gereet zeeliin 30 honogiin huu " . number_format($invoice->amount, 1) . " tug amjilttai tulugdluu. Tand bayrlalaa.";
                        }

                        //chatbot
                        if ($btype === 'CBS1' || $btype === 'CBQ1') {
                            $message = "Tany " . $invoice->number . " gereet zeeliin 30 honogiin huu " . number_format($invoice->amount, 1) . " tug amjilttai tulugdluu. Tand bayrlalaa.";
                        }
                        if ($btype === 'CBS2' || $btype === 'CBQ2') {
                            $message = "Tany " . $invoice->number . " gereet zeeliin hurimtlagdsan huu " . number_format($invoice->amount, 1) . " tug amjilttai tulugdluu. Tand bayrlalaa.";
                        }
                        if ($btype === 'CBS3' || $btype === 'CBQ3') {
                            $message = "Tany " . $invoice->number . " gereet zeeliin uldegdlees " . number_format($invoice->amount, 1) . "tug amjilttai hasagdaj " . number_format((-1 * $credit->zeeluldegdel), 1) . " tug bolloo.";
                        }
                        if ($btype === 'CBS4' || $btype === 'CBQ4') {
                            $message = "Tany " . $invoice->number . "gereet zeeliin uldegdel " . number_format($invoice->amount, 1) . " tug amjilttai tulugduj tanii zeel haagdlaa. Tand bayrlalaa.";
                        }
                        if ($btype === 'CBS5') {
                            $message = "Tany " . $invoice->number . " gereet zeeliin 30 honogiin huu " . number_format($invoice->amount, 1) . " tug amjilttai tulugdluu. Tand bayrlalaa.";
                        }
                        if ($btype === 'CBS6') {
                            $message = "Tany " . $invoice->number . " gereet zeeliin " . $invoice->honog . " honogiin huu " . number_format($invoice->amount, 1) . " tug amjilttai tulugdluu. Tand bayrlalaa.";
                        }
                        if ($btype === 'CBS61') {
                            $message = "Tany" . $invoice->number . " gereet zeeliin 30 honogiin huu " . number_format($invoice->amount, 1) . " tug amjilttai tulugdluu. Tand bayrlalaa.";
                        }
                        if ($btype === 'CBS71') {
                            $message = "Tany" . $invoice->number . " gereet zeeliin 30 honogiin huu " . number_format($invoice->amount, 1) . " tug amjilttai tulugdluu. Tand bayrlalaa.";
                        }
                        if ($btype === 'CBS81') {
                            $message = "Tany" . $invoice->number . " gereet zeeliin 30 honogiin huu " . number_format($invoice->amount, 1) . " tug amjilttai tulugdluu. Tand bayrlalaa.";
                        }
                        if ($btype === 'CBS7') {
                            $message = "Tany " . $invoice->number . " gereet zeeliin " . $invoice->honog . " honogiin huu " . number_format($invoice->amount, 1) . " tug amjilttai tulugdluu. Tand bayrlalaa.";
                        }
                        if ($btype === 'CBS8') {
                            $message = "Tany " . $invoice->number . " gereet zeeliin " . $invoice->honog . " honogiin huu " . number_format($invoice->amount, 1) . " tug amjilttai tulugdluu. Tand bayrlalaa.";
                        }

                        $sendURL = "https://www.altanbumba.com/sendsms.php?phone=" . urlencode($uphone) . "&msg=" . urlencode($message);
                        ini_set("allow_url_fopen", 1);
                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
                        curl_setopt($ch, CURLOPT_URL, $sendURL);
                        $res = curl_exec($ch);
                        curl_close($ch);
                    }
                }
            } else {
                $status = $httpcode;
                $msg = "fail";
                $success = false;
            }
        }

        return response()->json([
            'msg' => $msg,
            'success' => $success,
            'status' => $status,
            'paid' => $pay_status,
            'amount' => $amount,
            'payed_date' => $payed_date,
            'procreditor' => $proinfo
        ]);
    }


    public function invoicedetail(Request $request)
    {
        $type = $request->type;
        $credit_id = $request->credit_id;
        $results = [];
        if ($type === '1') {
            $results = Invoices::select("*")
                ->where([
                    ["honog", ">", -1],
                    ["honog", "<", 60],
                    ["credit_id", "=", $credit_id],
                ])
                ->get();
        } else if ($type === '2') {
            $results = Invoices::select("*")
                ->where([
                    ["honog", ">", 59],
                    ["honog", "<", 90],
                    ["credit_id", "=", $credit_id],
                ])
                ->get();
        } else if ($type === '3') {
            $results = Invoices::select("*")
                ->where([
                    ["honog", ">", -89],
                    ["credit_id", "=", $credit_id],
                ])
                ->get();
        }

        return response()->json([
            'msg' => 'success',
            'success' => true,
            'results' => $results,
            'status' => 200
        ]);

    }


    public function createotherinvoice(Request $request)
    {
        $data3 = '{
        "client_id": "qpay_altanbumba",
        "client_secret": "Y3pqNGG9",
        "grant_type":"client",
        "refresh_token":""
        }';

        ini_set("allow_url_fopen", 1);
        $sendURL = "https://api.qpay.mn/v1/auth/token";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data3);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_URL, $sendURL);
        $result2 = curl_exec($ch);
        curl_close($ch);
        $obj2 = json_decode($result2);

        $today = date("Y-m-d");
        $name = $request->name;
        $number = $request->number;
        $credit_id = $request->credit_id;
        $assessment = $request->assessment;
        $phone = $request->phone;
        $pid = rand(10000000, 99999999);
        $curhonog = $request->curhonog;
        $billtype = "WB33";
        $khetersenkhonog = $request->khetersenkhonog;
        $amount = round($request->amount, 2);
        $type = "10";
        if ($khetersenkhonog === '0') {
            $desc = 'Тохиролцсон хүү: 30 хоног.';
            $billtype = "WB11";
            $type = 5;
        } else {
            $desc = 'Тохиролцсон хүү: Хуримтлагдсан хоног.';
            $billtype = "WB12";
            $type = 6;
        }

        $bill_no = $number . '-' . $billtype . '-' . $pid;
        $data5 = '{
          "template_id": "ALTANBUMBA_INVOICE",
          "merchant_id": "ALTANBUMBA",
          "branch_id": "1",
          "pos_id": "1",
          "receiver": {
            "id": "' . $name . '",
            "register_no": "ddf",
            "name": "Central brnach",
            "email": "info@info.mn",
            "phone_number":"99888899",
            "note" : "davaa"
          },
          "transactions":[{
            "description":"asdfasdf",
            "amount":10000,
            "accounts":[{
                "bank_code":"050000",
                "name":"davaa",
                "number":"5084107767",
                "currency":"MNT"
            }]
          }],
          "bill_no": "' . $bill_no . '",
          "date":"' . $today . '",
          "description":"' . $desc . '",
          "amount":' . $amount . ',
          "btuk_code":"",
          "vat_flag": "0"
        }';

        $authorization = "Authorization: Bearer $obj2->access_token";
        ini_set("allow_url_fopen", 1);
        $sendURL = "https://api.qpay.mn/v1/bill/create";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data5);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', $authorization));
        curl_setopt($ch, CURLOPT_URL, $sendURL);
        $res = curl_exec($ch);
        curl_close($ch);
        $pol = json_decode($res);
        $payid = "";
        if (isset($pol->qPay_deeplink)) {
            $dataxx = $pol->qPay_deeplink;
            foreach ($dataxx as $pols) {
                $payid = $pol->qPay_shortUrl;
            }
        }

        $user = Auth::user();
        $invoiceEntry = new Invoices();
        $invoiceEntry->name = $name;
        $invoiceEntry->number = $number;
        $invoiceEntry->type = $type;
        $invoiceEntry->pid = $payid;
        $invoiceEntry->date_at = date('Y-m-d H:i:s');
        $invoiceEntry->amount = $amount;
        $invoiceEntry->status = "1";
        $invoiceEntry->honog = $curhonog;
        $invoiceEntry->invhonog = $request->honog;
        $invoiceEntry->desc = $desc;
        $invoiceEntry->phone = $phone;
        $invoiceEntry->bill_no = $bill_no;
        $invoiceEntry->credit_id = $credit_id;
        $invoiceEntry->client = $user->name;
        $invoiceEntry->date = $today;
        $invoiceEntry->transaction_no = "";
        $invoiceEntry->transaction_date = "";
        $invoiceEntry->transaction_amount = "";
        $invoiceEntry->khuu = 0;
        $invoiceEntry->aldangi = 0;
        $invoiceEntry->save();

        return response()->json([
            'msg' => 'success',
            'tug' => number_format($amount, 1),
            'link' => $payid,
            'success' => true,
            'status' => 200
        ]);

    }


    public function createinvoice(Request $request)
    {
        $data3 = '{
        "client_id": "qpay_altanbumba",
        "client_secret": "Y3pqNGG9",
        "grant_type":"client",
        "refresh_token":""
        }';

        ini_set("allow_url_fopen", 1);
        $sendURL = "https://api.qpay.mn/v1/auth/token";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data3);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_URL, $sendURL);
        $result2 = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        $obj2 = json_decode($result2);


        $type = $request->type;
        $today = date("Y-m-d");
        $name = $request->name;
        $number = $request->number;
        $credit_id = $request->credit_id;
        $assessment = $request->assessment;
        $phone = $request->phone;
        $khetersenkhonog = $request->khetersenkhonog;
        $pid = rand(10000000, 99999999);
        $curhonog = $request->curhonog;
        $billtype = "WBS0";

//2-30honog 1-hurimtlagdsan 3-haalt 4-hasalt

        if ($type === '1') {
//            hurimtlagdsan
            $amount1 = $request->khuu;
            $amount = round($amount1, 2);

        } else if ($type === '2') {
            //30honog
            if ($khetersenkhonog === '0') {
//                $uldegdel = $request->zeeluldegdel;
//                $amnt = ($uldegdel * $assessment) / 100;
//                $amount = round($amnt, 2);
                //honog hetreegvi zeel deer 24 honogtoi bol 30 honogiin nehemjleh ni khuu field-deer irj baigaa
                $amount = round($request->khuu, 2);
            } else {
                //1-30 honog hvrtel tuhain odor bvriin huug nemegdvvlne Jich:30 honogoos deesh nemegdehgvi.
                $amount1 = $request->huramtlagdsankhuu;
                $amount = round($amount1, 2);
            }
        } else if ($type === '3' || $type === '4') {
            $amount1 = $request->amount;
            $amount = round($amount1, 2);
        }
        if ($type === '1') {
            $desc = 'Хуримтлагдсан хүү төлөлт';
            $billtype = "WBS2";
        } else if ($type === '2') {
            $desc = '30 хоногийн төлөлт';
            $billtype = "WBS1";
        } else if ($type === '3') {
            $desc = 'Зээл хаалт';
            $billtype = "WBS4";
        } else if ($type === '4') {
            $billtype = "WBS3";
            $desc = 'Зээл хасалт';
        }

        if ($type === '1') {
            //hurimtlagdsan towch
            if ($curhonog >= 61 && $curhonog <= 69) {
                $billtype = "WBS6";
            } else if ($curhonog >= 71 && $curhonog <= 89) {
                $billtype = "WBS7";
            } else if ($curhonog > 90) {
                $billtype = "WBS8";
            }
        } else if ($type === '2') {
            //30 honogiin towch
            if ($curhonog >= 26 && $curhonog <= 29) {
                $billtype = "WBS5";
            } else if ($curhonog >= 61 && $curhonog <= 69) {
                $billtype = "WM61";
            } else if ($curhonog >= 71 && $curhonog <= 89) {
                $billtype = "WM71";
            } else if ($curhonog > 90) {
                $billtype = "WM81";
            }
        } else if ($type === '3') {
//            if ($curhonog > 90) {
//                $billtype = "WBS9";
//            }

        }

        $bill_no = $number . '-' . $billtype . '-' . $pid;
        $data5 = '{
          "template_id": "ALTANBUMBA_INVOICE",
          "merchant_id": "ALTANBUMBA",
          "branch_id": "1",
          "pos_id": "1",
          "receiver": {
            "id": "' . $name . '",
            "register_no": "ddf",
            "name": "Central brnach",
            "email": "info@info.mn",
            "phone_number":"99888899",
            "note" : "davaa"
          },
          "transactions":[{
            "description":"asdfasdf",
            "amount":10000,
            "accounts":[{
                "bank_code":"050000",
                "name":"davaa",
                "number":"5084107767",
                "currency":"MNT"
            }]
          }],
          "bill_no": "' . $bill_no . '",
          "date":"' . $today . '",
          "description":"' . $desc . '",
          "amount":' . $amount . ',
          "btuk_code":"",
          "vat_flag": "0"
        }';

        $authorization = "Authorization: Bearer $obj2->access_token";
        ini_set("allow_url_fopen", 1);
        $sendURL = "https://api.qpay.mn/v1/bill/create";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data5);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', $authorization));
        curl_setopt($ch, CURLOPT_URL, $sendURL);
        $res = curl_exec($ch);
        curl_close($ch);
        $pol = json_decode($res);
        $payid = "";
        if (isset($pol->qPay_deeplink)) {
            $dataxx = $pol->qPay_deeplink;
            foreach ($dataxx as $pols) {
                $payid = $pol->qPay_shortUrl;
            }
        }

        $user = Auth::user();
        $invoiceEntry = new Invoices();
        $invoiceEntry->name = $name;
        $invoiceEntry->number = $number;
        $invoiceEntry->type = $type;
        $invoiceEntry->pid = $payid;
        $invoiceEntry->date_at = date('Y-m-d H:i:s');
        $invoiceEntry->amount = $amount;
        $invoiceEntry->status = "1";
        $invoiceEntry->honog = $curhonog;
        $invoiceEntry->invhonog = $curhonog;
        $invoiceEntry->desc = $desc;
        $invoiceEntry->phone = $phone;
        $invoiceEntry->bill_no = $bill_no;
        $invoiceEntry->credit_id = $credit_id;
        $invoiceEntry->client = $user->name;
        $invoiceEntry->date = $today;
        $invoiceEntry->transaction_no = "";
        $invoiceEntry->transaction_date = "";
        $invoiceEntry->transaction_amount = "";
        $invoiceEntry->khuu = $request->guch_khuu;
        $invoiceEntry->aldangi = $request->aldangi;
        $invoiceEntry->save();

        return response()->json([
            'msg' => 'success',
            'tug' => number_format($amount, 1),
            'link' => $payid,
            'success' => true,
            'status' => 200
        ]);

    }


    public function createinvoice_auto($request)
    {
        $data3 = '{
        "client_id": "qpay_altanbumba",
        "client_secret": "Y3pqNGG9",
        "grant_type":"client",
        "refresh_token":""
        }';

        ini_set("allow_url_fopen", 1);
        $sendURL = "https://api.qpay.mn/v1/auth/token";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data3);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_URL, $sendURL);
        $result2 = curl_exec($ch);
        curl_close($ch);
        $obj2 = json_decode($result2);

        $today = date("Y-m-d");
        $name = $request->name;
        $number = $request->number;
        $credit_id = $request->credit_id;
        $assessment = $request->assessment;
        $phone = $request->phone;
        $khetersenkhonog = $request->khetersenkhonog;
        $pid = rand(10000000, 99999999);
        $curhonog = $request->curhonog;
        $billtype = "AUS0";
        //30honog
        $amount = round($request->khuu, 2);

        $desc = "Төлөлт";
        if ($request->curhonog === 30) {
            $billtype = "AUS1";
            $desc = "Автомат 30 хоног";
        } else if ($request->curhonog === 45) {
            $billtype = "AUS2";
            $desc = "Автомат 45 хоног";
        } else if ($request->curhonog === 90) {
            $billtype = "AUS3";
            $desc = "Автомат 90 хоног";
        } else if ($request->curhonog === 27) {
            $billtype = "AUS4";
            $desc = "Автомат 30 хоног";
        }

        $bill_no = $number . '-' . $billtype . '-' . $pid;

        $data5 = '{
          "template_id": "ALTANBUMBA_INVOICE",
          "merchant_id": "ALTANBUMBA",
          "branch_id": "1",
          "pos_id": "1",
          "receiver": {
            "id": "' . $name . '",
            "register_no": "ddf",
            "name": "Central brnach",
            "email": "info@info.mn",
            "phone_number":"99888899",
            "note" : "davaa"
          },
          "transactions":[{
            "description":"asdfasdf",
            "amount":10000,
            "accounts":[{
                "bank_code":"050000",
                "name":"davaa",
                "number":"5084107767",
                "currency":"MNT"
            }]
          }],
          "bill_no": "' . $bill_no . '",
          "date":"' . $today . '",
          "description":"' . $desc . '",
          "amount":' . $amount . ',
          "btuk_code":"",
          "vat_flag": "0"
        }';

        $authorization = "Authorization: Bearer $obj2->access_token";
        ini_set("allow_url_fopen", 1);
        $sendURL = "https://api.qpay.mn/v1/bill/create";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data5);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', $authorization));
        curl_setopt($ch, CURLOPT_URL, $sendURL);
        $res = curl_exec($ch);
        curl_close($ch);
        $pol = json_decode($res);
        $payid = "";
        if (isset($pol->qPay_deeplink)) {
            $dataxx = $pol->qPay_deeplink;
            foreach ($dataxx as $pols) {
                $payid = $pol->qPay_shortUrl;
            }
        }

        $user = Auth::user();
        $invoiceEntry = new Invoices();
        $invoiceEntry->name = $name;
        $invoiceEntry->number = $number;
        $invoiceEntry->type = 6;
        $invoiceEntry->pid = $payid;
        $invoiceEntry->date_at = date('Y-m-d H:i:s');
        $invoiceEntry->amount = $amount;
        $invoiceEntry->status = "1";
        $invoiceEntry->honog = $curhonog;
        $invoiceEntry->invhonog = $curhonog;
        $invoiceEntry->desc = $desc;
        $invoiceEntry->phone = $phone;
        $invoiceEntry->bill_no = $bill_no;
        $invoiceEntry->credit_id = $credit_id;
        $invoiceEntry->client = $user->name;
        $invoiceEntry->date = $today;
        $invoiceEntry->transaction_no = "";
        $invoiceEntry->transaction_date = "";
        $invoiceEntry->transaction_amount = "";
        $invoiceEntry->khuu = $request->khuu_guch;
        $invoiceEntry->aldangi = $request->aldangi;
        $invoiceEntry->save();
        $res = new \stdClass();
        $res->success = true;
        $res->tug = number_format($amount, 1);
        $res->link = $payid;
        return $res;

    }


    //audo sms action
    public function autosms(Request $request)
    {
        $status = 301;
        $msg = "fail";
        $smss = [];
        $databirth = 0;
        $issent = Autosms::whereDate('created_at', '=', date("Y-m-d"))->first();
        if ($issent === null) {
            $results = Credit::select("*")
                ->where([
                    ["honog", ">", -1],
                ])->get();
            if (count($results) > 0) {
                $check = $results[0];
                $today = date("Y-m-d H:i:s");
                $datetime2 = new DateTime($today);
                $datetimecheck = new DateTime($check->created_at);
                $checkinterval = $datetime2->diff($check->created_at);
                $cdays = $checkinterval->format('%a');
                if ($cdays === '0') {
                    $status = 200;
                    $msg = "success";
                    $data1 = 0;
                    $data2 = 0;
                    $data3 = 0;
                    $data4 = 0;

                    $date_current = new DateTime(date("Y/m/d"));
                    foreach ($results as $result) {
                        $datetime1 = new DateTime($result->duusah_honog);
                        $interval = $datetime1->diff($date_current);
                        $days = $interval->format('%a');
                        $curdays = 0;
                        if ($result->khetersenkhonog === '0')
                            $curdays = (30 - ($days));
                        else
                            $curdays = $result->khetersenkhonog + 30;

                        $register = $result->registernumber;
                        if (strlen($register) === 12) {
                            $month = Str::substr($register, 4, 2);
                            $day = Str::substr($register, 6, 2);
                            if (date("m") === $month && date("d") === $day) {
//                                birthday
                                $birthsms = "Erkhem hariltsagch tand tursun udriin mend hurgey. Bidniig songon uilchluuldeg hariltsagch tand bayrlalaa. AltanBumba";
                                $sendURL = "https://www.altanbumba.com/sendsms.php?phone=" . urlencode($result->phone) . "&msg=" . urlencode($birthsms);
                                ini_set("allow_url_fopen", 1);
                                $chbirth = curl_init();
                                curl_setopt($chbirth, CURLOPT_SSL_VERIFYPEER, false);
                                curl_setopt($chbirth, CURLOPT_RETURNTRANSFER, true);
                                curl_setopt($chbirth, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
                                curl_setopt($chbirth, CURLOPT_URL, $sendURL);
                                $res = curl_exec($chbirth);
                                curl_close($chbirth);
                                $databirth++;
                            }
                        }

                        if ($curdays === 27 || $curdays === 30 || $curdays === 45 || $curdays === 90) {
                            if ($result->phone !== '') {
                                $result->curhonog = $curdays;
                                $result->khuu_guch = $result->khuu;
                                $honog = $result->khetersenkhonog + 30;
                                $aldangi = $result->aldangi;
                                $khuu = $result->khuu + $aldangi;
                                $duusah_honog = str_replace('/', '.', $result->duusah_honog);
                                $result->honog = $honog;
                                $result->khuu = $khuu;
                                $result->name = $result->firstname;
                                $invoicedata = $this->createinvoice_auto($result);
                                $result->tug = $invoicedata->tug;
                                $message = "";
                                if (strlen($invoicedata->link) > 0) {
                                    if ($curdays === 27) {
                                        $message = "Tany " . $result->number . " zeeliin 30 honogiin huu tuluh udur " . $duusah_honog . ", huu - " . $invoicedata->tug . "tuguu hugatsaand ni " . str_replace(' ', '', $invoicedata->link) . " holboosoor tulnu uu. AltanBumba";
                                    } else if ($curdays === 30) {
                                        $message = "Tany " . $result->number . " zeeliin 30 honogiin " . $invoicedata->tug . "tug huug " . str_replace(' ', '', $invoicedata->link) . " holboosoor tulnu uu. AltanBumba";
                                    } else if ($curdays === 45) {
//                                        omno ni 60 honog deer ywdag baisan
                                        $message = "Tany " . $result->number . " zeeliin huleelgiin hugatsaa duussan tul ta 45 honogiin " . $invoicedata->tug . "tug huug " . str_replace(' ', '', $invoicedata->link) . " holboosoor tulnu uu. AltanBumba";
                                    } else if ($curdays === 90) {
                                        $message = "Tany " . $result->number . " zeeliin huu tuluh hugatsaa hetersen tul 90 honogiin " . $invoicedata->tug . "tug huug " . str_replace(' ', '', $invoicedata->link) . " tulnu uu. AltanBumba";
                                    }
                                    $result->message = $message;

                                    $sendURL = "https://www.altanbumba.com/sendsms.php?phone=" . urlencode($result->phone) . "&msg=" . urlencode($message);

                                    ini_set("allow_url_fopen", 1);
                                    $chs = curl_init();
                                    curl_setopt($chs, CURLOPT_SSL_VERIFYPEER, false);
                                    curl_setopt($chs, CURLOPT_RETURNTRANSFER, true);
                                    curl_setopt($chs, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
                                    curl_setopt($chs, CURLOPT_URL, $sendURL);
                                    $res = curl_exec($chs);
                                    curl_close($chs);
                                    $result->smsresult = $res;

                                    array_push($smss, $result);

                                    if ($curdays === 25)
                                        $data1++;
                                    if ($curdays === 30)
                                        $data2++;
                                    if ($curdays === 45)
                                        $data3++;
                                    if ($curdays === 90)
                                        $data4++;
                                }
                            }
                        }
                    }

                    $user = Auth::user();
                    $entry = new Autosms();
                    $entry->submituser = $user->name;
                    $entry->submitdate = date('Y-m-d H:i:s');
                    $entry->sdata = $data1 . "##" . $data2 . "##" . $data3 . "##" . $data4 . "##" . $databirth;
                    $entry->save();

                } else {
                    $msg = "Өгөгдөл хуучин байна шинэчилэх дарна уу.";
                }
            }
            $success = true;
        } else {
            $msg = "Авто илгээх дарагдсан байна.";
        }


        if ($status != 200) {
            $success = false;
        }
        return response()->json([
            'msg' => $msg,
            'success' => $success,
            'status' => $status,
            'smss' => $smss,
            'birth' => $databirth
        ]);

    }


    public function smstemplates()
    {
        $results = SmsTemplate::select("*")->orderBy("created_at", "desc")->get();
        return view('admin.sms.smsTemplate', ['results' => $results]);
    }

    public function createtemplate(Request $request)
    {
        $zname = $request->zname;
        $zmsg = $request->zmsg;
        $ztype = $request->ztype;
        $user = Auth::user();

        if ($ztype === '2') {
            if (SmsTemplate::where('type', '=', $ztype)->exists()) {
                return response()->json([
                    'msg' => 'fail',
                    'success' => false,
                    'status' => 303
                ]);
            }
        }

        $entry = new SmsTemplate();
        $entry->msg = $zmsg;
        $entry->name = $zname;
        $entry->type = $ztype;
        $entry->user = $user->name;
        $entry->save();

        return response()->json([
            'msg' => 'success',
            'success' => true,
            'status' => 200
        ]);

    }


    public function removetemplate(Request $request)
    {
        $id = $request->id;
        $sDelete = SmsTemplate::find($id);
        $sDelete->delete();

        return response()->json([
            'msg' => 'success',
            'success' => true,
            'status' => 200
        ]);
    }

    public function filteredtemplates(Request $request)
    {
        $type = $request->type;
        $results = SmsTemplate::select("*")->where('type', $type)->orderBy("created_at", "desc")->get();
        return response()->json([
            'msg' => 'success',
            'results' => $results,
            'success' => true,
            'status' => 200
        ]);
    }


    //mass msg
    function massmsg(Request $request)
    {
        $title = "Import Spreadsheet";
        $template = url('documents/template-masssms.xlsx');
        if ($_POST) {
            $request->validate([
                'file1' => 'required|mimes:xlsx|max:10000'
            ]);

            $file = $request->file('file1');

//            $name = time() . '.xlsx';
            $name = 'massexcel.xlsx';
            $path = public_path('documents' . DIRECTORY_SEPARATOR);

            if ($file->move($path, $name)) {
                $inputFileName = $path . $name;
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
                $reader->setReadDataOnly(true);
//                $reader->setLoadSheetsOnly(["Worksheet"]);
                $spreadSheet = $reader->load($inputFileName);
                $workSheet = $spreadSheet->getActiveSheet();
                $startRow = 0;
                $max = 5000;
                $columns = [
                    "A" => "phone",
                ];
                $data_insert = [];
                for ($i = $startRow; $i < $max; $i++) {
                    $phone = $workSheet->getCell("A$i")->getValue();
                    if (empty($phone)) continue;
                    $data_row = [];
                    foreach ($columns as $col => $field) {
                        $val = $workSheet->getCell("$col$i")->getValue();
                        $data_row[$field] = $val;
                        $data_row['status'] = '0';
                        $data_row['msg'] = '';
                        $data_row['updated_at'] = new \DateTime();
                        $data_row['created_at'] = new \DateTime();
                    }
                    $data_insert[] = $data_row;
                }
                \DB::table('massmsgs')->truncate();
                \DB::table('massmsgs')->insert($data_insert);

                return redirect('sms/massmsg')->with('success', 'Амжилттай!');
            }
        }
        $datas = Massmsg::select("*")->orderBy("created_at", "asc")->get();

        return view('admin.sms.massSms', compact("title", "template", "datas"));
    }

    public function masssend(Request $request)
    {
        $msg = $request->msg;
        $massMsgs = Massmsg::select("*")
            ->where([
                ["status", "=", "0"]
            ])->orderBy('id', 'asc')->get();
        $user = Auth::user();
        foreach ($massMsgs as $item) {
            $sms = new Sms();
            $sms->number = $item->phone;
//            $sms->number = '88109321';
            $sms->msg = $msg;
            $sms->status = '0';
            $sms->type = 'masssms';
            $sms->user = $user->name;
            $sms->date = date('Y-m-d H:i:s');
            $sms->save();

            $item->msg = $msg;
            $item->status = '1';
            $item->save();
        }
        return response()->json([
            'msg' => 'success',
            'success' => 'true',
            'status' => 200,
        ]);
    }

    public function lotterysend(Request $request)
    {
        $msg = "";
        $lotteries = Lottery::select("*")
            ->where([
                ["status", "=", "N"],
                ["msg", "=", ""]
            ])->orderBy('created_at', 'asc')->get();
        $user = Auth::user();

        $lnumber = \DB::table('lotteries')->where([
            ["status", "=", "N"],
            ["msg", "!=", ""]
        ])->count();

        $lnumber = $lnumber + 1;

        foreach ($lotteries as $item) {
            $msg = $request->msg;
            $nnn = "";
            for ($x = 0; $x < 6 - strlen($lnumber . ''); $x++) {
                $nnn = $nnn . "0";
            }
            $nnn = $nnn . $lnumber;
            $msg = str_replace("#AB#", "BA" . $nnn, $msg);

            $sms = new Sms();
            $sms->number = $item->phone;
//            $sms->number = '89011252';
            $sms->msg = $msg;
            $sms->status = '0';
            $sms->type = 'lottery';
            $sms->user = $user->name;
            $sms->date = date('Y-m-d H:i:s');
            $sms->save();

            $item->msg = $msg;
            $item->number = $lnumber;
            $item->save();

            $lnumber++;
        }
        return response()->json([
            'msg' => 'success',
            'success' => 'true',
            'status' => 200,
        ]);
    }


    public function savelottphone(Request $request)
    {
        $phone = $request->phone;
        $stat_number = $request->stat_number;

//        if (Lottery::where('phone', $phone)->exists()) {
//            return response()->json([
//                'msg' => $phone . ' - энэ дугаар аль хэдийн бүртгэлэй байна.',
//                'success' => false,
//                'status' => 200
//            ]);
//        }
        $lnumber = 0;
        $lott = Lottery::where('status', '=', 'N')->orderBy('id', 'desc')->first();
        if ($lott !== null) {
            $lnumber = $lott->number;
        }
        $lnumber = $lnumber + 1;
//        $nnn = "";
//        for ($x = 0; $x < 6 - strlen($lnumber . ''); $x++) {
//            $nnn = $nnn . '0';
//        }
//        $nnn = $nnn . $lnumber;
        $lEntry = new Lottery();
        $lEntry->number = $lnumber;
        $lEntry->phone = $phone;
        $lEntry->msg = '';
        $lEntry->bill_no = $stat_number;
        $lEntry->status = 'N';
        $lEntry->save();

        return response()->json([
            'msg' => 'success',
            'success' => true,
            'status' => 200
        ]);
    }


}
