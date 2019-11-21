<?php 
require_once 'Header.php';
require_once 'Function.php';
if($_SESSION['email'] =="")
{
	header("Location:login.php");
}


if(($_SERVER['REQUEST_METHOD'] == 'POST'))
{

	$OlderPass = $_POST['olderpass'];
	$NewPass = $_POST['newpass'];
	$check = ChangePassword($_SESSION['email'],$OlderPass,$NewPass);
	echo $check;
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
		<h3>Change password for <?php echo $_SESSION['fullname']?$_SESSION['fullname']:$_SESSION['email'] ?></h3>
			<div class="form-group">
				<label for="">Older Password</label>
				<input type="text" class="form-control" name ="olderpass" id="" placeholder="Older Password">
			</div>
			<div class="form-group">
				<label for="">New Password</label>
				<input type="password" class="form-control" name ="newpass" id="" placeholder="New Password">
			</div>	
		<button type="submit" class="btn btn-primary">Change password</button>



		<?php if(($_SERVER['REQUEST_METHOD'] == 'POST') && $check == 0): ?>
			<div class="alert alert-danger" role="alert">
			  Vui lòng điền đầy đủ password..
			</div>
		<?php elseif(($_SERVER['REQUEST_METHOD'] == 'POST') && $check == -1): ?>
			<div class="alert alert-danger" role="alert">
			Bạn đang nhập mật khẩu cũ, Vui lòng nhập mật khẩu mới.
			</div>
		<?php elseif(($_SERVER['REQUEST_METHOD'] == 'POST') && $check == -2): ?>
			<div class="alert alert-danger" role="alert">
			Sai mật khẩu. Vui lòng kiểm tra lại.
			</div>
		<?php endif; ?>
		</div>
	</form>
	</div>
	
</body>
</html>