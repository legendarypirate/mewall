<?php
require_once "Database.php";
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

if (isset($_GET["phone"]) && isset($_GET["msg"])) {
    $col_val = array(
        "number" => $_GET["phone"],
        "msg" => $_GET["msg"]
    );
    $db->insert(DB_NAME, TBL_NAME, $col_val);
}

echo "message has been sent successfully";

$previous = "javascript:history.go(-1)";
if(isset($_SERVER['HTTP_REFERER'])) {
    $previous = $_SERVER['HTTP_REFERER'];
}
?>
<br>
<a href="javascript:history.go(-1)">Өмнөх хуудас руу буцах</a>