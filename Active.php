<?php 
require_once 'Init.php';
require_once 'Function.php';
require_once 'navbar.php';

if($_SERVER['REQUEST_METHOD'] == 'GET')
{
	$email = $_SESSION['email'];
	
	if($email == "")
	{
		header("Location:Login.php");
	}

	$code =$_GET['code'];
	$rs = -2;
	$rs=Active($email,$code);

	if($rs == 1)
	{
		$_SESSION['status'] = 1;
		header("Location:index.php");
	}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Login Page</title>
	<link rel="stylesheet" href="./style/login.css">
	<link class="pgcss" rel="stylesheet" href="./pageloading.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="./js.js"></script>
</head>
<body>
	<div class="container">
		<div class="login-form">
		<form action="" method="GET" role="form">
		<h3>Active account</h3>
			<div class="form-group">
				<label for="">Activation Code</label>
				<input type="text" class="form-control" name ="code" id="code" placeholder="Code">
			</div>
			
		<button type="submit" class="btn btn-primary">Submit</button>
		<?php if($rs == -1):?>
		<div class="alert alert-danger" role="alert">
		  Code không đúng vui lòng kiểm tra tin nhắn ở email.
		</div>
		<?php endif;?>
	</div>
	
</body>
</html>