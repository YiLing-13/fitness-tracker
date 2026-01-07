<?php
session_start();
header("Content-Type: application/json");
$data = json_decode(file_get_contents("php://input"), true);


$err = "";
$account = "";
$password = "";

if(isset($data['usrAccount'],$data['usrPassword'])){
    $account = $data['usrAccount'];
    $password = $data['usrPassword'];

    include "dp_open.php";

    $sql = "SELECT account,password, nickname FROM `users` WHERE account = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $account);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = mysqli_fetch_assoc($result);

    if (!$row){
        echo json_encode(["state" => false, "message" => "帳號密碼錯誤"]);
        exit;
    }
    else{  
        if (password_verify($password, $row['password'])) {
            $_SESSION['account']="$account";
            $_SESSION['nickname']=$row['nickname'];
            $_SESSION['sLogintime']=date("F j, Y, g:i a");
            echo json_encode(["state" => true]);
        }else
            echo json_encode(["state" => false, "message" => "帳號密碼錯誤"]);
            exit;
    }   

    echo json_encode(["state" => true]);
}


?>