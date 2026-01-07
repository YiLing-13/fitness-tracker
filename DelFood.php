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

$sql = "SELECT img FROM food_records WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode(["state" => false, "message" => "找不到此筆資料"]);
    exit();
}

$row = $result->fetch_assoc();
$imgPath = $row["img"];  // 資料庫中儲存的例如：upload/20251210_abc.jpg

$stmt->close();

$sql = "DELETE FROM food_records WHERE id = ? AND account = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("is", $id, $account);

// 執行
if(!$stmt->execute()){
    echo json_encode(["state" => false, "message" => "刪除失敗", "error" => $stmt->error]);
}

if ($imgPath && file_exists($imgPath)) {

    if (unlink($imgPath)) {
        $imgDeleteMsg = "圖片已刪除";
    } else {
        $imgDeleteMsg = "圖片刪除失敗（可能權限問題或檔案被占用）";
    }

} else {
    $imgDeleteMsg = "圖片不存在，無需刪除";
}

echo json_encode([
    "state" => true,
    "message" => "刪除成功",
    "imgMessage" => $imgDeleteMsg
]);

$stmt->close();
$conn->close();
?>