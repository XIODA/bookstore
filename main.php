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

//頁數計算
$pagequery = 'SELECT count(*) as page_1 FROM bookstore.images where `UserID` = :usid';
$stmt = $link->prepare($pagequery);
$stmt->bindValue(':usid', $ID);
$stmt->execute();
$reasult = $stmt->fetchall(PDO::FETCH_ASSOC);

$picnumber = $reasult[0]['page_1'];
// echo $pgnumber;
$pgnumber = $picnumber / 6;
// echo ceil($pgnumber);






?>

<!-- 類別頁數計算 -->

<?php
$showPicH = "";
if (isset($_GET['menuid'])) {
  $showPicH = $_GET['menuid'];
}

$ID = "";
if (isset($_SESSION['ID'])) { //如果儲存到ID 便取得存取ID的變數
  $ID = $_SESSION['ID'];
}


$query = 'SELECT count(*) as page_type FROM `bookstore`.`images` where `UserID` = :s_userId and `Idmenu` = :s_menuId ';
$stmt = $link->prepare($query);
$stmt->bindValue(':s_menuId', $showPicH);
$stmt->bindValue(':s_userId', $ID);
$stmt->execute();

$reasult = $stmt->fetchall(PDO::FETCH_ASSOC);
// print_r($reasult) ;
// print_r($reasult[0]['page_type']);
$pagetype = $reasult[0]['page_type'];
$pagetype_1 = $pagetype / 6;
// echo $pagetype_1;
// exit;
?>

<!-- 新增圖片 -->
<?php
if (isset($_POST['upload'])) {  //如果抓取到upload
  $input_image = $_FILES['image']['name'];  //  設一個變數抓取檔案圖片及名字
  $image_info = @getimagesize($input_image);  //拿到圖片的資訊
  if ($image_info != false) { //如果圖片不正確的話
    echo "The selected file is not image."; //回傳這不是張圖片
  } else {

    $image_array = explode('.', $input_image);  //否則
    // $rand = rand(10000, 99999);
    $image_new_name = "p" . strtotime(date("Ymd His")) . "." . $image_array[1];
    // $image_new_name=$image_array[0].'.'.$image_array[1];
    // $image_new_name = $image_array[0] . $rand . '.' . $image_array[1];
    $image_upload_path = "uploads/" . $image_new_name;
    // echo "p".strtotime(date("Ymd His"));


    $is_uploaded = move_uploaded_file($_FILES["image"]["tmp_name"], $image_upload_path);  //上傳圖片
    if ($is_uploaded) {  //如果圖片能夠上傳


      $select = "select * from `images`";   //拿到images的資料
      $pic_db = "INSERT INTO `bookstore`.`images` (`Image`,`UserID`) VALUES (?,?)";   //設一個$pic_db 新增images裡的Image，UserID 便設兩個值
      $data = [$image_upload_path, $ID];  //設一個data 取得 資料庫的路徑跟ID
      $sth = $link->prepare($pic_db);   //連結準備傳送給 pic_db
      $sth->execute($data);






      // $file = '../$image_array.png';
      // $type = 'image/jpeg';
      // header('Content-Type:' . $type);
      // header('Content-Length: ' . filesize($file));
      // readfile($file);
      // echo 'Image Successfully Uploaded';
    } else {
      echo 'Something Went Wrong!';
    }
  }
}

?>
<!-- 刪除全部圖片 -->
<?php
// 建立與MySQL資料庫的連線

if (isset($_POST["deleteAll"])) {
  //$deleteAll= $_POST["deleteAll"];
  //echo $deleteAll;

  $pic_db = "DELETE FROM `bookstore`.`images`";
  $sth = $link->prepare($pic_db);
  $sth->execute();
}
?>

<!-- 刪除單張圖片 -->
<?php
if (isset($_POST["deleteOne"])) {
  if (isset($_POST["DeleteP"])) {
    $DeleteP = $_POST["DeleteP"];

    $pic_db_one = "DELETE FROM `bookstore`.`images` WHERE `PicNum` = :sp ";
    $sth = $link->prepare($pic_db_one);
    $sth->bindValue(':sp', $DeleteP);
    $sth->execute();
  }
}

?>


<!-- 頁數分頁  -->
<?php
$startNumber = 0;
if (isset($_GET['page'])) {
  $page = $_GET['page'];
  $startNumber =  0 + ($page - 1) * 6;
}


?>





<!DOCTYPE html>
<html lang="en">

<head>
  <link rel="Website Icon" type="png" href="./img/5.png">
  <title>書庫</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
  <style>
 
 


    body,
    h1,
    h2,
    h3,
    h4,
    h5 {
      font-family: "Raleway", sans-serif
    }

    .w3-third img {
      margin-bottom: -6px;
      opacity: 0.8;
      cursor: pointer
    }

    .w3-modal-content {
      display: flex;
    }

    .message {
      text-align: right;
      padding-left: 20%;
    }

    .w3-third {
      transition: 0.5s ease-in-out;
    }

    .w3-third:hover {
      transform: scale(1.2, 1.2);
      /* transform: scale(0.8, 0.8) ; */
    }

    a {
      text-decoration: none;
      color: yellowgreen;
    }

    .image {
      overflow: hidden;
      /* border-style: solid; */
      width: 350px;
      height: 350px;
      padding: 10px;
      margin: 20px;
      /* text-align: center; */
    }

    .color {
      color: white !important;
      background-color: black !important;
    }
  </style>
  <link rel="stylesheet" type="text/css" href="message.css">
  <link rel="stylesheet" type="text/css" href="./css/menu.css">
  <link rel="stylesheet" type="text/css" href="./css/toggle.css">
  <link rel="stylesheet" type="text/css" href="./css/bganimation.css">
  <script src="./js/lib/jquery.js"></script>
  <script src="./js/menu/dropdown.js"></script>
  <script src="./js/type/addtype.js"></script>
  <script src="./js/type/toggle.js"></script>
  <script src="./js/page.js"></script>
  <script src="./js/jquery-ui/jquery-ui.js"></script>
  <script src="./Darkmode/lib/darkmode-js.min.js"></script>
</head>

<body class="" style="max-width:1600px">

  <body class="w3-light-grey w3-content" style="max-width:1600px">

    <!-- Sidebar/menu -->
    <!-- <div class="darkmode-layer darkmode-layer--button" ></div> -->
    <!-- <button class="darkmode-toggle--white darkmode-toggle" aria-label="Activate dark mode" aria-checked="false" role="checkbox" hidden></button> -->
    <nav class="w3-sidebar w3-bar-block w3-white w3-animate-left w3-text-grey w3-collapse w3-top w3-center" style="z-index:3;width:300px;font-weight:bold" id="mySidebar">
      <!-- <nav class="w3-sidebar w3-bar-block w3-black w3-animate-left w3-text-white w3-collapse w3-top w3-center" style="z-index:3;width:300px;font-weight:bold" id="mySidebar" > -->
      <br>
      <h3 class="w3-padding-64 w3-center"><b>歡迎回到<br>您的書庫</b></h3>
      <a href="javascript:void(0)" onclick="w3_close()" class="w3-bar-item w3-button w3-padding w3-hide-large">CLOSE</a>

      <select id="dropdown" style="width: 100px" onchange="select(this)">


      </select>

      </br>
      <form action="" name="addType" method="post">
        <input type="text" name="addTypeT" style="width: 50px;">
        <input type="submit" value="新增" name="addT">
        <?php
        require('./backend/APIs/type/addtype.php');
        ?>
      </form>


      <a href="#" onclick="w3_close()" class="w3-bar-item w3-button">LIBRARY</a>
      <form action="" method="post">
        <input type="text" value="" name="userSystem" hidden>
      </form>
      <?php
      $userStm = "";

      if (isset($_POST['userSystem'])) {
        $userStm = $_POST['userSystem'];
        // echo $userStm;
      }
      $user = 'SELECT * FROM `bookstore_manber` WHERE  `ID` = :u_ID ';
      // $user = 'SELECT * FROM `bookstore_manber` WHERE  `ID` = :u_ID AND `UserSystem` = :user';
      // $user = 'SELECT * FROM `bookstore_manber` WHERE  `UserSystem` = :user';
      $stm = $link->prepare($user);
      $stm->bindValue(':u_ID', $ID);
      // $stm->bindValue(':user', $userStm);
      $stm->execute();
      $reasult = $stm->fetchAll(PDO::FETCH_ASSOC);
      // print_r($reasult[0]['UserSystem']);
      
      // // $stm->bindValue('u_id', $ID);

      if ($reasult[0]['UserSystem'] == 1) {
        
        echo '<a href="././user_system.php" onclick="w3_close()" class="w3-bar-item w3-button">管理者系統</a>';
      }
      if ($reasult[0]['UserSystem']== 0 || $reasult[0]['UserSystem']== "") {
      }



      // print_r($reasult[]);
      // exit;




      // echo '<a href="./user_system.php" onclick="w3_close()" class="w3-bar-item w3-button">管理者系統1</a>';







      ?>
      <a href="#about" onclick="w3_close()" class="w3-bar-item w3-button">關於我</a>

      <!-- <a href="#contact" onclick="w3_close()" class="w3-bar-item w3-button">分類</a> -->


      <a href="./logout.php" onclick="w3_close()" class="w3-bar-item w3-button">登出</a>

      <div class="w3-container w3-padding-32 w3-padding-large" id="contact">
        <div>
          <p>找尋您要找尋的書籍</p>
          <form action="/action_page.php" target="_blank">
            <div class="w3-section">
              <input class="w3-input w3-border" type="text" name="Name" required>
            </div>

            <button type="submit" class="w3-button w3-block w3-black w3-margin-bottom">查詢</button>
          </form>
        </div>
      </div>

    </nav>


    <!-- Top menu on small screens -->
    <header class="w3-container w3-top w3-hide-large w3-white w3-xlarge w3-padding-16">
      <span class="w3-left w3-padding">您的書庫</span>
      <a href="javascript:void(0)" class="w3-right w3-button w3-white" onclick="w3_open()">☰</a>
    </header>

    <!-- Overlay effect when opening sidebar on small screens -->
    <div class="w3-overlay w3-hide-large w3-animate-opacity" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

    <!-- !PAGE CONTENT! -->
    <div class="w3-main" style="margin-left:300px">


      <!-- BG Animate -->
      <div class="circles">
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
      </div>
      <!-- Push down content on small screens -->
      <div class="w3-hide-large" style="margin-top:83px"></div>

      <!-- 搜尋介面 -->
      <!-- <div class="w3-container w3-light-grey w3-padding-32 w3-padding-large" id="contact">
      <div class="w3-content" style="max-width:600px">
        <h4 class="w3-center"><b>搜尋</b></h4>
        <p>找尋您要找尋的書籍</p>
        <form action="/action_page.php" target="_blank">
          <div class="w3-section">
            <input class="w3-input w3-border" type="text" name="Name" required>
          </div>

          <button type="submit" class="w3-button w3-block w3-black w3-margin-bottom">查詢</button>
        </form>
      </div>
    </div> -->
      <!-- Photo grid -->

      <div class="w3-row" id="showPic">

        <?php
        $menuid = "";

        if (isset($_GET['menuid'])) {
          $menuid = $_GET['menuid'];
        }

        // $query = "select * from bookstore_manber where `id` = ;
        // $result = $link->query($query);

        // $query = 'SELECT * FROM images WHERE `UserID` = :sn limit :sp,6';
        if (isset($_POST['showPicH'])) {
          $showPicH = $_POST['showPicH'];
        }
        if ($menuid == "" || $menuid == 0) {
          $query = 'SELECT * FROM images where `UserID` = :sn limit :sp,6';
          $stmt = $link->prepare($query);
          $stmt->bindValue(':sp', $startNumber, PDO::PARAM_INT); //PDO::PARAM_INT = 數字格式
          $stmt->bindValue(':sn', $ID);
          $stmt->execute();
          $reasult = $stmt->fetchall(PDO::FETCH_ASSOC);
        } else {
          $query = 'SELECT * FROM images WHERE `UserID` = :sn and `idmenu` = :idm limit :sp,6';
          $stmt = $link->prepare($query);
          $stmt->bindValue(':sp', $startNumber, PDO::PARAM_INT); //PDO::PARAM_INT = 數字格式
          $stmt->bindValue(':sn', $ID);
          $stmt->bindValue(':idm', $menuid);
          // $stmt->bindValue(':sc', $showPicH);
          $stmt->execute();
          $reasult = $stmt->fetchall(PDO::FETCH_ASSOC);
        }

        // 取得多筆資料
        $pic = 0;
        foreach ($reasult as $row)            //  同 while ($row = $result->fetch())
        {
          $Imageb = $row["Image"];
          $Imagea = explode("/", $Imageb);
          if ($pic % 3 == 0) {
            echo  '<div class="w3-third">';
          }
          // echo '<img src="' . $row["Image"] . '" style="width:100% " onclick="onClick(this)" pid = "' . $row["PicNum"] . '" alt="' . $Imagea[1] . '">';
          echo '<div class="image">' . '<img src="' . $row["Image"] . '" style="width:100% " onclick="onClick(this)" pid = "' . $row["PicNum"] . '" alt="' . $Imagea[1] . '">' . '</div>';
          if ($pic % 3 == 0) {
            echo '</div>';
          }
        }





        ?>
      </div>
      <!-- Contact section -->
      <!-- Pagination -->
      <form action="" method="post">
        <div class="w3-center w3-padding-32">
          <div class="w3-bar">
            <input type="text" name="pg" value="" hidden>
            <?php
            if ($menuid == "" || $menuid == 0) {
              for ($i = 1; $i <= ceil($pgnumber); $i++) {
                echo '<a href="./main.php?page=' . $i . '"><div name="pg1" class="w3-bar-item w3-black w3-button" >' . $i . '</div></a>';
              }
            } else {
              for ($j = 1; $j <= ceil($pagetype_1); $j++) {
                echo '<a href="./main.php?menuid=' . $menuid . '&page=' . $j . '"><div name="pg1" class="w3-bar-item w3-black w3-button" >' . $j . '</div></a>';
              }
            }




            ?>


          </div>
        </div>
      </form>

      <!-- Modal for full size images on click-->
      <div id="modal01" class="w3-modal w3-black" style="padding-top:0">
        <!-- <div id="modal01" class="w3-modal w3-black" style="padding-top:0" onclick="this.style.display='none'"> -->
        <span id="closePic" class="w3-button w3-black w3-xlarge w3-display-topright" onClick='closePicture()'>×</span>
        <div class="w3-modal-content w3-animate-zoom w3-center w3-transparent w3-padding-64">
          <span>
            <img id="img01" class="w3-image">
            <p id="caption"></p>



            <form action="" method="post">
              <input type="text" name="DeleteP" hidden>
              <input type="text" name="editP" hidden>
              <input type="submit" value="刪除圖片" name="deleteOne">

            </form>
            <form action="./backend/APIs/menu/edit.php" method="POST">
              <input type="text" name="editTypeH" eid="" hidden>
              <input type="submit" value="編輯" name="editType">
            </form>
          </span>
          <div class="message">
            <form action="" name="enterMsg" method="post">
              <textarea id="messageT" name="messageT" onkeydown="myFunction(event)" placeholder="留言..."></textarea>
              <input type="text" name="messageH" hidden>
              <input type="submit" value="留言" name="message">
              <div id="messageTe">
                <?php
                require('./message.php');
                ?>
              </div>
            </form>
            <form action="" method="post">
              <input type="text" name="delmessH" hidden>
              <input type="submit" value="刪除全部留言" name="delmess">
              <div>
                <?php
                require('./delmessage.php');
                ?>
              </div>
          </div>

          </form>
        </div>
      </div>

      <!-- About section -->
      <div class="w3-container w3-dark-grey w3-center w3-text-light-grey w3-padding-32" id="about">
        <h4><b>關於我</b></h4>
        <img src="./img/123.jpg" alt="ME" class="w3-image w3-padding-32" width="200" height="250">
        <div class="w3-content w3-justify" style="max-width:600px">
          <!-- 放置關於自己的資料 -->
          <h4>
            <?php
            // $query = "select * from bookstore_manber where `id` = ;
            // $result = $link->query($query);
            $query = 'SELECT * FROM bookstore_manber WHERE `ID` = :sn';
            $stmt = $link->prepare($query);
            $stmt->bindValue(':sn', $ID);
            $stmt->execute();


            // 取得多筆資料
            $reasult = $stmt->fetchall(PDO::FETCH_ASSOC);
            // print_r($reasult);
            // exit;
            foreach ($reasult as $row)            //  同 while ($row = $result->fetch())
            {
              $charLength = 18;
              $content = mb_strlen($row["CONTENT"], 'UTF-8') <= $charLength ? $row["CONTENT"] : mb_substr($row["CONTENT"], 0, $charLength, 'UTF-8') . '<a href="./useredit.php">...查看更多</a>';
              echo $row["NAME"];
              echo "<p>";
              echo  $content;
              echo "</p>";
            }

            ?>
            <form action="update.php" method="POST">


              <input type="submit" value="編輯" name="edit">
            </form>
          </h4>
          <!-- 放置數據的資料 用資料量進行百分比配置 -->
          <div hidden>
            <hr class="w3-opacity">
            <h4 class="w3-padding-16">您的數據</h4>
            <p class="w3-wide">公仔</p>
            <div class="w3-white">
              <div class="w3-container w3-padding-small w3-center w3-grey" style="width:95%">95%</div>
            </div>
            <p class="w3-wide">設計</p>
            <div class="w3-white">
              <div class="w3-container w3-padding-small w3-center w3-grey" style="width:85%">85%</div>
            </div>
            <p class="w3-wide">程式</p>
            <div class="w3-white">
              <div class="w3-container w3-padding-small w3-center w3-grey" style="width:80%">80%</div>
            </div>
          </div>

          <!-- 上傳檔案 -->
          <!-- <p> <button class="w3-button w3-light-grey w3-padding-large w3-margin-top w3-margin-bottom">上傳檔案</button></p> -->
          <p>
          <form action="" method="post" enctype="multipart/form-data">
            <input type="file" name="image">
            <input type="submit" value="upload" name="upload" class="w3-button w3-light-grey w3-padding-large w3-margin-top w3-margin-bottom">
            <br />
            <input type="submit" name="deleteAll" value="一鍵刪除">
          </form>
          </p>

          <p>

          </p>
        </div>
      </div>






      <!-- Footer -->
      <footer class="w3-container w3-padding-32 w3-grey">
        <div class="w3-row-padding">
          <div class="w3-third">
            <h3>INFO</h3>
            <p>Praesent tincidunt sed tellus ut rutrum. Sed vitae justo condimentum, porta lectus vitae, ultricies congue gravida diam non fringilla.</p>
          </div>

          <div class="w3-third">
            <h3>BLOG POSTS</h3>
            <ul class="w3-ul">
              <li class="w3-padding-16 w3-hover-black">
                <img src="/w3images/workshop.jpg" class="w3-left w3-margin-right" style="width:50px">
                <span class="w3-large">Lorem</span><br>
                <span>Sed mattis nunc</span>
              </li>
              <li class="w3-padding-16 w3-hover-black">
                <img src="/w3images/gondol.jpg" class="w3-left w3-margin-right" style="width:50px">
                <span class="w3-large">Ipsum</span><br>
                <span>Praes tinci sed</span>
              </li>
            </ul>
          </div>

          <div class="w3-third">
            <h3>CALENDAR</h3>
            <p>
              <input type="text" id="datepicker">
            </p>
          </div>
        </div>
      </footer>




      <!-- End page content -->
    </div>
    </div>
    <script>
      //深色模式
      new Darkmode().showWidget();




      // Enter 輸入留言
      function myFunction(event) {
        var x = event.keyCode;
        if (x == 13) { //13是enter鍵
          document.enterMsg.submit();
        }
      }


      // Script to open and close sidebar
      function w3_open() {
        document.getElementById("mySidebar").style.display = "block";
        document.getElementById("myOverlay").style.display = "block";
      }

      function w3_close() {
        document.getElementById("mySidebar").style.display = "none";
        document.getElementById("myOverlay").style.display = "none";
      }

      //頁碼顏色切換







      // Modal Image Gallery
      function onClick(element) {
        document.getElementById("img01").src = element.src;
        document.getElementById("modal01").style.display = "block";
        var captionText = document.getElementById("caption");
        captionText.innerHTML = element.alt;
        // console.log(element);
        var inputDel = document.getElementsByName("DeleteP");
        inputDel[0].value = element.getAttribute('pid');
        var inputH = document.getElementsByName('messageH');
        inputH[0].value = element.getAttribute('pid');
        var inputH = document.getElementsByName('delmessH');
        inputH[0].value = element.getAttribute('pid');
        var inputH = document.getElementsByName('editTypeH');
        inputH[0].value = element.getAttribute('pid');


        // 修改留言區內容
        var datas = {
          // "userid": ID
          "PicNum": inputDel[0].value,
        };
        $.ajax({
          type: "POST",
          url: "./backend/APIs/message/messageShow.php",
          dataType: "json", //用字串顯示
          data: datas,
          success: function(response) {
            // console.log(response);
            // var messageTe = document.getElementById('messageTe');
            // messageTe.innerHTML
            var bb = "";


            for (var i = 0; i < response.length; i++) {

              bb = bb + (response[i].CONTENT) + "///" + (response[i].DATE) + " " + "<button type='button' mid='" + (response[i].ID) + "' onclick = 'delOneMsg(this)'>" + "-刪除" + "</button>" + "<br/>";
            }
            messageTe.innerHTML = bb
          },
          error: function(thrownError) {
            console.log(thrownError);
          }
        });
      }

      function closePicture() {
        var closePictureArea = document.getElementById("modal01");
        closePictureArea.style.display = 'none';
      }

      //刪除單個留言



      function delOneMsg(emt) {
        var closePicMsg = document.getElementById("modal01");
        closePicMsg.style.display = 'none';
        // var inputMsgD = document.getElementsByName('delOneMsg');
        // inputMsgD[0].value =getAttribute('mid');

        // console.log(emt.getAttribute('mid'));
        var delOMsg = {
          "delOneMsg": emt.getAttribute('mid')
        }
        $.ajax({
          type: 'POST',
          url: './backend/APIs/message/delOneMsg.php',
          data: delOMsg,
          dataType: 'JSON',
          success: function(response) {

          }
        })
      }



      //日期
      $(function() {
        $("#datepicker").datepicker();
      });
    </script>


  </body>

</html>