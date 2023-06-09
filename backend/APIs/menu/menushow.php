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

$startNumber = 0;
if (isset($_GET['page'])) {
  $page = $_GET['page'];
  $startNumber =  0 + ($page - 1) * 6;
}
// echo $ID;
// exit;

if($showPicH != 0){
  $query = 'SELECT * FROM `bookstore`.`images` where `UserID` = :s_userId and `Idmenu` = :s_menuId  limit :sp,6';
  // $query = 'SELECT * FROM `bookstore`.`images` ';
  $stmt = $link->prepare($query);
  $stmt->bindValue(':sp', $startNumber, PDO::PARAM_INT); //PDO::PARAM_INT = 數字格式
  $stmt->bindValue(':s_menuId', $showPicH);
  $stmt->bindValue(':s_userId', $ID);
  $stmt->execute();
  
  $reasult = $stmt->fetchall(PDO::FETCH_ASSOC);
  echo json_encode($reasult);

}else{
  $query = 'SELECT * FROM `bookstore`.`images` where `UserID` = :s_userId  limit :sp,6';
  // $query = 'SELECT * FROM `bookstore`.`images` ';
  $stmt = $link->prepare($query);
  $stmt->bindValue(':sp', $startNumber, PDO::PARAM_INT); //PDO::PARAM_INT = 數字格式
  // $stmt->bindValue(':s_menuId', $showPicH);
  $stmt->bindValue(':s_userId', $ID);
  $stmt->execute();
  
  $reasult = $stmt->fetchall(PDO::FETCH_ASSOC);
  echo json_encode($reasult);
}


if (false) {
  $query = 'SELECT * FROM `bookstore`.`images` where `UserID` = :s_userId';
  if ($showPicH != 0) {
    // $query = $query . " and `Idmenu` = :s_menuId  limit :sp,6";
    $query .= " and `Idmenu` = :s_menuId";
  }
  $query .= " limit :sp,6";
  // $query = 'SELECT * FROM `bookstore`.`images` ';
  $stmt = $link->prepare($query);
  $stmt->bindValue(':sp', $startNumber, PDO::PARAM_INT); //PDO::PARAM_INT = 數字格式
  if ($showPicH != 0) {
    $stmt->bindValue(':s_menuId', $showPicH);
  }
  $stmt->bindValue(':s_userId', $ID);
  $stmt->execute();
  
  $reasult = $stmt->fetchall(PDO::FETCH_ASSOC);
  echo json_encode($reasult);
}