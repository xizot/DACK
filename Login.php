<?php 
require_once 'Header.php';
require_once 'Function.php';

if($_SERVER['REQUEST_METHOD'] == 'POST')
{
	$email = $_POST['email'];
	$password = $_POST['password'];
	$check = Login($email,$password);
	if($check == 1)
	{	
		$_SESSION['email'] =$email;
		$_SESSION['status'] = 1;
		header("Location:index.php");
	}
	else if($check == 2)
	{	
		$_SESSION['email'] =$email;
		header("Location:active.php");
	}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Login Page</title>
	<link rel="stylesheet" href="./css.css">
</head>
<body>
	<div class="container">
		<div class="form">
		<form action="" method="POST" role="form">
		<h3>Log in to BTGK</h3>
			<div class="form-group">
				<label for="">Email</label>
				<input type="email" class="form-control" name ="email" id="" placeholder="Email address">
			</div>
			<div class="form-group">
				<label for="">Password</label>
				<input type="password" class="form-control" name ="password" id="" placeholder="Password">
			</div>	
		<button type="submit" class="btn btn-primary">Log In</button>

	<!-- /*Forgotten Password*/ -->
		<div class="forget">
				<a href="ForgetPassword.php">Forgotten password?</a>
		</div>
	<!-- End forgotten password -->

		<?php if(($_SERVER['REQUEST_METHOD'] == 'POST') && $check == 0): ?>
			<div class="alert alert-danger" role="alert">
			  Vui lòng điền đầy đủ email và password..
			</div>
		<?php elseif(($_SERVER['REQUEST_METHOD'] == 'POST') && $check == -1): ?>
			<div class="alert alert-danger" role="alert">
			  Đăng nhập thất bại. Vui lòng kiểm tra lại email và password...
			</div>
		<?php endif; ?>
		</div>
	</form>
	</div>
	
</body>
</html>