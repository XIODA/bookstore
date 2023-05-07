<?php
include("configure.php");  //抓取conifgure.php 的資料庫
$link = new PDO('mysql:host=' . $hostname . ';dbname=' . $database . ';charset=utf8', $username, $password); //用$link連結 連接資料庫


$delmess = "";
$delmessH = "";

if (isset($_POST["delmess"])) {
    if (isset($_POST["delmessH"])) {
        $delmess = $_POST["delmess"];
        $delmessH = $_POST["delmessH"];
        
        $sql = "DELETE FROM `bookstore`.`message` Where  `PicNum` = :sP";
        $stmt = $link->prepare($sql);
        $stmt->bindValue(':sP',$delmessH);
        $stmt->execute();
    }
}
// $stmt->bindValue(':sn', $delmess);
// $stmt->bindValue(':sn1', $delmessH);


// if (isset($_POST["deleteOne"])) {
//     if (isset($_POST["DeleteP"])) {
//       $DeleteP = $_POST["DeleteP"];
  
//       $pic_db_one = "DELETE FROM `bookstore`.`images` WHERE `PicNum` = $DeleteP";
//       $sth = $link->prepare($pic_db_one);
//       $sth->execute();
//     }
//   }
  