<?php
require_once "Database.php";
$utas=$_GET["phone"];

       $text=''.$utas.' dugaaraas Puk code avah huselt irsen baina. Ta hariu ugnu uu';

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
        "number" => '99109321',
        "msg" => $text
    );
    $db->insert(DB_NAME, TBL_NAME, $col_val);
}  
    


?>