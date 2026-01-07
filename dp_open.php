<?php
$config = require __DIR__.'/config.php';
// 建立MySQL的資料庫連接 
$conn = mysqli_connect(
        $config['host'],
        $config['username'],
        $config['password'],
        $config['database']
)
                //        ip位置,帳號,密碼,資料庫名字
        or die("Can not open MySQL database!<br/>");
mysqli_query($conn, "set names 'UTF8' ");

?>