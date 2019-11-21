<?php 
require_once 'Header.php';
require_once 'Function.php';

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
			header("Location:active.php");
		}
	}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Register Page</title>
	<link rel="stylesheet" href="./css.css">
</head>
<body>
	<div class="container">
		<div class="form">
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
	
</body>
</html>

