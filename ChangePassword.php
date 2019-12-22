<?php 
require_once 'Init.php';
require_once 'navbar.php';
require_once 'Function.php';

if (empty($_SESSION['id'])) {
	header("Location:Login.php");
}


if(($_SERVER['REQUEST_METHOD'] == 'POST'))
{

	$OlderPass = $_POST['olderpass'];
	$NewPass = $_POST['newpass'];
	$check = ChangePassword($_SESSION['email'],$OlderPass,$NewPass);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>CHANGE PASSWORD</title>
	<link rel="stylesheet" href="./style/login.css">
	<link class="pgcss" rel="stylesheet" href="./pageloading.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="./js.js"></script>
	<link class="pgcss" rel="stylesheet" href="./pageloading.css">
	<script src="./loading.js"></script>
</head>
<body>
	<div class="container">
		<div class="login-form">
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
        <?php elseif(($_SERVER['REQUEST_METHOD'] == 'POST') && $check == 1): ?>
			<div class="alert alert-success" role="alert">
			Đổi mật khẩu thành công.
			</div>
		<?php endif; ?>
		</div>
	</form>
	</div>
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>

</body>
</html>