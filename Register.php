<?php 
require_once 'Init.php';
require_once 'navbar.php';
require_once 'Function.php';
if($_SESSION['email'])
{
	header("Location:index.php");
}
if($_SERVER['REQUEST_METHOD'] == 'POST')
{
	$email = $_POST['email'];
	$password = $_POST['password'];

	if(empty($password))
	{
		 $check = 0;
	}
	else
	{
		$hash = password_hash($password, PASSWORD_DEFAULT);
		$check = Register($email,$hash);
		if($check == 1)
		{
			$_SESSION['email'] = $email;
			header("Location:Active.php");
		}
	}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Register Page</title>
	<link rel="stylesheet" href="./style/login.css">
	<link class="pgcss" rel="stylesheet" href="./pageloading.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="./js.js"></script>
</head>
<body>
	<div class="container">
		<div class="login-form">
		<form action="" method="POST" role="form">
		<h3>Create a new user</h3>
			<div class="form-group">
				<label for="">Email</label>
				<input type="email" class="form-control" name ="email" id="" placeholder="John@yahoo.com.vn">
			</div>
			<div class="form-group">
				<label for="">Password</label>
				<input type="password" class="form-control" name ="password" id="" placeholder="Password">
			</div>	
		<button type="submit" class="btn btn-primary">Sign Up</button>
	</form>
		<?php if(($_SERVER['REQUEST_METHOD'] == 'POST') && $check == 0): ?>
		<div class="alert alert-danger" role="alert">
		  Vui lòng điền đầy đủ email và password..
		</div>
		<?php elseif(($_SERVER['REQUEST_METHOD'] == 'POST') && $check == -1): ?>
		<div class="alert alert-danger" role="alert">
		  Email đã tồn tại ...<a href="Login.php">Login</a>
		</div>
	<?php endif; ?>
		</div>
	</div>
	
	<footer style="position:relative;padding:50px;margin-top:100px;background-image: radial-gradient( circle farthest-corner at 10% 20%, rgba(0,93,133,1) 0%, rgba(0,181,149,1) 90% );">

				<?php require_once 'footer.php' ?>
		</footer>
</body>
</html>

