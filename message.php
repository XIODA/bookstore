<?php
include("configure.php");  //抓取conifgure.php 的資料庫
$link = new PDO('mysql:host=' . $hostname . ';dbname=' . $database . ';charset=utf8', $username, $password); //用$link連結 連接資料庫

// if (isset($_SESSION['ID'])) { //如果儲存到ID 便取得存取ID的變數
//     $ID = $_SESSION['ID'];
// } else {
//     header("Location: ./errorPage/404.php"); //否則跳出404
// }

$messageT = "";
$messageH = "";

if (isset($_POST["messageH"])) {
    $messageH = $_POST["messageH"];
    if (isset($_POST["messageT"])) {
        $messageT = $_POST["messageT"];
        if ($messageT != "") {
            $sql = "INSERT INTO `bookstore`.`message` (`CONTENT`,`PicNum`) VALUE (?,?)";
            $data = [$messageT, $messageH];
            $sth = $link->prepare($sql);
            $sth->execute($data);


            // if (isset($_POST["messageH"])) {

            //     // $messageH = $_POST["messageH"];
        }
    }
}


    //     $messageOne = "";
    // } else {
    // }
    // $reasult = $stmt->fetchall(PDO::FETCH_ASSOC);
    // print_r($reasult);    
    // sleep(1);
    // header("Location: ./main.php");
    // }
