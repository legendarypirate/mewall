<?php
require_once "Database.php";
$db = new Database();
$condition = array(
    "status" => "0"
);
$rows = $db->select(DB_NAME, TBL_NAME, null, $condition, "id DESC", "1");
$result = array(
    "status" => "fail",
    "number" => "null",
    "msg" => "null"
);
if ($rows) {
    $row = mysqli_fetch_array($rows);
    $result["status"] = "success";
    $result["id"] = $row["id"];
    $result["number"] = $row["number"];
    $result["msg"] = $row["msg"];
}
echo json_encode($result);


if (isset($_GET["id"]) && !empty($_GET["id"])) {
    $condition = array(
        "id" => $_GET["id"]
    );
    $col_val = array(
        "status" => "1"
    );
    $db->update(DB_NAME, TBL_NAME, $col_val, $condition);
}