<?php
include "dp_open.php";

$account        = $_POST["account"];
$password       = $_POST["password"];
$passwordHash = password_hash($password, PASSWORD_DEFAULT);
$nickname       = $_POST["nickname"];
$gender         = $_POST["gender"];
$age            = $_POST["age"];
$height         = $_POST["height"];
$weight         = $_POST["weight"];
$activity       = $_POST["activity"];

if (
    empty($account) ||
    empty($password) ||
    empty($gender) ||
    empty($nickname) ||
    empty($age) ||
    empty($height) ||
    empty($weight) ||
    empty($activity)
) {
    echo json_encode(["state" => false,"message" => "資料不齊全"]);
    exit;
}

// LIMIT 1找一筆
$checksql = "SELECT id FROM users WHERE account = ? LIMIT 1";
$checkstmt = $conn->prepare($checksql);
$checkstmt->bind_param("s",$account);
$checkstmt->execute();
$checkstmt = $checkstmt->get_result();
if($checkstmt->num_rows > 0){
     echo json_encode(["state" => false, "message" => "帳號已存在"]);
    exit;
}

$sql = "INSERT INTO users
(account, password, nickname, gender, age, height, weight, activity_level)
VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
// prepare() 就是 PHP 對 MySQL 說：「這是我要執行的 SQL，先幫我準備好位置，等等再把資料放進去。」

$stmt->bind_param("ssssidds", 
    $account, $passwordHash , $nickname, $gender, $age , $height, $weight, $activity);

// 執行
if($stmt->execute()){
    echo json_encode(["state" => true, "message" => "新增成功"]);
}else{
    echo json_encode(["state" => false, "message" => "新增失敗", "error" => $stmt->error]);
}

$stmt->close();
$conn->close();
?>