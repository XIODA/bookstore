<?php
include("configure.php");
$link = new PDO('mysql:host=' . $hostname . ';dbname=' . $database . ';charset=utf8', $username, $password);
?>

<!doctype html>
<html lang="en">

<head>
	<title>Login </title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

	<link rel="stylesheet" href="css/style.css">

</head>

<body class="img js-fullheight" style="background-image: url(images/bg.jpg);">
	<section class="ftco-section">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-6 text-center mb-5">
					<!-- <h2 class="heading-section">Login #10</h2> -->
				</div>
			</div>
			<div class="row justify-content-center">
				<div class="col-md-6 col-lg-4">
					<div class="login-wrap p-0">
						<h3 class="mb-4 text-center">歡迎回到您的書庫</h3>
						<form action="" method="POST">
							<form action="#" class="signin-form">
								<div class="form-group">
									<input type="text" name="account" class="form-control" placeholder="Username" required>
								</div>
								<div class="form-group">
									<input id="password-field" type="password" name="password" class="form-control" placeholder="Password" required>
									<span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
								</div>
								<div class="form-group">
									<button type="submit" class="form-control btn btn-primary submit px-3">Sign In</button>
								</div>
							</form>
						</form>
						<div class="form-group d-md-flex">
							<div class="w-50">
								<label class="checkbox-wrap checkbox-primary">Remember Me
									<input type="checkbox" checked>
									<span class="checkmark"></span>
								</label>
							</div>
							<div class="w-50 text-md-right">
								<a href="./signup.php" style="color: #fff">註冊</a>
							</div>
						</div>
						</form>
						<p class="w-100 text-center">&mdash; Or Sign In With &mdash;</p>
						<div class="social d-flex text-center">
							<a href="" class="px-2 py-2 mr-md-1 rounded"><span class="ion-logo-facebook mr-2"></span> Facebook</a>
							<a href="javascript:js_method();" id="lineLoginBtn" class="px-2 py-2 ml-md-1 rounded" ><span class="ion-logo-twitter mr-2" >Line</span> </a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<script src="js/jquery.min.js"></script>
	<script src="js/popper.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/main.js"></script>

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
			let client_id = '';
			let redirect_uri = '/bookstore/backend/APIs/line/login.php';
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