<?php
include "dp_open.php";
session_start();

$account = $_SESSION['account'];
$today = date("Y-m-d");

$sql_food = "SELECT 
            IFNULL(SUM(kal), 0) AS total_kal, 
            IFNULL(SUM(sugar), 0) AS total_sugar,
            IFNULL(SUM(na), 0) AS total_na
        FROM food_records WHERE date = ? AND account = ?";

$stmt_food = $conn->prepare($sql_food);
$stmt_food->bind_param("ss", $today,$account);
$stmt_food->execute();
$result_food = $stmt_food->get_result();
$row_food = $result_food->fetch_assoc();
// get_result()拿到資料庫回傳的結果集
// fetch_assoc()把結果轉成「陣列」

$sql_water = "SELECT IFNULL(SUM(water), 0) AS total_water FROM water_records WHERE date = ? AND account = ?";
$stmt_water = $conn->prepare($sql_water);
$stmt_water->bind_param("ss", $today,$account);
$stmt_water->execute();
$result_water = $stmt_water->get_result();
$row_water = $result_water->fetch_assoc();

$sql_sport = "SELECT IFNULL(SUM(total_kcal), 0) AS sport_kcal FROM sport_records WHERE date = ? AND account = ?";
$stmt_sport = $conn->prepare($sql_sport);
$stmt_sport->bind_param("ss", $today,$account);
$stmt_sport->execute();
$result_sport = $stmt_sport->get_result();
$row_sport = $result_sport->fetch_assoc();

echo json_encode(
    [
        "kal" => $row_food["total_kal"], 
        "sugar" => $row_food["total_sugar"], 
        "na" => $row_food["total_na"], 
        "water" => $row_water["total_water"], 
        "total_kcal" => $row_sport["sport_kcal"]
    ]);

$stmt_food->close();
$stmt_water->close();
$stmt_sport->close();
$conn->close();
?>