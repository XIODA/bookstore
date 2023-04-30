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
    <title>書庫</title>
</head>

<body>
    <form action="#" method="post">
        <div>請輸入帳號:</div>
        <input type="text" name="account" placeholder="請輸入帳號" minlength="8">
        <div>請輸入密碼:</div>
        <input type="password" name="password" minlength="8">
        <div>請輸入姓名:</div>
        <input type="text" name="name">

        <br />
        <input type="submit" value="註冊">
    </form>
    <?php
    $at = "";
    $pd = "";
    $name = "";

    if (isset($_POST["account"])) {
        $at = $_POST["account"];
    }
    if (isset($_POST["password"])) {
        $pd = md5($_POST["password"]);
    }
    if (isset($_POST["name"])) {
        $name = $_POST["name"];
    }
    //註冊
    // $password_db = "INSERT INTO `bookstore`.`bookstore_manber` (`PASSWORD`) VALUES ('$pd')";
    // echo $account_db;

    if ($at != "" && $pd != "" && $name != "") {
        // $sql = 'SELECT * FROM user WHERE sn = :sn';
        // $stmt->bindValue(':sn', '1');
        $sql = 'select * from bookstore_manber where (`account`= :sn)';
        $stmt = $link->prepare($sql);
        $stmt->bindValue(':sn', $at); //bindValue => 取代 ("被取代","取代");
        $stmt->execute();

        // $sql = 'select * from bookstore_manber';
        // $stmt = $link->prepare($sql);
        // $stmt->execute();
        // 取得多筆資料
        $reasult = $stmt->fetchAll(PDO::FETCH_ASSOC);
        // print_r($reasult) ;
        if (count($reasult) == 0) {
            $select = "select * from `bookstore_number`";
            $account_db = "INSERT INTO `bookstore`.`bookstore_manber` (`ACCOUNT`,`PASSWORD`,`NAME`) VALUES (?,?,?)";
            $data = [$at, $pd, $name];
            $sth = $link->prepare($account_db);
            $sth->execute($data);
            exec($account_db);
            echo "<script>alert('註冊成功')</script>";
        } else {
            echo "<script>alert('此帳號已被註冊過')</script>";
        }

        // 取得單筆資料
        // $stmt->fetch(PDO::FETCH_ASSOC);


    } else if ($at == null || $pd == null || $name == null) {
        echo "<script>alert('請輸入完整資料內容')</script>";
    }

    ?>
</body>

</html>