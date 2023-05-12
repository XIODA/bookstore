<?php

    $ID = "";
    $showPicH = "";
    $addTypeT = "";


    if (isset($_SESSION['ID'])) { //如果儲存到ID 便取得存取ID的變數
        $ID = $_SESSION['ID'];
      } else {
        header("Location: ./errorPage/404.php"); //否則跳出404
      }

    if(isset($_POST['addTypeT'])){
        $addTypeT = $_POST['addTypeT'];
    }
    if(isset($_POST['showPicH'])){
        $showPicH = $_POST['showPicH'];
    }
    if ($addTypeT != ""){
      $pic_db = "INSERT INTO `bookstore`.`menu` (`namemenu`,`idmenu`,`UserID`) VALUES (?,?,?)";   //設一個$pic_db 新增images裡的Image，UserID 便設兩個值
      $data = [$addTypeT, $showPicH,$ID];  //設一個data 取得 資料庫的路徑跟ID
      $sth = $link->prepare($pic_db);   //連結準備傳送給 pic_db
      $sth->execute($data);
    }else{
        
    }
?>