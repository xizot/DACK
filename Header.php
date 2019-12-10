<?php 
require_once 'Init.php';
	error_reporting(E_ALL & ~E_NOTICE);

require_once('Function.php');
$id = $_GET['id'];
$avt = "avt.php?id=" . $_SESSION['id'] . "&for=avt";

if (!empty($id)) {
	$data = GetProfileByID($id);
	$name = $data[0]['fullname'];
}

if (isset($_POST['find'])) {
	$str = "Location:search.php?q=" . $_POST['find'];
	header($str);
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title>Trang chủ</title>
	<link rel="stylesheet" href="css.css">
	<link rel="stylesheet" href="new.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css">
</head>

<body>

	<div class="navbar">
		<a href="./?id=<?php echo $_SESSION['id'] ?>" class="logo">
		
		</a>
		<div class="search-box">
			<form action="" method="POST">
				<input type="text" value="<?php echo $_GET['q'] != "" ? $_GET['q'] : $_SESSION['fullname'] ?>" name="find">
				<button class="search-submit" type="submit"><i class="fas fa-search"></i></button>
			</form>
		</div>

		<?php if ($_SESSION['email'] != "" && $_SESSION['id'] != "") : ?>
			<div class="profile-img">
				<a href="./profile.php?id=<?php echo $_SESSION['id'] ?>"><img src="<?php echo $avt ?>" alt=""> </a>
			</div>
			<div class="link">
				<a href="./profile.php?id=<?php echo $_SESSION['id'] ?>"><?php echo $_SESSION['fullname']  ?></a>
				<a href="./?id=<?php echo $_SESSION['id'] ?>">Home</a>
				<a href="./ChangePassword.php">Đổi mật khẩu</a>
				<a href="./search.php">Tìm Bạn</a>
				<a href="./RequestFriends.php">Lời mời kết bạn (<?php echo countRequestFriends($_SESSION['id']) ?>)</a>

			</div>
		<?php endif; ?>

		<?php if ($_SESSION['fullname'] == "" &&  $_SESSION['email'] == "" ) : ?>
			<div class="box-login">
				<div class="signup">
					<a href="Register.php"><i class="fas fa-user-plus"> SignUp
						</i></a>
				</div>
				<div class="login">
					<a href="Login.php"><i class="fas fa-sign-in-alt"> LogIn</i></a>
				</div>
			</div>
		<?php elseif ($_SESSION['fullname'] != "" ||  $_SESSION['email'] != "" ) : ?>
			<div class="box-login">
				<div class="login">
					<a href="Logout.php"><i class="fas fa-sign-in-alt"> LogOut</i></a>
				</div>
			<?php endif; ?>

			<div class="clearfix"></div>
			</div>

</body>

</html>

