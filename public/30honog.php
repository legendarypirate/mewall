
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
  
  
  

  
    if($obj->result[0]->phone==$utas){
  foreach($obj->result as $customer)
{  

 $today=date("Y/m/d");

  

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
     $khet=$obj3->result[0]->khetersenkhonog;
     $honog= $obj3->result[0]->khetersenkhonog+30;
     $cr=$obj3->result[0]->credit_id;
$forkhuu=number_format($khuu);
$now=strtotime($today);
$paydate=strtotime($obj3->result[0]->paymentdate);
$diff=($paydate-$now)/3600/24;

 if($diff>=1&&$diff<5){
 $data4 = '{"type": "13",
"name": "'.$name.'",
"number": "' . $first . '' . $lst . '",
"amount": "'.$khuu.'",
"phone": "'.$phone.'",
"khetersenkhonog": "'.$khet.'",
"honog": "'.$honog.'",
"khuu": "'.$khuu.'",
"hurimtlagdsankhuu": "'.$ams.'",
"credit_id":"'.$cr.'"}';

} elseif($diff<-30&&$diff>-40) {
    $data4 = '{"type": "15",
"name": "'.$name.'",
"number": "' . $first . '' . $lst . '",
"amount": "'.$khuu.'",
"phone": "'.$phone.'",
"khetersenkhonog": "'.$khet.'",
"honog": "'.$honog.'",
"khuu": "'.$khuu.'",
"hurimtlagdsankhuu": "'.$ams.'",
"credit_id":"'.$cr.'"}';
    
    
}  elseif($diff<-40&&$diff>-60) {
    $data4 = '{"type": "16",
"name": "'.$name.'",
"number": "' . $first . '' . $lst . '",
"amount": "'.$khuu.'",
"phone": "'.$phone.'",
"khetersenkhonog": "'.$khet.'",
"honog": "'.$honog.'",
"khuu": "'.$khuu.'",
"hurimtlagdsankhuu": "'.$ams.'",
"credit_id":"'.$cr.'"}';
    
    
} elseif($diff<-60) {
    $data4 = '{"type": "17",
"name": "'.$name.'",
"number": "' . $first . '' . $lst . '",
"amount": "'.$khuu.'",
"phone": "'.$phone.'",
"khetersenkhonog": "'.$khet.'",
"honog": "'.$honog.'",
"khuu": "'.$khuu.'",
"hurimtlagdsankhuu": "'.$ams.'",
"credit_id":"'.$cr.'"}';
    
    
} else {
     $data4 = '{"type": "5",
"name": "'.$name.'",
"number": "' . $first . '' . $lst . '",
"amount": "'.$khuu.'",
"phone": "'.$phone.'",
"khetersenkhonog": "'.$khet.'",
"honog": "'.$honog.'",
"khuu": "'.$khuu.'",
"hurimtlagdsankhuu": "'.$ams.'",
"credit_id":"'.$cr.'"}';
    
    
}


ini_set("allow_url_fopen", 1);
    $sendURL = "https://www.altanbumba.com/api/invoice";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data4);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    curl_setopt($ch, CURLOPT_URL, $sendURL);
    $res4 = curl_exec($ch);
    curl_close($ch);
   $pol=json_decode($res4);
   

                $payid=$pol->link;
  
 if($diff>=1&&$diff<5){
  
  
   $text='Tanii '.$customer->number.'/'.$customer->phone.'/ zeeliin 30 honogiin huu tuluh udur '.$obj3->result[0]->paymentdate.'. Ta '.$forkhuu.' tug huugee ' .$payid. ' holboosoor tulj uramshuulald oroltsooroi';
   
   


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
  
  
}  elseif($diff<-30&&$diff>-40) {
         $text=''.$customer->number.' zeeliin huleelgiin hugatsaa hetersen tul dugaar haagdahiig anhaarna uu.Ta 30 honogiin '.$forkhuu.' tug huug ' .$payid. ' holboosoor tulnu uu';

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
    
} elseif($diff<-40&&$diff>-60) {
         $text=''.$customer->number.' zeeliin hugatsaa hetersen tul 90 honog deer dugaar huraagdahiig anhaarna uu. 30 honogiin '.$forkhuu.' tug huug ' .$payid. ' tulnu uu';
         


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
    
} elseif($diff<-60) {
         $text='Tanii '.$customer->number.' zeeld huraagdsan dugaar borluulaltiin alba ruu shuud shiljine. 30 honongiin '.$forkhuu.' tug huug ' .$payid. ' tulnu uu';
         


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
    
}else {
     $text='Tanii gereenii dugaar: '.$customer->number.' 30 honogiin tulult hiih bol ' .$payid. ' deer darna uu';

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
 
}


   print_r('{ "messages": [   {"text": "'.'Таны утсанд төлбөрт төлөх мэдээлэл илгээлээ.'.'"} ]}');   
  }  
  else {
     print_r('{ "messages": [   {"text": "'.'Таны утас манай системд бүртгэлгүй байна'.'"} ]}');
  }
  

?>


   
   
   
   
   
  