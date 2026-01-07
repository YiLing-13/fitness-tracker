<?php
header("Content-Type: application/json");
// $data = json_decode(file_get_contents("php://input"), true);
include "dp_open.php";
session_start();
$account = $_SESSION['account'];

$id     = $_POST["id"];
$date   = $_POST["date"];
$sportType  = $_POST["sportType"];
$hour     = $_POST["hour"];
$min      = $_POST["min"];
$kcal      = $_POST["kcal"];
$sportItems = json_decode($_POST["sport_items"], true);

$required = ["id","date","sportType","hour","min","kcal"];
foreach ($required as $item){
    if(!isset($_POST[$item]) || trim((string)$_POST[$item]) === ""){
        echo json_encode(["state" => false, "message" => "資料不完整，請重新填寫","missing" => $item]);
    exit;
    }
}

$sportItemsJson = json_encode($sportItems, JSON_UNESCAPED_UNICODE);

$sql = "INSERT INTO sport_records (id, account, date, sport_type , total_hour , total_min ,total_kcal ,sport_items) VALUES (?, ?, ?, ?,?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
// prepare() 就是 PHP 對 MySQL 說：「這是我要執行的 SQL，先幫我準備好位置，等等再把資料放進去。」

$stmt->bind_param("isssiiis", 
    $id, $account, $date, $sportType, $hour, $min, $kcal, $sportItemsJson);

// 執行
if($stmt->execute()){
    echo json_encode(["state" => true, "message" => "新增成功.$id"]);
}else{
    echo json_encode(["state" => false, "message" => "新增失敗", "error" => $stmt->error]);
}

$stmt->close();
$conn->close();
?>