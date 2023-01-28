<?php

namespace App\Http\Controllers;


use App\Credit;
use DateTime;
use Illuminate\Http\Request;

class CreditController extends Controller
{

    public function index()
    {
        $creditEntry = new Credit();
        return view('admin.credit.creditEntry');
    }

    public function manage(Request $request)
    {

        $data1 = '{
            "id": 423,
            "dept_id": 192,
            "api_user": "altanbumba",
            "psswrd": "PqJXg5toT3",
            "allcredit": "allcredit"
            }';

        ini_set("allow_url_fopen", 1);
        $sendURL = "https://procreditor.mn/api/api.php";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data1);
        curl_setopt($ch, CURLOPT_URL, $sendURL);
        $result1 = curl_exec($ch);
        curl_close($ch);
        $data2 = json_decode($result1);

        foreach ($data2->result as $customer) {
//            if ($customer->number === 'AB3830') {
            $data4 = '{
                "id": 423, 
                "dept_id": 192,
                "api_user": "altanbumba",
                "psswrd": "PqJXg5toT3",
                "number": "' . $customer->number . '",
                "phone": "' . $customer->phone . '"
            }';

            ini_set("allow_url_fopen", 1);
            $sendURL = "https://procreditor.mn/api/api.php";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data4);
            curl_setopt($ch, CURLOPT_URL, $sendURL);
            $urdun = curl_exec($ch);
            curl_close($ch);

            $data3 = json_decode($urdun);

            if ($data3->status === 'OK') {
                $detail = $data3->result[0];
                $customer->lastname = $detail->lastname;
                $customer->amount = $detail->amount;
                $customer->huramtlagdsankhuu = $detail->huramtlagdsankhuu;
                $customer->aldangi = $detail->aldangi;
                $customer->khuu = $detail->khuu;
                $customer->assessment = $detail->assessment;
                $customer->zeeluldegdel = $detail->zeeluldegdel;
                $customer->khetersenkhonog = $detail->khetersenkhonog;
                $customer->honog = $detail->honog;
                $customer->registernumber = $detail->registernumber;
                $customer->firstname = $detail->firstname;
                $customer->address = $detail->address;
                $customer->paymentdate = $detail->paymentdate;
            } else {
                $customer->lastname = "";
                $customer->amount = "";
                $customer->huramtlagdsankhuu = "";
                $customer->aldangi = "";
                $customer->khuu = "";
                $customer->assessment = "";
                $customer->zeeluldegdel = "";
                $customer->khetersenkhonog = "";
                $customer->honog = "";
                $customer->registernumber = "";
                $customer->firstname = "";
                $customer->address = "";
                $customer->paymentdate = "";
            }

        }

        Credit::truncate();
        foreach ($data2->result as $customer) {
            $creditEntry = new Credit();
            $creditEntry->credit_id = $customer->credit_id;
            $creditEntry->number = $customer->number;
            $creditEntry->phone = $customer->phone;
            $creditEntry->secondphone = $customer->secondphone;
            $creditEntry->duusah_honog = $customer->duusah_honog;
            //detail info
            $creditEntry->lastname = $customer->lastname;
            $creditEntry->amount = $customer->amount;
            $creditEntry->huramtlagdsankhuu = $customer->huramtlagdsankhuu;
            $creditEntry->aldangi = $customer->aldangi;
            $creditEntry->khuu = $customer->khuu;
            $creditEntry->assessment = $customer->assessment;
            $creditEntry->zeeluldegdel = $customer->zeeluldegdel;

            $creditEntry->khetersenkhonog = $customer->khetersenkhonog === null ? 0 : $customer->khetersenkhonog;
            $creditEntry->honog = $customer->honog;

            $creditEntry->registernumber = $customer->registernumber;
            $creditEntry->firstname = $customer->firstname;
            $creditEntry->address = $customer->address;
            $creditEntry->paymentdate = $customer->paymentdate;

            $creditEntry->save();
        }


//        }

        return response()->json([
            'msg' => 'success',
            'success' => true,
            'status' => 200
        ]);
    }


    public function credits()
    {
        $results = Credit::select('credits.*')
            ->get();
        return view('admin.loan.loanCredits', ['datas' => $results]);
    }


    public function filtercredit(Request $request)
    {

        $result = Credit::query()
            ->where('phone', '=', $request->filter)
            ->orWhere('number', '=', $request->filter)
            ->get();


        foreach ($result as $item) {
            $today = date("Y/m/d");
            $datetime1 = new DateTime($item->duusah_honog);
            $datetime2 = new DateTime($today);
            $interval = $datetime1->diff($datetime2);
            $days = $interval->format('%a');
            $curhonog = 0;
            $inputhuu = 0;
            if ($item->khetersenkhonog === '0') {
                $curhonog = (30 - ($days));
                $inputhuu = $item->huramtlagdsankhuu;
            } else {
                $curhonog = $item->khetersenkhonog + 30;
                $inputhuu = $item->khuu + $item->aldangi;
            }
            $item->inputhuu = $inputhuu;
            $item->curhonog = $curhonog;
            $onedaykhuu = $item->khuu / 30;
            $item->onedaykhuu = $onedaykhuu;
            $item->uldegdel = number_format(-1 * $item->zeeluldegdel, 1);
            $item->hurimtlagdsan = number_format($item->khuu + $item->aldangi, 2);
            $item->tuluh_dun = number_format($item->amount, 2);

        }

        return response()->json([
            'msg' => 'success',
            'result' => $result,
            'success' => true,
            'status' => 200
        ]);
    }


    public function delete()
    {
        $creditDelete = Credit::truncate();

        return redirect()->back()->with('message', 'Амжилттай устгагдлаа');;
    }

}

