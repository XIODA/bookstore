<?php
include("../../../configure.php");
$link = new PDO('mysql:host=' . $hostname . ';dbname=' . $database . ';charset=utf8', $username, $password);



$get_code = $_GET['code'];
$global_line_call_back_url_arr = "https://162b-2401-e180-8861-65c7-a06a-961-cf14-6382.ngrok-free.app/bookstore/backend/APIs/line/login.php";
$client_id = "";
$client_secret = "";
// 執行登入  取得登入資訊
$data = array(
    "grant_type" => "authorization_code",
    "code" => $get_code,
    "redirect_uri" => $global_line_call_back_url_arr,
    "client_id" => $client_id,
    "client_secret" => $client_secret
);

$data_string = http_build_query($data);

$ch = curl_init('https://api.line.me/oauth2/v2.1/token');
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt(
    $ch,
    CURLOPT_HTTPHEADER,
    array(
        'Content-Type: application/x-www-form-urlencoded'
    )
);

$result = curl_exec($ch);
// echo $result;
$return_arr = array();
$return_arr = json_decode($result, true);

// print_r($return_arr);
// exit;




// 解析 id_token
$data = array(
    "id_token" => $return_arr['id_token'],
    "client_id" => $client_id
);


$data_string = http_build_query($data);

//echo $data_string;
$ch = curl_init('https://api.line.me/oauth2/v2.1/verify');
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt(
    $ch,
    CURLOPT_HTTPHEADER,
    array(
        'Content-Type: application/x-www-form-urlencoded'
    )
);

$result2 = curl_exec($ch);
//echo $result;
$return_arr2 = array();
$return_arr2 = json_decode($result2, true);
// print_r($result2);
// exit;

// 取得姓名
$user_name = $return_arr2['name'];
// echo $user_name;

// 取得line編號
$user_onlyID = $return_arr2['sub'];
// echo $user_onlyID;
// echo "<br/>";

//取得照片
$user_pic = $return_arr2['picture'];

//取得aud
$user_aud = $return_arr2['aud'];
// echo $user_aud;

//取得令牌到期時間
$user_exp = $return_arr2['exp'];

//取得生成ID令牌的時間
$user_iat = $return_arr2['iat'];


//明天處理
//輸入資料庫


// if (isset($_SESSION['ID'])) {
$sql = 'select * from bookstore_manber where (`l_sub`= :sn)';
$stmt = $link->prepare($sql);
$stmt->bindValue(':sn', $user_onlyID); //bindValue => 取代 ("被取代","取代");
$stmt->execute();
$reasult = $stmt->fetchAll(PDO::FETCH_ASSOC);
session_start();
$_SESSION['ID'] = $reasult[0]["ID"];

header("Location: ../../../main.php");
if (count($reasult) == 0) {

    $account_db = "INSERT INTO `bookstore`.`bookstore_manber` (`l_username`,`l_userPic`,`l_sub`) VALUES (?,?,?)";
    $data = [$user_name, $user_pic, $user_onlyID];
    $sth = $link->prepare($account_db);
    $sth->execute($data);
    exec($account_db);
}
