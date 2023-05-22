<?php
include("../../../configure.php");  //抓取conifgure.php 的資料庫
$link = new PDO('mysql:host=' . $hostname . ';dbname=' . $database . ';charset=utf8', $username, $password); //用$link連結 連接資料庫
session_start(); //存取開始
if (isset($_SESSION['ID'])) { //如果儲存到ID 便取得存取ID的變數
    $ID = $_SESSION['ID'];
} else {
    // header("Location: ./errorPage/404.php"); //否則跳出404
}


$edittypeT = "";
$editTypeH = "";

if (isset($_POST['edittypeT'])) {
    $edittypeT = $_POST['edittypeT'];
}


if (isset($_POST['editTypeH'])) {
    $editTypeH = $_POST['editTypeH'];
    
}

if($editTypeH != "" && $edittypeT != ""){
    
    $sql = "UPDATE `bookstore`.`images` SET `Idmenu` = ? WHERE `PicNum` = ?";
    $data = [$edittypeT, $editTypeH];
    $stmt = $link->prepare($sql);
    $stmt->execute($data);
    header("Location: ../../../main.php");
}



    // $sql = "UPDATE `bookstore_manber` SET `CONTENT` = '$myText' WHERE `ID` = '$ID'";
    // // $data = [$myText,$ID];
    // $stmt = $link->prepare($sql);
    // $stmt->execute();
    // 





?>



<!DOCTYPE html>
<html lang="en">

<head>
    <script src="../../../js/lib/jquery.js"></script>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form action="" method="post">
        <select name="edittypeT" id="edittypeT" onchange="select(this)">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
        </select>
        <?php
        // echo "<input type= 'text' name = 'editTypeH' value = '".$editTypeH."'>";
        ?>
        <input type="text" name="editTypeH" value="<?php echo $editTypeH?>">
        <input type="submit" value="確認">
    </form>
</body>

<script>
    




    window.onload = function() {


        function select() {

        }

        $.ajax({
            type: 'POST',
            url: './menu.php',
            dataType: 'JSON',
            success: function(response) {
                var dropdown = document.getElementById('edittypeT');

                var menu = '<option name="">請選擇分類</option>';
                // console.log(response);
                for (var i = 0; i < response.length; i++) {
                    // console.log(response[i].idmenu + response[i].namemenu);
                    menu = menu + "<option value='" + response[i].idmenu + "'>" + response[i].namemenu + "</option>";
                    // menu = menu + "<option value='" + response[i].namemenu + "'>" +response[i].namemenu + "</option>";
                }
                dropdown.innerHTML = menu;


                // console.log(dropdown.innerHTML);


                // console.log(menu);
            }
        })


        
    }




    
        

       
    
</script>

</html>