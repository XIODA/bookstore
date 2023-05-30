<?php
include("configure.php");
$link = new PDO('mysql:host=' . $hostname . ';dbname=' . $database . ';charset=utf8', $username, $password);
?>

<!doctype html>
<html lang="en">

<head>
	<link rel="Website Icon" type="png" href="./img/5.png">
	<title>Sign up</title>
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
					<h2 class="heading-section">註冊</h2>
				</div>
			</div>
			<div class="row justify-content-center">
				<div class="col-md-6 col-lg-4">
					<div class="login-wrap p-0">

						<form action="" method="POST">
							<form action="#" class="signin-form">
								<div class="form-group">
									<?php echo '<a href="./login.php">' . '←' . '</a>' ?>
								</div>
								<div class="form-group">
									<input type="text" name="account" class="form-control" placeholder="Account" required>
								</div>
								<div class="form-group">
									<input id="password-field" type="password" name="password" class="form-control" placeholder="Password" required>
									<span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
								</div>
								<div class="form-group">
									<input type="text" name="name" class="form-control" placeholder="Username" required>
								</div>
								<div class="form-group">
									<button type="submit" class="form-control btn btn-primary submit px-3" value="Sign up">Sign up</button>
								</div>
							</form>
						</form>

						</form>

					</div>
				</div>
			</div>
		</div>
		</div>
	</section>

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
			header("Location: ./login.php");
		} else {
			echo "<script>alert('此帳號已被註冊過')</script>";
		}

		// 取得單筆資料
		// $stmt->fetch(PDO::FETCH_ASSOC);


	} else if ($at == null || $pd == null || $name == null) {
		// echo "<script>alert('請輸入完整資料內容')</script>";
	}

	?>

	<script src="js/jquery.min.js"></script>
	<script src="js/popper.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/main.js"></script>







</body>

</html>