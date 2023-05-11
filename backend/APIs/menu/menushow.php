<?php
include("../../../configure.php");  //抓取conifgure.php 的資料庫
$link = new PDO('mysql:host=' . $hostname . ';dbname=' . $database . ';charset=utf8', $username, $password); //用$link連結 連接資料庫
session_start();

if (isset($_POST['showPicH'])) {
    $showPicH = $_POST['showPicH'];
}

$ID = "";
if (isset($_SESSION['ID'])) { //如果儲存到ID 便取得存取ID的變數
    $ID = $_SESSION['ID'];
}
// echo $ID;
// exit;

$query = 'SELECT * FROM `bookstore`.`images` where `UserID` = :s_userId and `Idmenu` = :s_menuId  ';
$stmt = $link->prepare($query);
$stmt->bindValue(':s_menuId',$showPicH);
$stmt->bindValue(':s_userId',$ID);
$stmt->execute();

$reasult = $stmt->fetchall(PDO::FETCH_ASSOC);
echo json_encode($reasult);