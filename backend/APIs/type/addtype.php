<?php
    $showPicH = "";
    $addTypeT = "";

    if(isset($_POST['addTypeT'])){
        $addTypeT = $_POST['addTypeT'];
    }
    if(isset($_POST['showPicH'])){
        $showPicH = $_POST['showPicH'];
    }
    if ($addTypeT != ""){
      $pic_db = "INSERT INTO `bookstore`.`menu` (`namemenu`,`idmenu`) VALUES (?,?)";   //設一個$pic_db 新增images裡的Image，UserID 便設兩個值
      $data = [$addTypeT, $showPicH];  //設一個data 取得 資料庫的路徑跟ID
      $sth = $link->prepare($pic_db);   //連結準備傳送給 pic_db
      $sth->execute($data);
    }else{
        
    }
?>