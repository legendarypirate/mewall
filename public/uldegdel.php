
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
 
 


require_once("send-sms.php");
$number=$_GET['number'];
$phone=$_GET['phone'];
$otp=$_GET['OTP'];
$first="AB";
$lst=substr($number, -4);
    $data = '{
    "id": 423, 
    "dept_id": 192,
    "api_user": "altanbumba",
    "psswrd": "PqJXg5toT3",
    "number": "' . $first . '' . $lst . '",
    "phone": "' . $phone . '"
}';   

   
   
   
     $number=$_GET['number'];
$phone=$_GET['phone'];
$otp=$_GET['OTP'];
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
    $res1 = curl_exec($ch);
    curl_close($ch);
    $objs=json_decode($res1);
    $ams = $objs->result[0]->amount;
    $ams1 = $objs->result[0]->zeeluldegdel;
    $tulult=$ams+$ams1;
     $name = $objs->result[0]->firstname;
     $khuu=$objs->result[0]->khuu;
   
   
  
   $am = $objs->result[0]->amount;
   $int= $objs->result[0]->amount-(-1)*$objs->result[0]->zeeluldegdel;
   $int1=number_format($int,2);
   $last=number_format($am,2,",",".");
   $khonog=$objs->result[0]->khetersenkhonog+$objs->result[0]->honog;
   $udur=$objs->result[0]->paymentdate;
   $date=strtotime($objs->result[0]->paymentdate);
    $todays=strtotime(date("Y/m/d"));
    $khurimt=$objs->result[0]->khuu;
    $last1=number_format($khurimt,2);
    $uls=(-1)*$objs->result[0]->zeeluldegdel;
     $ul=number_format($uls,2);
    $interval = (30*24*3600-($date-$todays))/24/3600;
  



  
   
     $pid=rand(10000000,99999999);    


   
   
    $data2 = '{
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
  "bill_no": "Хүү төлөлт ' . $first . '' . $lst . ' ' . $pid . '",
  "date":"' .$today. '",
  "description":"Зээлийн хүү төлөлт",
  "amount":' .$khuu. ',
  "btuk_code":"",
  "vat_flag": "0"
}';



$authorization="Authorization: Bearer $obj->access_token";
ini_set("allow_url_fopen", 1);
    $sendURL = "https://api.qpay.mn/v1/bill/create";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data2);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json',$authorization));
    curl_setopt($ch, CURLOPT_URL, $sendURL);
    $res = curl_exec($ch);
    curl_close($ch);
   $pol=json_decode($res);
  
   
   $payid=$pol->qPay_url;
   
   




   
   
   $number=$_GET['number'];
$phone=$_GET['phone'];
$otp=$_GET['OTP'];
$first="AB";
$lst=substr($number, -4);
    $data7 = '{
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
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data7);
    curl_setopt($ch, CURLOPT_URL, $sendURL);
    $req = curl_exec($ch);
    curl_close($ch);
   
  $obj8=json_decode($req);
   

  
 
  if($obj8->result[0]->phone==$phone&&$obj8->result[0]->khetersenkhonog>0){
  print_r('{ "messages": [  {"text":" Таны зээлийн үлдэгдэл -' .$ul.' төгрөг.'.'"}, {"text": "'.' Таны зээлийн хуримтлагдсан хүү: '.$int1.'"},   {"text": "'.'Таны зээл нийт '.$obj8->result[0]->khetersenkhonog.' хоног хэтэрсэн байна. '.'"},   {"text":"'.$khonog.' хоног -' .$int1.' төгрөг.'.'"}
  
  
  
  ]}');
  
    
   
  }  elseif ($obj8->result[0]->phone==$phone&&$obj8->result[0]->khetersenkhonog==0){
      
         print_r('{ "messages": [  {"text":" Таны зээлийн үлдэгдэл -' .$ul.' төгрөг.'.'"}, {"text": "'.' '.' Таны зээлийн ашигласан хүү: '.''.$interval.' хоног - '.$int1.' төгрөг.'.'"},{"text":"'.$udur.'-нд 30 хоног - ' .$last1.' төгрөг.'.'"}]}');
      
  }
  
  else {
     print_r('{ "messages": [   {"text": "'.'Таны оруулсан мэдээлэл таарахгүй байна, дахин шалгана уу'.'"} ]}');
  }
  
   
 
   

   
   
   
?>
