<?php

$today=date("Y-m-d");

    $data = '{
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
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    curl_setopt($ch, CURLOPT_URL, $sendURL);
    $result = curl_exec($ch);
    curl_close($ch);
   
   $obj=json_decode($result);
 


  $number=$_GET['number'];
$phone=$_GET['phone'];

$first="AB";
$lst=substr($number, -4);
    $data3 = '{
    "id": 423, 
    "dept_id": 192,
    "api_user": "altanbumba",
    "psswrd": "PqJXg5toT3",
    "number": "' . $first . '' . $lst . '",
    "phone": "' . $phone . '"
}';        

ini_set("allow_url_fopen", 1);
    $sendURL = "https://procreditor.mn/api/api.php";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data3);
    curl_setopt($ch, CURLOPT_URL, $sendURL);
    $res15 = curl_exec($ch);
    curl_close($ch);
    $objs=json_decode($res15);
    $ams = $objs->result[0]->amount;
    $ams1 = $objs->result[0]->zeeluldegdel;
    $tulult=$ams+$ams1;
     $name = $objs->result[0]->firstname;
   
   
   

   
   $pid=rand(10000000,99999999);
   
   


    $data1 = '{
  "template_id": "ALTANBUMBA_INVOICE",
  "merchant_id": "ALTANBUMBA",
  "branch_id": "1",
  "pos_id": "1",
  "receiver": {
    "id": "' .$name. '",
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
  "bill_no": "Хүү төлөх ' . $first . '' . $lst . '' . $pid . '",
  "date":"' .$today. '",
  "description":"Зээлийн хүү төлөлт",
  "amount":' .$tulult. ',
  "btuk_code":"",
  "vat_flag": "0"
}';



$authorization="Authorization: Bearer $obj->access_token";
ini_set("allow_url_fopen", 1);
    $sendURL = "https://api.qpay.mn/v1/bill/create";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json',$authorization));
    curl_setopt($ch, CURLOPT_URL, $sendURL);
    $res = curl_exec($ch);
    curl_close($ch);
   $pol=json_decode($res);
  
   
   $payid=$pol->qPay_url;
   
   
   
   
   
   
   
   

    $data12 = '{
    "id": 423, 
    "dept_id": 192,
    "api_user": "altanbumba",
    "psswrd": "PqJXg5toT3",
    "number": "' . $first . '' . $lst . '",
    "phone": "' . $phone . '"
}';        

ini_set("allow_url_fopen", 1);
    $sendURL = "https://procreditor.mn/api/api.php";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data12);
    curl_setopt($ch, CURLOPT_URL, $sendURL);
    $req = curl_exec($ch);
    curl_close($ch);
   
   $obj19=json_decode($req);
   $am = $obj19->result[0]->amount;
   $int= $obj19->result[0]->amount-(-1)*$obj19->result[0]->zeeluldegdel;
   $int1=number_format($int,2,",",".");
   $last=number_format($am,2,",",".");
   $khonog=$obj19->result[0]->khetersenkhonog+$obj19->result[0]->honog;
  
     $dates=strtotime($obj19->result[0]->paymentdate);
 $todays=strtotime(date("Y/m/d"));

   
    $intervals = $dates-$todays;
  
  if(   $intervals>0&&$obj19->result[0]->phone==$phone&&substr($number, -4)==substr($obj19->result[0]->number, -4)){
//   print_r('{ "messages": [   {"text": "'.' Таны зээлийн хуримтлагдсан хүү: '.$int1.' .'.'Таны зээл нийт '.$obj->result[0]->khetersenkhonog.' хоног хэтэрсэн байна. '.$khonog.' хоног -' .$int1.' төгрөг.'.' Эргэн төлөлт хийх данс: 5099110014, Хаан банк, Бат-Эрдэнэ'.'"} ]}');
   
  
    print_r('{ "messages": [   {"text": "'.'Та зээлийн хүүгийн төлбөрөө 30 хоногт төлнө үү'.'"} ]}');

   
   
   
  } 
  
  elseif ($intervals<=0&&$obj19->result[0]->phone==$phone&&substr($number, -4)==substr($obj19->result[0]->number, -4)) {
 
     
      print_r('{ "messages": [   {
      "attachment": {
        "type": "template",
        "payload": {
          "template_type": "button",
          "text": "Та зээлийн хүү төлөх бол доорх товчийг дарна уу",
          "buttons": [
            {
             "type": "web_url",
              "url": "' . $payid . '",
              "webview_height_ratio": "compact",
              "title": "Хүү төлөх"
            }
          ]
        }
      }
    } ]}');
  } else {
      
           print_r('{ "messages": [   {"text": "'.'Таны оруулсан мэдээлэл таарахгүй байна, дахин шалгана уу'.'"} ]}');
  }
  
  
   

   
   
   
   
   
   
?>
