<?php
include("../../../configure.php");  //抓取conifgure.php 的資料庫
$link = new PDO('mysql:host=' . $hostname . ';dbname=' . $database . ';charset=utf8', $username, $password); //用$link連結 連接資料庫

if (isset($_POST["PicNum"])) {
    $PicNum = $_POST["PicNum"];



    $query = 'SELECT `PicNum`,`CONTENT`,`DATE` FROM bookstore.message where `PicNum` = :sh';
    $stmt = $link->prepare($query);
    // $stmt->bindValue(':st', $messageT);
    $stmt->bindValue(':sh', $PicNum);
    $stmt->execute();
    $reasult = $stmt->fetchall(PDO::FETCH_ASSOC);
    
    echo json_encode($reasult);
}
