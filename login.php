<?php
include("configure.php");
$link = new PDO('mysql:host=' . $hostname . ';dbname=' . $database . ';charset=utf8', $username, $password);
?>


<!DOCTYPE html>
<html lang="zh-TW">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="./js/lib/jquery.js"></script>
    <title>書庫</title>
    <style>
        div {
            margin: 20px;
        }

        .main {
            width: 100%;
            height: 100%;
            text-align: center;

        }

        .top {
            margin-left: 60px;
            text-align: center;
        }

        img {
            width: 100px;
        }



        .account {
            font-size: 36px;
        }

        .password {
            font-size: 36px;
        }

        a {
            color: black;
            text-decoration: none;
        }

        .lineBtn {
            margin-left: 47%;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <div class="top">
        <img src="img/<?php echo rand(1, 10); ?>.png">


    </div>
    <div class="main">
        <input type="text" placeholder="請輸入關鍵字">
        <input type="submit" value="搜尋">
        <div>
            <form action="" method="POST">
                <div class="account">帳號:</div>
                <input type="text" name="account" placeholder="請輸入帳號">
                <div class="password">密碼:</div>
                <input type="password" name="password">
                <br />
                <input type="submit" name="submit" value="登入">
            </form>

            <a href="./signup.php"><input type="submit" value="註冊"></a>

        </div>
    </div>
    <span class="lineBtn" id="lineLoginBtn">
        <img src="./img/btn_login_base.png" style="width: 8%">
    </span>
    <?php
    $at = "";
    $pd = "";
    if (isset($_POST["account"])) {
        $at = $_POST["account"];
    }
    if (isset($_POST["password"])) {
        $pd = md5($_POST["password"]);
    }

    //如果帳號密碼 = 資料庫資料 則登入 否則 查無此資料
    if ($at != "" && $pd != "") {
        $sql = 'SELECT * FROM bookstore_manber WHERE `account` = :sn and `password` =  :sn1';
        $stmt = $link->prepare($sql);
        $stmt->bindValue(':sn', $at);
        $stmt->bindValue(':sn1', $pd);
        $stmt->execute();

        // 取得多筆資料
        $reasult = $stmt->fetchall(PDO::FETCH_ASSOC);
        // print_r($reasult) ;
        // exit;
        if (count($reasult)) {
            // echo $reasult[0];
            // print_r($reasult);
            // echo $reasult[0]["ID"]; //陣列的資料
            session_start();
            $_SESSION['ID'] = $reasult[0]["ID"];

            header("Location: ./main.php");
        }
    } else {
        // echo "<script>alert('此欄位不能為空白')</script>";
    }

    ?>

    <!--line login 登入 -->
    <script>
        $('#lineLoginBtn').on('click', function(e) {
            let client_id = '1661141696';
            let redirect_uri = 'https://162b-2401-e180-8861-65c7-a06a-961-cf14-6382.ngrok-free.app/bookstore/backend/APIs/line/login.php';
            let link = 'https://access.line.me/oauth2/v2.1/authorize?';
            link += 'response_type=code';
            link += '&client_id=' + client_id;
            link += '&redirect_uri=' + redirect_uri;
            link += '&state=login';
            link += '&scope=openid%20profile';
            window.location.href = link;
        });
    </script>

</body>

</html>