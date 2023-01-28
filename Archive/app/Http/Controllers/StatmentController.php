<?php

namespace App\Http\Controllers;

use App\ChangedStatment;
use App\Credit;
use App\Invoices;
use App\Statment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use PHPExcel_Style_Font;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class StatmentController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    function procreditorpush($id)
    {

        $rec = ChangedStatment::select("*")
            ->where([
                ["id", "=", $id]
            ])->first();
        if ($rec !== null) {
            if ($rec->procredit === 'false') {
                $huu = $rec->zeel_huu;
                $hasalt = $rec->hasalt;
                $haalt = $rec->haalt;
                $zuruu = $rec->zuruu;
                $credit = Credit::where([
                    ["number", "=", $rec->number]
                ])->first();
                if ($credit !== null) {

                    $event = "";
                    if ($huu > 0) {
                        $event = "huu";
//
//                        $minusdata = '{
//                                        "id": 423,
//                                        "dept_id": 192,
//                                        "api_user": "altanbumba",
//                                        "psswrd": "PqJXg5toT3",
//                                        "credit_id": "' . $credit->credit_id . '",
//                                        "zeeld": "0",
//                                        "khuu": "' . $khuu . '",
//                                        "hetersenkhuu": "' . $aldangi . '",
//                                        "useddays": "' . $invoice->honog . '"
//                                    }';


                    } else if ($hasalt > 0) {
                        $event = "hasalt";
                        $minusdata = '{
                                        "id": 423,
                                        "dept_id": 192,
                                        "api_user": "altanbumba",
                                        "psswrd": "PqJXg5toT3",
                                        "credit_id": "' . $credit->credit_id . '",
                                        "zeeld": "' . $hasalt . '",
                                        "khuu": "0",
                                        "hetersenkhuu": "0",
                                        "useddays": "0"
                                    }';

                    } else if ($haalt > 0) {
                        $event = "haalt";

                        $date_current = new DateTime(date("Y/m/d"));
                        $datetime1 = new DateTime($credit->duusah_honog);
                        $interval = $datetime1->diff($date_current);
                        $days = $interval->format('%a');
                        $curhonog = 0;
                        if ($credit->khetersenkhonog === '0')
                            $curhonog = (30 - ($days));
                        else
                            $curhonog = $credit->khetersenkhonog + 30;


                        if ($curhonog . '' === $rec->honog) {
                            $zeeld = $haalt - ($credit->huramtlagdsankhuu);
                            if (number_format((-1 * $credit->zeeluldegdel), 0) === number_format($zeeld, 0)) {
                                $minusdata = '{
                                            "id": 423,
                                            "dept_id": 192,
                                            "api_user": "altanbumba",
                                            "psswrd": "PqJXg5toT3",
                                            "credit_id": "' . $credit->credit_id . '",
                                            "zeeld": "' . $zeeld . '",
                                            "khuu": "' . $credit->huramtlagdsankhuu . '",
                                            "hetersenkhuu": "' . 0 . '",
                                            "useddays": "' . $rec->honog . '"
                                        }';
                            }
                        }

                    }


                } else {
                    return response()->json([
                        'msg' => "Зээлийн мэдээлэл олдсонгүй.",
                        'success' => "false",
                        'status' => 200
                    ]);
                }


                return response()->json([
                    'msg' => "success",
                    'success' => "true",
                    'status' => 200,
                    'event' => $event
                ]);

            } else {
                return response()->json([
                    'msg' => "Аль хэдийн бичилт хийгдсэн байна.",
                    'success' => "false",
                    'status' => 200
                ]);
            }

        }

        return response()->json([
            'msg' => "success",
            'success' => "true",
            'status' => 200

        ]);
    }

    function qpay_autopush(Request $request, $account)
    {
        $pid = rand(10000000, 99999999);
        $user = Auth::user();
        $start_date = '2019-01-01';
        $end_date = '2060-01-01';
        $filterdates = $request->daterange;
        if (strpos($filterdates, '-') !== false) {
            $lpos = strpos($filterdates, "-");
            $start_date = substr($filterdates, 0, $lpos);
            $end_date = substr($filterdates, $lpos + 1, strlen($filterdates));
            $start_date = Carbon::parse($start_date)->format('Y-m-d');
            $end_date = Carbon::parse($end_date)->format('Y-m-d');
        }

        $statments = Statment::leftJoin('changed_statments', 'changed_statments.record', '=', 'statments.record')
            ->select(
                'statments.*',
                DB::raw('count(changed_statments.id) as record_used_count')
            )
            ->where([
                ['statments.number', '=', $account],
                ["statments.description", "like", "%" . "qpay" . "%"],
                ['statments.amount', '>', 0],
                ['statments.post_date', '>=', $start_date],
                ['statments.post_date', '<=', $end_date],
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
            )->having(DB::raw('count(changed_statments.id)'), '=', 0)->orderBy('record', 'desc')->get();


        if (count($statments) > 0) {
            $invoices = Invoices::select("*")
                ->where([
                    ["status", ">", 1]
                ])
                ->get();
            foreach ($statments as $stat) {
                foreach ($invoices as $inv) {
                    if (strpos($stat->description, $inv->bill_no) !== false) {
                        $stat->honog = $inv->honog;
                        break;
                    }
                }
            }
        }
        $guch_honog_codes = "WBS1,AUS1,WBS5,AUS4,WM61,WM81,CBS1,CBS5,CB61,CB71,CB81,CBQ1,WM71";
        $hurimt_huu_codes = "WBS2,WB12,AUS2,AUS3,WBS6,WBS7,WBS8,CBS2,CBS6,CBS7,CBS8,CBQ2";
        $hasalt_codes = "WBS3,CBS3,CBQ3";
        $haalt_codes = "WBS4,WBS9,CBS4,CBQ4";
        $tran_codes = $guch_honog_codes . ',' . $hurimt_huu_codes . ',' . $hasalt_codes . ',' . $haalt_codes;
        $inscount = 0;
        foreach ($statments as $stat) {
            if (isset($stat->honog)) {
                $geree_dugaar = "";
                $tran_code = "";
                $isqpay = stripos($stat->description, "qpay");
                $pos = stripos($stat->description, "AB");
                if ($pos !== false) {
                    $lastdesc = substr($stat->description, $pos, strlen($stat->description));
                    if ($lastdesc !== false) {
                        if (strpos($lastdesc, ' ') !== false) {
                            $lastdesc = str_replace(" ", "-", $lastdesc);
                        }
                        if (strpos($lastdesc, '-') !== false) {
                            $lpos = strpos($lastdesc, "-");
                            $geree_dugaar = substr($lastdesc, 0, $lpos);
                            $vldsen = substr($lastdesc, $lpos + 1, strlen($lastdesc));
                            if (strpos($vldsen, '-') !== false) {
                                $tran_code = substr($vldsen, 0, strpos($vldsen, "-"));
                            }
                        }
                    }
                }
                if (strlen($tran_code) < 3) {
                    $tran_code = "AAAAA";
                }
                if (strpos($guch_honog_codes, $tran_code) !== false || strpos($hurimt_huu_codes, $tran_code) !== false) {
                    $desc = $geree_dugaar . '-' . 'Зээлийн хүү';
                    $stEntry = new ChangedStatment();
                    $stEntry->record = $stat->record;
                    $stEntry->description = $desc;
                    $stEntry->number = $geree_dugaar;
                    $stEntry->zeel_huu = $stat->amount;
                    $stEntry->hasalt = '0';
                    $stEntry->haalt = '0';
                    $stEntry->zuruu = '0';
                    $stEntry->total = '0';
                    $stEntry->group_id = $pid;
                    $stEntry->user = $user->name;
                    $stEntry->account = $account;
                    $stEntry->honog = $stat->honog;
                    $stEntry->action = "qpay";
                    $stEntry->procredit = "true";
                    $stEntry->tran_date = $stat->post_date;
                    $stEntry->save();
                    $inscount++;
                }
                if (strpos($hasalt_codes, $tran_code) !== false || strpos($haalt_codes, $tran_code) !== false) {

//                    if ($geree_dugaar === 'AB3613') {
//                        print_r($tran_code . '==' . $stat->amount);
//                        return;
//                    }

                    $tt = strpos($hasalt_codes, $tran_code) ? 'Хасалт' : 'Хаалт';
                    $desc = $geree_dugaar . '-' . $tt;
                    $stEntry = new ChangedStatment();
                    $stEntry->record = $stat->record;
                    $stEntry->description = $desc;
                    $stEntry->number = $geree_dugaar;
                    $stEntry->zeel_huu = '0';
                    $stEntry->hasalt = strpos($hasalt_codes, $tran_code) !== false ? $stat->amount : '0';
                    $stEntry->haalt = strpos($haalt_codes, $tran_code) !== false ? $stat->amount : '0';
                    $stEntry->zuruu = '0';
                    $stEntry->total = '0';
                    $stEntry->group_id = $pid;
                    $stEntry->user = $user->name;
                    $stEntry->account = $account;
                    $stEntry->honog = $stat->honog;
                    $stEntry->action = "qpay";
                    $stEntry->procredit = "true";
                    $stEntry->tran_date = $stat->post_date;
                    $stEntry->save();
                    $inscount++;

                }
            }
        }

        return response()->json([
            'msg' => "success",
            'success' => "true",
            'status' => 200,
            'pushcount' => $inscount

        ]);
    }

    function saveChangedStatments(Request $request, $number)
    {
        $pid = rand(10000000, 99999999);
        $user = Auth::user();
        foreach ($request->crecords as $item) {
            $rec = ChangedStatment::select("*")
                ->where([
                    ["number", "=", $item['number']],
                    ["record", "=", $request->record]
                ])->first();
            if ($rec !== null) {
                return response()->json([
                    'msg' => "already exist",
                    'success' => false,
                    'status' => 200
                ]);
            }
        }
        foreach ($request->crecords as $item) {
            if ($item['zeel_huu'] > 0) {
                $desc = $item['number'] . '-' . 'Зээлийн хүү';
                $stEntry = new ChangedStatment();
                $stEntry->record = $request->record;
                $stEntry->description = $desc;
                $stEntry->number = $item['number'];
                $stEntry->zeel_huu = $item['zeel_huu'];
                $stEntry->hasalt = '0';
                $stEntry->haalt = '0';
                $stEntry->zuruu = '0';
                $stEntry->total = $item['niit'];
                $stEntry->group_id = $pid;
                $stEntry->user = $user->name;
                $stEntry->account = $number;
                $stEntry->honog = $item['honog'];
                $stEntry->action = "manual";
                $stEntry->procredit = "false";
                $stEntry->tran_date = $request->tran_date;
                $stEntry->save();

            }
            if ($item['hasalt'] > 0) {
                $desc = $item['number'] . '-' . 'Хасалт';
                $stEntry = new ChangedStatment();
                $stEntry->record = $request->record;
                $stEntry->description = $desc;
                $stEntry->number = $item['number'];
                $stEntry->zeel_huu = '0';
                $stEntry->hasalt = $item['hasalt'];
                $stEntry->haalt = '0';
                $stEntry->zuruu = '0';
                $stEntry->total = $item['niit'];
                $stEntry->group_id = $pid;
                $stEntry->user = $user->name;
                $stEntry->account = $number;
                $stEntry->honog = $item['honog'];
                $stEntry->action = "manual";
                $stEntry->procredit = "false";
                $stEntry->tran_date = $request->tran_date;
                $stEntry->save();

            }
            if ($item['haalt'] > 0) {
                $desc = $item['number'] . '-' . 'Хаалт';
                $stEntry = new ChangedStatment();
                $stEntry->record = $request->record;
                $stEntry->description = $desc;
                $stEntry->number = $item['number'];
                $stEntry->zeel_huu = '0';
                $stEntry->hasalt = '0';
                $stEntry->haalt = $item['haalt'];
                $stEntry->zuruu = '0';
                $stEntry->total = $item['niit'];
                $stEntry->group_id = $pid;
                $stEntry->user = $user->name;
                $stEntry->account = $number;
                $stEntry->honog = $item['honog'];
                $stEntry->action = "manual";
                $stEntry->procredit = "false";
                $stEntry->tran_date = $request->tran_date;
                $stEntry->save();
            }
            if ($item['zuruu'] > 0) {
                $desc = $item['number'] . '-' . 'Зөрүү';
                $stEntry = new ChangedStatment();
                $stEntry->record = $request->record;
                $stEntry->description = $desc;
                $stEntry->number = $item['number'];
                $stEntry->zeel_huu = '0';
                $stEntry->hasalt = '0';
                $stEntry->haalt = '0';
                $stEntry->zuruu = $item['zuruu'];
                $stEntry->total = $item['niit'];
                $stEntry->group_id = $pid;
                $stEntry->user = $user->name;
                $stEntry->account = $number;
                $stEntry->honog = $item['honog'];
                $stEntry->action = "manual";
                $stEntry->procredit = "false";
                $stEntry->tran_date = $request->tran_date;
                $stEntry->save();
            }
        }
        return response()->json([
            'msg' => "success",
            'success' => "true",
            'status' => 200

        ]);
    }


    public function destroyChangedStatment($id)
    {

        ChangedStatment::find($id)->delete($id);
        $rec = ChangedStatment::where("id", "=", $id)->first();
        if ($rec) {
            $rec->delete();
        }
        return response()->json([
            'success' => 'success'
        ]);
    }

    public function changed_statments(Request $request)
    {
        $statments = ChangedStatment::select("changed_statments.*")->orderBy('changed_statments.record', 'desc')->paginate(40)->appends(request()->except('page'));
        $changeddata = ChangedStatment::select(
            DB::raw('sum(zeel_huu) as huu, sum(hasalt) as hasalt, sum(haalt) as haalt, sum(zuruu) as zuruu')
        )->first();

        return view('admin.loan.changedStatments', ['statments' => $statments, 'changeddata' => $changeddata]);
    }


    function excel(Request $request, $number)
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

        $stat_data = DB::table('statments')->whereRaw('number = ? and LOWER(`description`) LIKE ? and post_date > ? and post_date < ?', [$number, '%qpay%', $start_date, $end_date])->orderBy('record', 'desc')->get()->toArray();


        $guch_honog_codes = "WBS1,AUS1,WBS5,AUS4,WM61,WM81,CBS1,CBS5,CB61,CB71,CB81,CBQ1,WM71";
        $hurimt_huu_codes = "WBS2,WB12,AUS2,AUS3,WBS6,WBS7,WBS8,CBS2,CBS6,CBS7,CBS8,CBQ2";
        $hasalt_codes = "WBS3,CBS3,CBQ3";
        $haalt_codes = "WBS4,WBS9,CBS4,CBQ4";

        $tran_codes = $guch_honog_codes . ',' . $hurimt_huu_codes . ',' . $hasalt_codes . ',' . $haalt_codes;


        $sheet1_array[] = array('Харилцагч', 'Огноо', 'Гүйлгээний утга',
            'Баримтын дугаар', 'Дүн', 'Гүйлгээний загвар');

        $sheet2_array[] = array(
            'Харилцагч',
            'Огноо',
            'Гүйлгээний утга',
            'Баримтын дугаар',
            'Дебит данс',
            'Дебит ханш',
            'Дебет дүн',
            'Дебет дүн ₮',
            'Кредит данс',
            'Кредит ханш',
            'Кредит дүн',
            'Кредит дүн ₮',
            'НӨАТ - ийн үзүүлэлт',
            'Мөнгөн гүйлгээний үзүүлэлт');

        $sheet3_array[] = array('Баримтын №', 'Огноо', 'Гүйлгээний утга',
            'Харилцагч', 'Данс', 'Ханш', ' Дебет дүн', ' Дебет дүн ₮', 'Кредит дүн',
            'Кредит дүн ₮', 'Багц', 'Гүйлгээ', 'НӨАТ - ийн үзүүлэлт', 'Мөнгөн гүйлгээний үзүүлэлт',
            'Сегмент 1', 'Сегмент 2', 'Сегмент 3', 'Сегмент 4', 'Сегмент 5');

        foreach ($stat_data as $stat) {
            $geree_dugaar = "";
            $tran_code = "";
            $pos = stripos($stat->description, "AB");
            if ($pos !== false) {
                $lastdesc = substr($stat->description, $pos, strlen($stat->description));
                if ($lastdesc !== false) {
                    if (strpos($lastdesc, ' ') !== false) {
                        $lastdesc = str_replace(" ", "-", $lastdesc);
                    }
                    if (strpos($lastdesc, '-') !== false) {
                        $lpos = strpos($lastdesc, "-");
                        $geree_dugaar = substr($lastdesc, 0, $lpos);
                        $vldsen = substr($lastdesc, $lpos + 1, strlen($lastdesc));
                        if (strpos($vldsen, '-') !== false) {
                            $tran_code = substr($vldsen, 0, strpos($vldsen, "-"));
                        }

                    }
                }
            }
            if (strlen($tran_code) < 3) {
                $tran_code = "AAAAA";
            }
            $debit_dans = '';
            if (strpos($tran_codes, $tran_code) !== false) {
                $debit_dans = 110102;
            }
            $credit_dans = '';
            $mungu_uz = '';
            if (strpos($guch_honog_codes, $tran_code) !== false || strpos($hurimt_huu_codes, $tran_code) !== false) {
                $credit_dans = 120603;
                $mungu_uz = 100;
            }
            if (strpos($hasalt_codes, $tran_code) !== false || strpos($haalt_codes, $tran_code) !== false) {
                $credit_dans = 120101;
                $mungu_uz = 101;
            }
            $sheet2_array[] = array(
                'hariltsagch' => $geree_dugaar,
                'date' => $stat->post_date,
                'guilgee_utga' => $stat->description,
                'barimt_dugaar' => '',//hooson
                'debit_dans' => $debit_dans,
                'debit_hansh' => 1, //togtmol
                'debit_dun' => number_format($stat->amount, 2),
                'debit_dun_tug' => number_format($stat->amount, 2),
                'credit_dans' => $credit_dans,//120603-(hurimtlagdsan huu+30 honoghuu) or 120101(hasalt,haalt
                'credit_hansh' => 1, //togtmol
                'credit_dun' => number_format($stat->amount, 2),
                'credit_dun_tug' => number_format($stat->amount, 2),
                'noat' => "",//hooson
                'mungun_guilgeenii_uzuulelt' => $mungu_uz //100-(30 honogiin huu, hurimtlagdsan huu) or 101-(hasalt, haalt)
            );
        }
        Excel::create($number . '-Statments', function ($excel) use ($number, $sheet1_array, $sheet2_array, $sheet3_array) {
            $excel->setTitle($number . '-Statments');

            $excel->sheet('JournalByTemplate', function ($sheet) use ($sheet1_array) {
                $sheet->fromArray($sheet1_array, null, 'A1', false, false);
            });
            $excel->sheet('JournalByAccount', function ($sheet) use ($sheet2_array) {
                $sheet->fromArray($sheet2_array, null, 'A1', false, false);
            });
            $excel->sheet('Journal', function ($sheet) use ($sheet3_array) {
                $sheet->fromArray($sheet3_array, null, 'A1', false, false);
            });
        })->export('xlsx');
    }

    public function exportspread(Request $request, $number)
    {
        $type = 'xlsx';

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

        $stat_data = DB::table('statments')->whereRaw('number = ? and LOWER(`description`) LIKE ? and post_date >= ? and post_date <= ?', [$number, '%qpay%', $start_date, $end_date])->orderBy('record', 'desc')->get()->toArray();


        $guch_honog_codes = "WBS1,AUS1,WBS5,AUS4,WM61,WM81,CBS1,CBS5,CB61,CB71,CB81,CBQ1,WM71";
        $hurimt_huu_codes = "WBS2,WB12,AUS2,AUS3,WBS6,WBS7,WBS8,CBS2,CBS6,CBS7,CBS8,CBQ2";
        $hasalt_codes = "WBS3,CBS3,CBQ3";
        $haalt_codes = "WBS4,WBS9,CBS4,CBQ4";

        $tran_codes = $guch_honog_codes . ',' . $hurimt_huu_codes . ',' . $hasalt_codes . ',' . $haalt_codes;


        $sheet1_array[] = array('Харилцагч', 'Огноо', 'Гүйлгээний утга',
            'Баримтын дугаар', 'Дүн', 'Гүйлгээний загвар');

        $sheet2_array[] = array(
            'Харилцагч',
            'Огноо',
            'Гүйлгээний утга',
            'Баримтын дугаар',
            'Дебит данс',
            'Дебит ханш',
            'Дебет дүн',
            'Дебет дүн ₮',
            'Кредит данс',
            'Кредит ханш',
            'Кредит дүн',
            'Кредит дүн ₮',
            'НӨАТ - ийн үзүүлэлт',
            'Мөнгөн гүйлгээний үзүүлэлт');

        $sheet3_array[] = array('Баримтын №', 'Огноо', 'Гүйлгээний утга',
            'Харилцагч', 'Данс', 'Ханш', ' Дебет дүн', ' Дебет дүн ₮', 'Кредит дүн',
            'Кредит дүн ₮', 'Багц', 'Гүйлгээ', 'НӨАТ - ийн үзүүлэлт', 'Мөнгөн гүйлгээний үзүүлэлт',
            'Сегмент 1', 'Сегмент 2', 'Сегмент 3', 'Сегмент 4', 'Сегмент 5');

        foreach ($stat_data as $stat) {
            $geree_dugaar = "";
            $tran_code = "";
            $pos = stripos($stat->description, "AB");
            if ($pos !== false) {
                $lastdesc = substr($stat->description, $pos, strlen($stat->description));
                if ($lastdesc !== false) {
                    if (strpos($lastdesc, ' ') !== false) {
                        $lastdesc = str_replace(" ", "-", $lastdesc);
                    }
                    if (strpos($lastdesc, '-') !== false) {
                        $lpos = strpos($lastdesc, "-");
                        $geree_dugaar = substr($lastdesc, 0, $lpos);
                        $vldsen = substr($lastdesc, $lpos + 1, strlen($lastdesc));
                        if (strpos($vldsen, '-') !== false) {
                            $tran_code = substr($vldsen, 0, strpos($vldsen, "-"));
                        }

                    }
                }
            }
            if (strlen($tran_code) < 3) {
                $tran_code = "AAAAA";
            }
            $debit_dans = '';
            if (strpos($tran_codes, $tran_code) !== false) {
                $debit_dans = 110102;
            }
            $credit_dans = '';
            $mungu_uz = '';
            if (strpos($guch_honog_codes, $tran_code) !== false || strpos($hurimt_huu_codes, $tran_code) !== false) {
                $credit_dans = 120603;
                $mungu_uz = 100;
            }
            if (strpos($hasalt_codes, $tran_code) !== false || strpos($haalt_codes, $tran_code) !== false) {
                $credit_dans = 120101;
                $mungu_uz = 101;
            }


            $sheet2_array[] = array(
                $geree_dugaar,
                $stat->post_date,
                $stat->description,
                '',//hooson
                $debit_dans,
                1, //togtmol
                number_format($stat->amount, 2),
                number_format($stat->amount, 2),
                $credit_dans,//120603-(hurimtlagdsan huu+30 honoghuu) or 120101(hasalt,haalt
                1, //togtmol
                number_format($stat->amount, 2),
                number_format($stat->amount, 2),
                "",//hooson
                $mungu_uz //100-(30 honogiin huu, hurimtlagdsan huu) or 101-(hasalt, haalt)
            );
        }


        $spreadsheet = new Spreadsheet();


        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle("JournalByTemplate");

        $rows = 1;
        foreach ($sheet1_array as $sheet1) {
            $sheet->setCellValue('A' . $rows, $sheet1[0]);
            $sheet->setCellValue('B' . $rows, $sheet1[1]);
            $sheet->setCellValue('C' . $rows, $sheet1[2]);
            $sheet->setCellValue('D' . $rows, $sheet1[3]);
            $sheet->setCellValue('E' . $rows, $sheet1[4]);
            $sheet->setCellValue('F' . $rows, $sheet1[5]);
            $rows++;
        }

        foreach (range('A', 'N') as $columnID) {
            $sheet->getColumnDimension($columnID)
                ->setAutoSize(true);
        }

        $spreadsheet->createSheet();
        $sheet = $spreadsheet->setActiveSheetIndex(1);
        $sheet->setTitle("JournalByAccount");

        $styleArray = array(
            'font' => array(
                'underline' => PHPExcel_Style_Font::UNDERLINE_SINGLE
            )
        );

        $rows = 1;
        foreach ($sheet2_array as $sheet2) {
            $sheet->setCellValue('A' . $rows, $sheet2[0]);
            $sheet->setCellValue('B' . $rows, $sheet2[1]);
            $sheet->setCellValue('C' . $rows, $sheet2[2]);
            $sheet->setCellValue('D' . $rows, $sheet2[3]);
            $sheet->setCellValue('E' . $rows, $sheet2[4]);
            $sheet->setCellValue('F' . $rows, $sheet2[5]);
            $sheet->setCellValue('G' . $rows, $sheet2[6]);
            $sheet->setCellValue('H' . $rows, $sheet2[7]);
            $sheet->setCellValue('I' . $rows, $sheet2[8]);
            $sheet->setCellValue('J' . $rows, $sheet2[9]);
            $sheet->setCellValue('K' . $rows, $sheet2[10]);
            $sheet->setCellValue('L' . $rows, $sheet2[11]);
            $sheet->setCellValue('M' . $rows, $sheet2[12]);
            $sheet->setCellValue('N' . $rows, $sheet2[13]);

            if ($rows === 1) {
                $sheet->getStyle('A' . $rows)->applyFromArray($styleArray);
                $sheet->getStyle('B' . $rows)->applyFromArray($styleArray);
                $sheet->getStyle('C' . $rows)->applyFromArray($styleArray);
                $sheet->getStyle('D' . $rows)->applyFromArray($styleArray);
                $sheet->getStyle('E' . $rows)->applyFromArray($styleArray);
                $sheet->getStyle('F' . $rows)->applyFromArray($styleArray);
                $sheet->getStyle('G' . $rows)->applyFromArray($styleArray);
                $sheet->getStyle('H' . $rows)->applyFromArray($styleArray);
                $sheet->getStyle('I' . $rows)->applyFromArray($styleArray);
                $sheet->getStyle('J' . $rows)->applyFromArray($styleArray);
                $sheet->getStyle('K' . $rows)->applyFromArray($styleArray);
                $sheet->getStyle('L' . $rows)->applyFromArray($styleArray);
                $sheet->getStyle('M' . $rows)->applyFromArray($styleArray);
                $sheet->getStyle('N' . $rows)->applyFromArray($styleArray);
            }

            $rows++;
        }
        foreach (range('A', 'N') as $columnID) {
            $sheet->getColumnDimension($columnID)
                ->setAutoSize(true);
        }
        $spreadsheet->createSheet();
        $sheet = $spreadsheet->setActiveSheetIndex(2);
        $sheet->setTitle("Journal");
        $rows = 1;
        foreach ($sheet3_array as $sheet3) {
            $sheet->setCellValue('A' . $rows, $sheet3[0]);
            $sheet->setCellValue('B' . $rows, $sheet3[1]);
            $sheet->setCellValue('C' . $rows, $sheet3[2]);
            $sheet->setCellValue('D' . $rows, $sheet3[3]);
            $sheet->setCellValue('E' . $rows, $sheet3[4]);
            $sheet->setCellValue('F' . $rows, $sheet3[5]);
            $sheet->setCellValue('G' . $rows, $sheet3[6]);
            $sheet->setCellValue('H' . $rows, $sheet3[7]);
            $sheet->setCellValue('I' . $rows, $sheet3[8]);
            $sheet->setCellValue('J' . $rows, $sheet3[9]);
            $sheet->setCellValue('K' . $rows, $sheet3[10]);
            $sheet->setCellValue('L' . $rows, $sheet3[11]);
            $sheet->setCellValue('M' . $rows, $sheet3[12]);
            $sheet->setCellValue('N' . $rows, $sheet3[13]);
            $sheet->setCellValue('O' . $rows, $sheet3[14]);
            $sheet->setCellValue('P' . $rows, $sheet3[15]);
            $sheet->setCellValue('Q' . $rows, $sheet3[16]);
            $sheet->setCellValue('R' . $rows, $sheet3[17]);
            $sheet->setCellValue('S' . $rows, $sheet3[18]);
            $rows++;
        }

        foreach (range('A', 'S') as $columnID) {
            $sheet->getColumnDimension($columnID)
                ->setAutoSize(true);
        }


        $fileName = "Statments-" . $number . "." . $type;
        if ($type == 'xlsx') {
            $writer = new Xlsx($spreadsheet);
        } else if ($type == 'xls') {
            $writer = new Xls($spreadsheet);
        }
        $writer->save("export/" . $fileName);
        header("Content-Type: application/vnd.ms-excel");
        return redirect(url('/') . "/export/" . $fileName);
    }


    public function exportspread_statments(Request $request)
    {
        $type = 'xlsx';
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

        $stat_data = DB::table('statments')->whereRaw('post_date >= ? and post_date <= ?', [$start_date, $end_date])->orderBy('number', 'asc')->orderBy('record', 'desc')->get()->toArray();


        $guch_honog_codes = "WBS1,AUS1,WBS5,AUS4,WM61,WM81,CBS1,CBS5,CB61,CB71,CB81,CBQ1,WM71";
        $hurimt_huu_codes = "WBS2,WB12,AUS2,AUS3,WBS6,WBS7,WBS8,CBS2,CBS6,CBS7,CBS8,CBQ2";
        $hasalt_codes = "WBS3,CBS3,CBQ3";
        $haalt_codes = "WBS4,WBS9,CBS4,CBQ4";

        $tran_codes = $guch_honog_codes . ',' . $hurimt_huu_codes . ',' . $hasalt_codes . ',' . $haalt_codes;


        $sheet1_array[] = array('Харилцагч', 'Огноо', 'Гүйлгээний утга',
            'Баримтын дугаар', 'Дүн', 'Гүйлгээний загвар');

        $sheet2_array[] = array(
            'Харилцагч',
            'Огноо',
            'Гүйлгээний утга',
            'Баримтын дугаар',
            'Дебит данс',
            'Дебит ханш',
            'Дебет дүн',
            'Дебет дүн ₮',
            'Кредит данс',
            'Кредит ханш',
            'Кредит дүн',
            'Кредит дүн ₮',
            'НӨАТ - ийн үзүүлэлт',
            'Мөнгөн гүйлгээний үзүүлэлт');

        $sheet3_array[] = array('Баримтын №', 'Огноо', 'Гүйлгээний утга',
            'Харилцагч', 'Данс', 'Ханш', ' Дебет дүн', ' Дебет дүн ₮', 'Кредит дүн',
            'Кредит дүн ₮', 'Багц', 'Гүйлгээ', 'НӨАТ - ийн үзүүлэлт', 'Мөнгөн гүйлгээний үзүүлэлт',
            'Сегмент 1', 'Сегмент 2', 'Сегмент 3', 'Сегмент 4', 'Сегмент 5');

        foreach ($stat_data as $stat) {
            $geree_dugaar = "";
            $tran_code = "";
            $isqpay = stripos($stat->description, "qpay");
            if ($isqpay !== false) {
                $pos = stripos($stat->description, "AB");
                if ($pos !== false) {
                    $lastdesc = substr($stat->description, $pos, strlen($stat->description));
                    if ($lastdesc !== false) {
                        if (strpos($lastdesc, ' ') !== false) {
                            $lastdesc = str_replace(" ", "-", $lastdesc);
                        }
                        if (strpos($lastdesc, '-') !== false) {
                            $lpos = strpos($lastdesc, "-");
                            $geree_dugaar = substr($lastdesc, 0, $lpos);
                            $vldsen = substr($lastdesc, $lpos + 1, strlen($lastdesc));
                            if (strpos($vldsen, '-') !== false) {
                                $tran_code = substr($vldsen, 0, strpos($vldsen, "-"));
                            }
                        }
                    }
                }
            } else {

//                EB-AB3198

                $key1 = stripos($stat->description, "олголт");
                $key2 = stripos($stat->description, "нэмэлт");
                $key3 = stripos($stat->description, "үндсэн төлбөрийн хаалт");
                $key4 = stripos($stat->description, "үндсэн төлбөрийн хасалт");
                $key5 = stripos(strtolower($stat->description), "хүү төлбөр");

                if ($key1 !== false || $key2 !== false || $key3 !== false || $key4 !== false || $key5 !== false) {
                    if (strpos($stat->description, ' ') !== false) {
                        $lpos = strpos($stat->description, " ");
                        $geree_dugaar = substr($stat->description, 0, $lpos);
                        $geree_dugaar = str_replace("EB-", "", $geree_dugaar);

                    }
                }
            }

            if (strlen($tran_code) < 3) {
                $tran_code = "AAAAA";
            }
            $debit_dans = '';
            if (strpos($tran_codes, $tran_code) !== false) {
                $debit_dans = 110102;
            }
            $credit_dans = '';
            $mungu_uz = '';
            if (strpos($guch_honog_codes, $tran_code) !== false || strpos($hurimt_huu_codes, $tran_code) !== false) {
                $credit_dans = 120603;
                $mungu_uz = 100;
            }
            if (strpos($hasalt_codes, $tran_code) !== false || strpos($haalt_codes, $tran_code) !== false) {
                $credit_dans = 120101;
                $mungu_uz = 101;
            }
            if ($stat->number === '5129036672') {
                if (stripos(strtolower($stat->description), "зардал") !== false ||
                    stripos(strtolower($stat->description), "үндсэн хөрөнгө") !== false
                ) {
                    $debit_dans = 110101;
                    $credit_dans = 310104;
                } else if (stripos(strtolower($stat->description), "абзг700 үндсэн төлбөрийн хаалт") !== false ||
                    stripos(strtolower($stat->description), "абзг700 үндсэн төлбөрийн хасалт") !== false) {
                    $debit_dans = 110101;
                    $credit_dans = 310101;
                } else if (stripos(strtolower($stat->description), "абзг700 хүү төлбөр") !== false) {
                    $debit_dans = 110101;
                    $credit_dans = 310801;

                } else if (stripos(strtolower($stat->description), "хураамж") !== false) {
                    $debit_dans = 110101;
                    $credit_dans = 702701;
                } else if (stripos(strtolower($stat->description), "хангамж") !== false) {
                    $debit_dans = 110101;
                    $credit_dans = 310104;
                }
            }
            if ($stat->number === '5062283423') {
                if (stripos(strtolower($stat->description), "олголт") !== false ||
                    stripos(strtolower($stat->description), "нэмэлт") !== false) {
                    $debit_dans = 110102;
                    $credit_dans = 120101;
                } else if (stripos(strtolower($stat->description), "хураамж") !== false) {
                    $debit_dans = 110102;
                    $credit_dans = 110101;
                }
            }

            $sheet2_array[] = array(
                $geree_dugaar,
                $stat->post_date,
                $stat->description,
                '',//hooson
                $debit_dans,
                1, //togtmol
                number_format($stat->amount, 2),
                number_format($stat->amount, 2),
                $credit_dans,//120603-(hurimtlagdsan huu+30 honoghuu) or 120101(hasalt,haalt
                1, //togtmol
                number_format($stat->amount, 2),
                number_format($stat->amount, 2),
                "",//hooson
                $mungu_uz //100-(30 honogiin huu, hurimtlagdsan huu) or 101-(hasalt, haalt)
            );
        }
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle("JournalByTemplate");

        $rows = 1;
        foreach ($sheet1_array as $sheet1) {
            $sheet->setCellValue('A' . $rows, $sheet1[0]);
            $sheet->setCellValue('B' . $rows, $sheet1[1]);
            $sheet->setCellValue('C' . $rows, $sheet1[2]);
            $sheet->setCellValue('D' . $rows, $sheet1[3]);
            $sheet->setCellValue('E' . $rows, $sheet1[4]);
            $sheet->setCellValue('F' . $rows, $sheet1[5]);
            $rows++;
        }

        foreach (range('A', 'N') as $columnID) {
            $sheet->getColumnDimension($columnID)
                ->setAutoSize(true);
        }

        $spreadsheet->createSheet();
        $sheet = $spreadsheet->setActiveSheetIndex(1);
        $sheet->setTitle("JournalByAccount");

        $styleArray = array(
            'font' => array(
                'underline' => PHPExcel_Style_Font::UNDERLINE_SINGLE
            )
        );

        $rows = 1;
        foreach ($sheet2_array as $sheet2) {
            $sheet->setCellValue('A' . $rows, $sheet2[0]);
            $sheet->setCellValue('B' . $rows, $sheet2[1]);
            $sheet->setCellValue('C' . $rows, $sheet2[2]);
            $sheet->setCellValue('D' . $rows, $sheet2[3]);
            $sheet->setCellValue('E' . $rows, $sheet2[4]);
            $sheet->setCellValue('F' . $rows, $sheet2[5]);
            $sheet->setCellValue('G' . $rows, $sheet2[6]);
            $sheet->setCellValue('H' . $rows, $sheet2[7]);
            $sheet->setCellValue('I' . $rows, $sheet2[8]);
            $sheet->setCellValue('J' . $rows, $sheet2[9]);
            $sheet->setCellValue('K' . $rows, $sheet2[10]);
            $sheet->setCellValue('L' . $rows, $sheet2[11]);
            $sheet->setCellValue('M' . $rows, $sheet2[12]);
            $sheet->setCellValue('N' . $rows, $sheet2[13]);

            if ($rows === 1) {
                $sheet->getStyle('A' . $rows)->applyFromArray($styleArray);
                $sheet->getStyle('B' . $rows)->applyFromArray($styleArray);
                $sheet->getStyle('C' . $rows)->applyFromArray($styleArray);
                $sheet->getStyle('D' . $rows)->applyFromArray($styleArray);
                $sheet->getStyle('E' . $rows)->applyFromArray($styleArray);
                $sheet->getStyle('F' . $rows)->applyFromArray($styleArray);
                $sheet->getStyle('G' . $rows)->applyFromArray($styleArray);
                $sheet->getStyle('H' . $rows)->applyFromArray($styleArray);
                $sheet->getStyle('I' . $rows)->applyFromArray($styleArray);
                $sheet->getStyle('J' . $rows)->applyFromArray($styleArray);
                $sheet->getStyle('K' . $rows)->applyFromArray($styleArray);
                $sheet->getStyle('L' . $rows)->applyFromArray($styleArray);
                $sheet->getStyle('M' . $rows)->applyFromArray($styleArray);
                $sheet->getStyle('N' . $rows)->applyFromArray($styleArray);
            }

            $rows++;
        }
        foreach (range('A', 'N') as $columnID) {
            $sheet->getColumnDimension($columnID)
                ->setAutoSize(true);
        }
        $spreadsheet->createSheet();
        $sheet = $spreadsheet->setActiveSheetIndex(2);
        $sheet->setTitle("Journal");
        $rows = 1;
        foreach ($sheet3_array as $sheet3) {
            $sheet->setCellValue('A' . $rows, $sheet3[0]);
            $sheet->setCellValue('B' . $rows, $sheet3[1]);
            $sheet->setCellValue('C' . $rows, $sheet3[2]);
            $sheet->setCellValue('D' . $rows, $sheet3[3]);
            $sheet->setCellValue('E' . $rows, $sheet3[4]);
            $sheet->setCellValue('F' . $rows, $sheet3[5]);
            $sheet->setCellValue('G' . $rows, $sheet3[6]);
            $sheet->setCellValue('H' . $rows, $sheet3[7]);
            $sheet->setCellValue('I' . $rows, $sheet3[8]);
            $sheet->setCellValue('J' . $rows, $sheet3[9]);
            $sheet->setCellValue('K' . $rows, $sheet3[10]);
            $sheet->setCellValue('L' . $rows, $sheet3[11]);
            $sheet->setCellValue('M' . $rows, $sheet3[12]);
            $sheet->setCellValue('N' . $rows, $sheet3[13]);
            $sheet->setCellValue('O' . $rows, $sheet3[14]);
            $sheet->setCellValue('P' . $rows, $sheet3[15]);
            $sheet->setCellValue('Q' . $rows, $sheet3[16]);
            $sheet->setCellValue('R' . $rows, $sheet3[17]);
            $sheet->setCellValue('S' . $rows, $sheet3[18]);
            $rows++;
        }

        foreach (range('A', 'S') as $columnID) {
            $sheet->getColumnDimension($columnID)
                ->setAutoSize(true);
        }


        $fileName = "AcountStatments-" . "." . $type;
        if ($type == 'xlsx') {
            $writer = new Xlsx($spreadsheet);
        } else if ($type == 'xls') {
            $writer = new Xls($spreadsheet);
        }
        $writer->save("export/" . $fileName);
        header("Content-Type: application/vnd.ms-excel");
        return redirect(url('/') . "/export/" . $fileName);
    }


    public function export_changed_statments(Request $request)
    {
        $type = 'xlsx';
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
        $stat_data = DB::table('changed_statments')->whereRaw('tran_date >= ? and tran_date <= ?', [$start_date, $end_date])->orderBy('tran_date', 'asc')->orderBy('record', 'desc')->get()->toArray();
        $sheet1_array[] = array('Харилцагч', 'Огноо', 'Гүйлгээний утга',
            'Баримтын дугаар', 'Дүн', 'Гүйлгээний загвар');

        $sheet2_array[] = array(
            'Харилцагч',
            'Огноо',
            'Гүйлгээний утга',
            'Баримтын дугаар',
            'Дебит данс',
            'Дебит ханш',
            'Дебет дүн',
            'Дебет дүн ₮',
            'Кредит данс',
            'Кредит ханш',
            'Кредит дүн',
            'Кредит дүн ₮',
            'НӨАТ - ийн үзүүлэлт',
            'Мөнгөн гүйлгээний үзүүлэлт');

        $sheet3_array[] = array('Баримтын №', 'Огноо', 'Гүйлгээний утга',
            'Харилцагч', 'Данс', 'Ханш', ' Дебет дүн', ' Дебет дүн ₮', 'Кредит дүн',
            'Кредит дүн ₮', 'Багц', 'Гүйлгээ', 'НӨАТ - ийн үзүүлэлт', 'Мөнгөн гүйлгээний үзүүлэлт',
            'Сегмент 1', 'Сегмент 2', 'Сегмент 3', 'Сегмент 4', 'Сегмент 5');

        foreach ($stat_data as $stat) {

            $debit_dans = 110102;
            $credit_dans = '';
            $mungu_uz = '100';
            //huu, hasalt, haalt ,zuruu ene 4-iin alig ng talbart 0 ees utga bh uchir niilberiig ni amount gj uzhed bolno
            $amount = ($stat->zeel_huu + $stat->hasalt + $stat->haalt + $stat->zuruu);

            if (stripos($stat->description, "Зээлийн хүү") !== false) {
                $credit_dans = 120603;
            }
            if (stripos($stat->description, "Хасалт") !== false) {
                $credit_dans = 120101;
            }
            if (stripos($stat->description, "Хаалт") !== false) {
                $credit_dans = 120101;
            }
            if (stripos($stat->description, "Зөрүү") !== false) {
                $credit_dans = 310104;
            }

            $sheet2_array[] = array(
                $stat->number,
                $stat->tran_date,
                $stat->description,
                '',
                $debit_dans,
                1,
                number_format($amount, 2),
                number_format($amount, 2),
                $credit_dans,
                1,
                number_format($amount, 2),
                number_format($amount, 2),
                "",
                $mungu_uz
            );
        }
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle("JournalByTemplate");

        $rows = 1;
        foreach ($sheet1_array as $sheet1) {
            $sheet->setCellValue('A' . $rows, $sheet1[0]);
            $sheet->setCellValue('B' . $rows, $sheet1[1]);
            $sheet->setCellValue('C' . $rows, $sheet1[2]);
            $sheet->setCellValue('D' . $rows, $sheet1[3]);
            $sheet->setCellValue('E' . $rows, $sheet1[4]);
            $sheet->setCellValue('F' . $rows, $sheet1[5]);
            $rows++;
        }

        foreach (range('A', 'N') as $columnID) {
            $sheet->getColumnDimension($columnID)
                ->setAutoSize(true);
        }

        $spreadsheet->createSheet();
        $sheet = $spreadsheet->setActiveSheetIndex(1);
        $sheet->setTitle("JournalByAccount");

        $styleArray = array(
            'font' => array(
                'underline' => PHPExcel_Style_Font::UNDERLINE_SINGLE
            )
        );

        $rows = 1;
        foreach ($sheet2_array as $sheet2) {
            $sheet->setCellValue('A' . $rows, $sheet2[0]);
            $sheet->setCellValue('B' . $rows, $sheet2[1]);
            $sheet->setCellValue('C' . $rows, $sheet2[2]);
            $sheet->setCellValue('D' . $rows, $sheet2[3]);
            $sheet->setCellValue('E' . $rows, $sheet2[4]);
            $sheet->setCellValue('F' . $rows, $sheet2[5]);
            $sheet->setCellValue('G' . $rows, $sheet2[6]);
            $sheet->setCellValue('H' . $rows, $sheet2[7]);
            $sheet->setCellValue('I' . $rows, $sheet2[8]);
            $sheet->setCellValue('J' . $rows, $sheet2[9]);
            $sheet->setCellValue('K' . $rows, $sheet2[10]);
            $sheet->setCellValue('L' . $rows, $sheet2[11]);
            $sheet->setCellValue('M' . $rows, $sheet2[12]);
            $sheet->setCellValue('N' . $rows, $sheet2[13]);

            if ($rows === 1) {
                $sheet->getStyle('A' . $rows)->applyFromArray($styleArray);
                $sheet->getStyle('B' . $rows)->applyFromArray($styleArray);
                $sheet->getStyle('C' . $rows)->applyFromArray($styleArray);
                $sheet->getStyle('D' . $rows)->applyFromArray($styleArray);
                $sheet->getStyle('E' . $rows)->applyFromArray($styleArray);
                $sheet->getStyle('F' . $rows)->applyFromArray($styleArray);
                $sheet->getStyle('G' . $rows)->applyFromArray($styleArray);
                $sheet->getStyle('H' . $rows)->applyFromArray($styleArray);
                $sheet->getStyle('I' . $rows)->applyFromArray($styleArray);
                $sheet->getStyle('J' . $rows)->applyFromArray($styleArray);
                $sheet->getStyle('K' . $rows)->applyFromArray($styleArray);
                $sheet->getStyle('L' . $rows)->applyFromArray($styleArray);
                $sheet->getStyle('M' . $rows)->applyFromArray($styleArray);
                $sheet->getStyle('N' . $rows)->applyFromArray($styleArray);
            }

            $rows++;
        }
        foreach (range('A', 'N') as $columnID) {
            $sheet->getColumnDimension($columnID)
                ->setAutoSize(true);
        }
        $spreadsheet->createSheet();
        $sheet = $spreadsheet->setActiveSheetIndex(2);
        $sheet->setTitle("Journal");
        $rows = 1;
        foreach ($sheet3_array as $sheet3) {
            $sheet->setCellValue('A' . $rows, $sheet3[0]);
            $sheet->setCellValue('B' . $rows, $sheet3[1]);
            $sheet->setCellValue('C' . $rows, $sheet3[2]);
            $sheet->setCellValue('D' . $rows, $sheet3[3]);
            $sheet->setCellValue('E' . $rows, $sheet3[4]);
            $sheet->setCellValue('F' . $rows, $sheet3[5]);
            $sheet->setCellValue('G' . $rows, $sheet3[6]);
            $sheet->setCellValue('H' . $rows, $sheet3[7]);
            $sheet->setCellValue('I' . $rows, $sheet3[8]);
            $sheet->setCellValue('J' . $rows, $sheet3[9]);
            $sheet->setCellValue('K' . $rows, $sheet3[10]);
            $sheet->setCellValue('L' . $rows, $sheet3[11]);
            $sheet->setCellValue('M' . $rows, $sheet3[12]);
            $sheet->setCellValue('N' . $rows, $sheet3[13]);
            $sheet->setCellValue('O' . $rows, $sheet3[14]);
            $sheet->setCellValue('P' . $rows, $sheet3[15]);
            $sheet->setCellValue('Q' . $rows, $sheet3[16]);
            $sheet->setCellValue('R' . $rows, $sheet3[17]);
            $sheet->setCellValue('S' . $rows, $sheet3[18]);
            $rows++;
        }

        foreach (range('A', 'S') as $columnID) {
            $sheet->getColumnDimension($columnID)
                ->setAutoSize(true);
        }


        $fileName = "AcountChangedStatments" . "." . $type;
        if ($type == 'xlsx') {
            $writer = new Xlsx($spreadsheet);
        } else if ($type == 'xls') {
            $writer = new Xls($spreadsheet);
        }
        $writer->save("export/" . $fileName);
        header("Content-Type: application/vnd.ms-excel");
        return redirect(url('/') . "/export/" . $fileName);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public
    function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public
    function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public
    function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Statment $statment
     * @return \Illuminate\Http\Response
     */
    public
    function show(Statment $statment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Statment $statment
     * @return \Illuminate\Http\Response
     */
    public
    function edit(Statment $statment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Statment $statment
     * @return \Illuminate\Http\Response
     */
    public
    function update(Request $request, Statment $statment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Statment $statment
     * @return \Illuminate\Http\Response
     */
    public
    function destroy(Statment $statment)
    {
        //
    }
}
