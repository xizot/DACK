<?php
require_once 'Init.php';
require_once 'Function.php';
require_once 'navbar.php';
if ($_SESSION['email']) {
	header("Location:index.php");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$email = $_POST['email'];
	$password = $_POST['password'];
	$check = Login($email, $password);
	if ($check == 1) {
		$_SESSION['email'] = $email;
		$_SESSION['status'] = 1;

		$Id = $_GET['id'];
		!empty($Id) ? header("Location:profile.php?id=" . $Id) : header("Location:index.php");
	} else if ($check == 2) {
		$_SESSION['email'] = $email;
		header("Location:Active.php");
	}
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title>LOGIN</title>
	<link rel="stylesheet" href="./style/login.css">
	<link class="pgcss" rel="stylesheet" href="./pageloading.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="./js.js"></script>
	<link class="pgcss" rel="stylesheet" href="./pageloading.css">
	<script src="./loading.js"></script>
</head>

<body>
	<video src=""></video>
	<div class="container">
		<div class="login-form">
			<form action="" method="POST" role="form">
				<h3>Log in to Sky Network</h3>
				<div class="form-group">
					<label for="">Email</label>
					<input type="email" class="form-control" name="email" id="" placeholder="Email address">
				</div>
				<div class="form-group">
					<label for="">Password</label>
					<input type="password" class="form-control" name="password" id="" placeholder="Password">
				</div>
				<button type="submit" class="btn btn-primary">Log In</button>

				<!-- /*Forgotten Password*/ -->
				<div class="forget">
					<a href="./ForgetPassword.php">Forgotten password?</a>
					<p>New to Sky Network?<a href="./Register.php"> SIGN UP</a></p>
				</div>
				<!-- End forgotten password -->

				<?php if (($_SERVER['REQUEST_METHOD'] == 'POST') && $check == 0) : ?>
					<div class="alert alert-danger" role="alert">
						Vui lòng điền đầy đủ email và password..
					</div>
				<?php elseif (($_SERVER['REQUEST_METHOD'] == 'POST') && $check == -1) : ?>
					<div class="alert alert-danger" role="alert">
						Đăng nhập thất bại. Vui lòng kiểm tra lại email và password...
					</div>
				<?php elseif (($_SERVER['REQUEST_METHOD'] == 'POST') && $check == -3) : ?>
					<div class="alert alert-danger" role="alert">
						Tài khoản không tồn tại...
					</div>
				<?php endif; ?>
		</div>
		</form>
	</div>
	<footer style="position:relative;padding:50px;margin-top:100px;background-image: radial-gradient( circle farthest-corner at 10% 20%, rgba(0,93,133,1) 0%, rgba(0,181,149,1) 90% );">

		<?php require_once 'footer.php' ?>
	</footer>

	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>


</body>

</html>