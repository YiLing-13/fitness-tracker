<?php
include "dp_open.php";
session_start();

if(!isset($_SESSION['account'])){
    echo json_encode([]);
    exit;
}
$date = $_GET['date'] ?? date("Y-m-d");
$account = $_SESSION['account'];

$sql = "SELECT id, date, water FROM water_records WHERE account = ? AND date = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $account,$date);
$stmt->execute();
$result = $stmt->get_result();
// get_result()拿到資料庫回傳的結果集
// fetch_assoc()把結果轉成「陣列」

$records = [];
while($row = $result->fetch_assoc()){
    $records[] = $row;
}

echo json_encode($records);

$stmt->close();
$conn->close();
?>