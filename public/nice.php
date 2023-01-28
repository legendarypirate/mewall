
<?php
require_once "Database.php";


$utas=$_GET["phone"];
    
    $data = '{"id": 423, "dept_id": 192,"api_user": "altanbumba","psswrd": "PqJXg5toT3","phone": "'. $utas . '"}';

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
  
  
  foreach($obj->result as $customer)
{  

 $text='Tanii gereenii dugaar: '.$customer->number.' baritsaa: '.$customer->baritsaa.'';

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

  if($obj->result[0]->phone==$utas){
   print_r('{ "messages": [   {"text": "'.'Таны утсанд гэрээний дугаарыг илгээлээ'.'"} ]}');   
  }  
  else {
     print_r('{ "messages": [   {"text": "'.'Таны утас манай системд бүртгэлгүй байна'.'"} ]}');
  }
  

?>


