<?php
header("Content-Type: application/json");
// $data = json_decode(file_get_contents("php://input"), true);
include "dp_open.php";
session_start();
$account = $_SESSION['account'];

$id     = $_POST["id"];
$date   = $_POST["date"];
$water  = $_POST["water"];

if (empty($id) || empty($date) || empty($water)) {
    echo json_encode(["state" => false, "message" => "資料不完整，請重新填寫"]);
    exit;
}

$sql = "INSERT INTO water_records (id, account, date, water) VALUES (?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
// prepare() 就是 PHP 對 MySQL 說：「這是我要執行的 SQL，先幫我準備好位置，等等再把資料放進去。」

$stmt->bind_param("issi", 
    $id, $account, $date, $water);

// 執行
if($stmt->execute()){
    echo json_encode(["state" => true, "message" => "新增成功.$id"]);
}else{
    echo json_encode(["state" => false, "message" => "新增失敗", "error" => $stmt->error]);
}

$stmt->close();
$conn->close();
?>