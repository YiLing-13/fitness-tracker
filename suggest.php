<?php
include "dp_open.php";
session_start();

$account = $_SESSION['account'];

$sql = "SELECT account, gender, age, height, weight, activity_level
        FROM users WHERE account = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $account);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
// get_result()拿到資料庫回傳的結果集
// fetch_assoc()把結果轉成「陣列」

echo json_encode(
    [
        "gender" => $row["gender"], 
        "age" => $row["age"], 
        "height" => $row["height"], 
        "weight" => $row["weight"], 
        "activity_level" => $row["activity_level"]
    ]);

$stmt->close();
$conn->close();
?>