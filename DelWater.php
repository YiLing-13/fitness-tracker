<?php
header("Content-Type: application/json");
$data = json_decode(file_get_contents("php://input"), true);
$id = $data["id"];

session_start();
$account = $_SESSION['account'];
include "dp_open.php";

if (!$id) {
    echo json_encode(["state" => false, "message" => "沒有收到 id"]);
    exit();
}

if($conn->connect_error){
    echo json_encode(["state" => true, "message" => "資料庫連線失敗"]);
    exit();
}

$sql = "DELETE FROM water_records WHERE id = ? AND account = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("is", $id,$account);

// 執行
if($stmt->execute()){
    echo json_encode(["state" => true, "message" => "刪除成功"]);
}else{
    echo json_encode(["state" => false, "message" => "刪除失敗", "error" => $stmt->error]);
}

$stmt->close();
$conn->close();
?>