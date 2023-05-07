<?php
include("../../../configure.php");  //抓取conifgure.php 的資料庫
$link = new PDO('mysql:host=' . $hostname . ';dbname=' . $database . ';charset=utf8', $username, $password);


if (isset($_POST["delOneMsg"])) {
    $delOneMsg = $_POST["delOneMsg"];
   

    $sql = " DELETE FROM `bookstore`.`message` Where  `ID` = :Si";
    $stmt = $link->prepare($sql);
    $stmt->bindValue("Si",$delOneMsg);
    $stmt->execute();

    


}
?>
