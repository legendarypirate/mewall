<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Invoices;


class InvoicesController extends Controller
{

    public function chatbotinvoice(Request $request)
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

        $type = $request->type;
        $today = date("Y-m-d");
        $name = $request->name;
        $number = $request->number;
        $credit_id = $request->credit_id;
        $honog = $request->honog;

        $pid = rand(10000000, 99999999);
        $amount = $request->amount;
        $amount = round($amount, 2);
        $desc = 'chatbot';
        $billtype = "CBS0";

        if ($type === '5') {
            $desc = '30 хоногийн төлөлт';
            $billtype = 'CBS1';
        } else if ($type === '6') {
            $desc = 'Хуримтлагдсан хүү төлөлт';
            $billtype = 'CBS2';
        } else if ($type === '7') {
            $desc = 'Зээл хасалт';
            $billtype = 'CBS3';
        } else if ($type === '8') {
            $desc = 'Зээл хаалт';
            $billtype = 'CBS4';
        } else if ($type === '9') {
            $desc = '30 хоногийн төлөлт';
            $billtype = 'CBQ1';

        } else if ($type === '10') {
            $desc = 'Хуримтлагдсан хүү төлөлт';
            $billtype = 'CBQ2';
        } else if ($type === '11') {
            $desc = 'Зээл хасалт';
            $billtype = 'CBQ3';
        } else if ($type === '12') {
            $desc = 'Зээл хаалт';
            $billtype = 'CBQ4';

        } else if ($type === '13') {
            $desc = '30 хоногийн төлөлт';
            $billtype = 'CBS5';

        } else if ($type === '14') {
            $desc = 'Хуримтлагдсан хүү төлөлт';
            $billtype = 'CBS6';

        } else if ($type === '15') {
            $desc = '30 хоногийн төлөлт';
            $billtype = 'CBS61';

        } else if ($type === '16') {
            $desc = '30 хоногийн төлөлт';
            $billtype = 'CBS71';

        } else if ($type === '17') {
            $desc = '30 хоногийн төлөлт';
            $billtype = 'CBS81';

        } else if ($type === '18') {
            $desc = 'Хуримтлагдсан хүү төлөлт';
            $billtype = 'CBS7';

        } else if ($type === '19') {
            $desc = 'Хуримтлагдсан хүү төлөлт';
            $billtype = 'CBS8';

        }

        $phone = $request->phone;
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
        $invoiceEntry = new Invoices();
        $invoiceEntry->name = $name;
        $invoiceEntry->number = $number;
        $invoiceEntry->type = $type;
        $invoiceEntry->pid = $payid;
        $invoiceEntry->date_at = date('Y-m-d H:i:s');
        $invoiceEntry->amount = $amount;
        $invoiceEntry->status = "1";
        $invoiceEntry->honog = $honog;
        $invoiceEntry->invhonog = $honog;
        $invoiceEntry->desc = $desc;
        $invoiceEntry->phone = $phone;
        $invoiceEntry->bill_no = $bill_no;
        $invoiceEntry->credit_id = $credit_id;
        $invoiceEntry->client = "chat";
        $invoiceEntry->date = $today;
        $invoiceEntry->transaction_no = "";
        $invoiceEntry->transaction_date = "";
        $invoiceEntry->transaction_amount = "";
        $aldangi = 0;
        $khuu_guch = 0;
        if ($request->has("aldangi")) {
            $aldangi = $request->aldangi;
        }
        if ($request->has("khuu_guch")) {
            $khuu_guch = $request->khuu_guch;
        }
        $invoiceEntry->khuu = $khuu_guch;
        $invoiceEntry->aldangi = $aldangi;

        $invoiceEntry->save();

        return response()->json([
            'msg' => 'success',
            'type' => $type,
            'tug' => $amount,
            'link' => $payid,
            'success' => true,
            'status' => 200
        ]);
    }
}
