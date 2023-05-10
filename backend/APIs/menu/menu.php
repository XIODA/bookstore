<?php
include("../../../configure.php");  //抓取conifgure.php 的資料庫
$link = new PDO('mysql:host=' . $hostname . ';dbname=' . $database . ';charset=utf8', $username, $password); //用$link連結 連接資料庫


if(isset($_POST['dropdown'])){
$dropdown = $_POST['dropdown'];
}


$query = 'SELECT * FROM `bookstore`.`menu` ';
$stmt = $link->prepare($query);
$stmt->execute();


// 取得多筆資料
$reasult = $stmt->fetchall(PDO::FETCH_ASSOC);
echo json_encode($reasult);