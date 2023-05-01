<?php
// 建立與MySQL資料庫的連線
include("configure.php");  //抓取conifgure.php 的資料庫
$link = new PDO('mysql:host=' . $hostname . ';dbname=' . $database . ';charset=utf8', $username, $password); //用$link連結 連接資料庫
session_start(); //存取開始
if (isset($_SESSION['ID'])) { //如果儲存到ID 便取得存取ID的變數
    $ID = $_SESSION['ID'];
} else {
    header("Location: ./errorPage/404.php"); //否則跳出404
}



$myText = "";
// $myName = "";

if (isset($_POST["myText"])) {
    $myText = $_POST["myText"];
}
// if (isset($_POST["myName"])) {
//     $myName = $_POST["myName"];
// }

if ($myText != "") {
    $sql = "UPDATE `bookstore_manber` SET `CONTENT` = ? WHERE `ID` = ?";
    $data = [$myText,$ID];
    $stmt = $link->prepare($sql);
    $stmt->execute($data);

    // $sql = "UPDATE `bookstore_manber` SET `CONTENT` = '$myText' WHERE `ID` = '$ID'";
    // // $data = [$myText,$ID];
    // $stmt = $link->prepare($sql);
    // $stmt->execute();
    header("Location: ./main.php");
} else {
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>書庫編輯</title>
</head>

<body>
    <form action="" method="POST">
        <!-- <input type = text name="myName" placeholder="請更改您的名字"> -->
        <textarea name="myText" rows="8" cols="40" placeholder="請更改您的內容(至少10個字)" maxlength="50" minlength="10">

        </textarea>

        <input type="submit" value="送出">
    </form>
</body>

</html>