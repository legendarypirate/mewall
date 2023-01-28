
<?php

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
   $am = $obj->result[0]->amount;
   $int= $obj->result[0]->amount-(-1)*$obj->result[0]->zeeluldegdel;
   $int1=number_format($int,2,",",".");
   $last=number_format($am,2,",",".");
   $khonog=$obj->result[0]->khetersenkhonog+$obj->result[0]->honog;
   
  if($obj->result[0]->phone==$phone&&substr($number, -4)==substr($obj->result[0]->number, -4)){
//   print_r('{ "messages": [   {"text": "'.' Таны зээлийн хуримтлагдсан хүү: '.$int1.' .'.'Таны зээл нийт '.$obj->result[0]->khetersenkhonog.' хоног хэтэрсэн байна. '.$khonog.' хоног -' .$int1.' төгрөг.'.' Эргэн төлөлт хийх данс: 5099110014, Хаан банк, Бат-Эрдэнэ'.'"} ]}');
   
      print_r('{ "messages": [   {
      "attachment": {
        "type": "template",
        "payload": {
          "template_type": "button",
          "text": "Та доорх товчийг дарж ОТР код авна уу",
          "buttons": [
            {
              "type": "show_block",
              "block_names": ["OTP"],
              "title": "ОТР авах"
            }
          ]
        }
      }
    } ]}');


   
   
   
  } 
  
  else {
     print_r('{ "messages": [   {"text": "'.'Таны оруулсан мэдээлэл таарахгүй байна, дахин шалгана уу'.'"} ]}');
  }
  
   

   

   
   
   
?>
