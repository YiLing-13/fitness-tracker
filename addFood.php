<?php
header("Content-Type: application/json");
include "dp_open.php";
session_start();
$account = $_SESSION['account'];


$id       = $_POST["id"];
$date     = $_POST["date"];
$fooditem = $_POST["fooditem"];
$hour     = $_POST["hour"];
$min      = $_POST["min"];
$sugar    = $_POST["sugar"];
$na       = $_POST["na"];
$kal      = $_POST["kal"];
$imgName = null;

// if (empty($id) || empty($date) || empty($fooditem) || empty($hour) || empty($min) || empty($sugar)|| empty($na)|| empty($kal)) {
//     echo json_encode(["state" => false, "message" => "資料不完整，請重新填寫"]);
//     exit;
// }

$required = ["id","date","fooditem","hour","min","sugar","na","kal"];
foreach ($required as $item){
    if(!isset($_POST[$item]) || trim((string)$_POST[$item]) === ""){
        echo json_encode(["state" => false, "message" => "資料不完整，請重新填寫","missing" => $item]);
    exit;
    }
}

$targetFile = null;
$targetDir = "uploads/";// 設定一個資料夾
if (!empty($_FILES["image"]["name"])) {
    // 獨一無二檔名
    $imgName = time() . "_" . $_FILES["image"]["name"];
    $targetFile = $targetDir . $imgName;    // 圖片路徑
    // 把上傳的圖片移進去 → move_uploaded_file()
    move_uploaded_file($_FILES["image"]["tmp_name"], "uploads/" . $imgName);
}

$sql = "INSERT INTO food_records
(id,account, date, fooditem, hour, min, sugar, na, kal, img)
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
// prepare() 就是 PHP 對 MySQL 說：「這是我要執行的 SQL，先幫我準備好位置，等等再把資料放進去。」

// issiiiiis  i=int s=字串
$stmt->bind_param("isssiiiiis", 
    $id, $account, $date, $fooditem, $hour, $min, $sugar, $na, $kal, $targetFile);

// 執行
if($stmt->execute()){
    echo json_encode(["state" => true, "message" => "新增成功"]);
}else{
    echo json_encode(["state" => false, "message" => "新增失敗", "error" => $stmt->error]);
}

$stmt->close();
$conn->close();
?>