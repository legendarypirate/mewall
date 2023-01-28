
<?php
require_once "Database.php";

$utas=$_GET["phone"];
    
    $data = '{"id": 423, "dept_id": 192,"api_user": "altanbumba","psswrd": "PqJXg5toT3","phone": "' .$utas. '"}';

ini_set("allow_url_fopen", 1);
    $sendURL = "https://procreditor.mn/api/api.php";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_URL, $sendURL);
    $result = curl_exec($ch);
    curl_close($ch);
   
   
   
  
  
  $obj=json_decode($result);
  
  
  
    $number=$customer->number;
$phone=$customer->phone;

$first="AB";
$lst=substr($number, -4);
    $data9 = '{
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
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data9);
    curl_setopt($ch, CURLOPT_URL, $sendURL);
    $res9 = curl_exec($ch);
    curl_close($ch);
    $obj9=json_decode($res9);
    $ams = $obj9->result[0]->amount;
    $ams1 = $obj9->result[0]->zeeluldegdel;
    $tulult=$ams+$ams1;
     $name = $obj9->result[0]->firstname;
     $khuu=$obj9->result[0]->khuu;
     $pid=rand(10000000,99999999);

  
  
  
  
  foreach($obj->result as $customer)
{  

 $today=date("Y-m-d");

    $data1 = '{
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
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    curl_setopt($ch, CURLOPT_URL, $sendURL);
    $result1 = curl_exec($ch);
    curl_close($ch);
   
   $obj1=json_decode($result1);
 



  $number=$customer->number;
$phone=$customer->phone;

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
    $res3 = curl_exec($ch);
    curl_close($ch);
    $obj3=json_decode($res3);
    $ams = $obj3->result[0]->amount;
    $ams1 = $obj3->result[0]->zeeluldegdel;
    $tulult=$ams+$ams1;
     $name = $obj3->result[0]->firstname;
     $khuu=$obj3->result[0]->khuu;
     $pid=rand(10000000,99999999);






 $data4 = '{
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
  "bill_no": "30 хоног ' . $first . '' . $lst . ' ' . $pid . '",
  "date":"' .$today. '",
  "description":"Зээлийн хүү төлөлт",
  "amount":' .$khuu. ',
  "btuk_code":"",
  "vat_flag": "0"
}';



$authorization="Authorization: Bearer $obj1->access_token";
ini_set("allow_url_fopen", 1);
    $sendURL = "https://api.qpay.mn/v1/bill/create";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data4);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json',$authorization));
    curl_setopt($ch, CURLOPT_URL, $sendURL);
    $res4 = curl_exec($ch);
    curl_close($ch);
   $pol=json_decode($res4);
   
   if(isset($pol->qPay_deeplink)){
  $dataxx =  $pol->qPay_deeplink;
            foreach($dataxx as $pols){
                $payid=$pol->qPay_shortUrl;
                
            }
   
   }
   
 
  $text='Tanii gereenii dugaar: '.$customer->number.' tulult hiih bol ' .$payid. ' deer darna uu';

 $db = new Database();
if (!$db->isTableExists(DB_NAME, TBL_NAME)) {
    $col = array(
        "id" => "int NOT NULL AUTO_INCREMENT ",
        "number" => "TEXT NOT NULL ",
        "msg" => "TEXT NOT NULL ",
        "status" => "varchar(244) NOT NULL default false",
        "PRIMARY" => "KEY (id)"
    );
    $db->createTable(DB_NAME, TBL_NAME, $col);
}

if (isset($_GET["phone"])) {
    $col_val = array(
        "number" => $_GET["phone"],
        "msg" => $text
    );
    $db->insert(DB_NAME, TBL_NAME, $col_val);
}

 
}

//   if($obj9->result[0]->phone==$utas){
//   print_r('{ "messages": [   {"text": "'.'Таны утсаа шалгана уу'.'"} ]}');   
//   }  
//   else {
//      print_r('{ "messages": [   {"text": "'.'Таны утас манай системд бүртгэлгүй байна'.'"} ]}');
//   }
  
 print_r($obj9->result[0]->phone);
?>



   
   
   
   
   
  