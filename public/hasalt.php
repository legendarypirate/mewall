<?php

$today=date("Y-m-d");

  
  $number=$_GET['number'];
  $hasalt=$_GET['hasalt'];


$first="AB";
$lst=substr($number, -4);
    $data17 = '{
    "id": 423, 
    "dept_id": 192,
    "api_user": "altanbumba",
    "psswrd": "PqJXg5toT3",
    "creditnumber": "'.$first.''.$lst.'"
 
}';        

ini_set("allow_url_fopen", 1);
    $sendURL = "https://procreditor.mn/api/api.php";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data17);
    curl_setopt($ch, CURLOPT_URL, $sendURL);
    $res17 = curl_exec($ch);
    curl_close($ch);
    $obj17=json_decode($res17);
    $udas=$obj17->result[0]->phone;
 
      
    $data3 = '{
    "id": 423, 
    "dept_id": 192,
    "api_user": "altanbumba",
    "psswrd": "PqJXg5toT3",
    "number": "' . $first . '' . $lst . '",
    "phone": "' . $udas . '"
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
 $khur=$obj3->result[0]->khuu+$obj3->result[0]->aldangi;



 $data4 = '{"type": "11",
"name": "'.$name.'",
"number": "' . $first . '' . $lst . '",
"amount": "'.$hasalt.'",
"phone": "'.$udas.'",
"khetersenkhonog": "'.$khet.'",
"honog": "'.$honog.'",
"khuu": "'.$hasalt.'",
"hurimtlagdsankhuu": "'.$hasalt.'",
"credit_id":"'.$cr.'"}';




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
  
   
   
   

   
  if( substr($number, -4)==substr($obj3->result[0]->number, -4)&&$khet==0){
//   print_r('{ "messages": [   {"text": "'.' Таны зээлийн хуримтлагдсан хүү: '.$int1.' .'.'Таны зээл нийт '.$obj->result[0]->khetersenkhonog.' хоног хэтэрсэн байна. '.$khonog.' хоног -' .$int1.' төгрөг.'.' Эргэн төлөлт хийх данс: 5099110014, Хаан банк, Бат-Эрдэнэ'.'"} ]}');
  
      print_r('{ "messages": [   {
      "attachment": {
        "type": "template",
        "payload": {
          "template_type": "button",
          "text": "Та хасалт хийх бол доорх товчийг дарна уу",
          "buttons": [
            {
             "type": "web_url",
              "url": "' . $payid . '",
              "webview_height_ratio": "compact",
              "title": "Хасалт хийх"
            }
          ]
        }
      }
    } ]}');

  } elseif( substr($number, -4)==substr($obj3->result[0]->number, -4)&&$khet>0) {
        print_r('{ "messages": [   {"text": "'.'Та эхлээд 30 хоногийн хүүгээ төлнө үү'.'"} ]}');
  }  else {
      
          print_r('{ "messages": [   {"text": "'.'Таны оруулсан мэдээлэл таарахгүй байна, дахин шалгана уу'.'"} ]}');
  }
  
?>
