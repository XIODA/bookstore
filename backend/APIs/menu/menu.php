<?php
include("../../../configure.php");  //抓取conifgure.php 的資料庫
$link = new PDO('mysql:host=' . $hostname . ';dbname=' . $database . ';charset=utf8', $username, $password); //用$link連結 連接資料庫
session_start();
$ID = "";

if (isset($_SESSION['ID'])) { //如果儲存到ID 便取得存取ID的變數
    $ID = $_SESSION['ID'];
}

if(isset($_POST['dropdown'])){
$dropdown = $_POST['dropdown'];
}


$query = 'SELECT * FROM `bookstore`.`menu` where `UserID` = :userId';
$stmt = $link->prepare($query);
$stmt->bindValue(':userId',$ID);
$stmt->execute();


// 取得多筆資料
$reasult = $stmt->fetchall(PDO::FETCH_ASSOC);
echo json_encode($reasult);