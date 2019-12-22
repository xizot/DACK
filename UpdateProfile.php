<?php
error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE);
error_reporting(E_ERROR | E_PARSE);
require_once 'Init.php';
require_once 'navbar.php';
require_once 'Function.php';

if (empty($_SESSION['id'])) {
	header("Location:Login.php");
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$avt = $_FILES['image'];
	$avtName = $avt['name'];

	$walpic = $_FILES['walpic'];
	$walpicName = $walpic['name'];

	$fullname = $_POST['Fullname'];
	$telNum = $_POST['PhoneNumber'];
	$DOB = $_POST['DOB'];
	global $db;
	$check = 1;

	if($avt['size']> 5000)
	{
		$check = -1;
	}
	if($walpic['size']> 5000)
	{
		$check = -2;
	}

	if (!empty($avtName) && $avt['size']<5000) {

		$avtTmp = $avt['tmp_name'];
		$newAvt = resizeImage($avtTmp, 937, 937);
		ob_start();
		imagejpeg($newAvt);
		$avatar = ob_get_contents();
		ob_end_clean();


		$sql = "UPDATE users SET avt =?  WHERE id=?";
		$stmt = $db->prepare($sql);
		$stmt->execute([$avatar, $_SESSION['id']]);
	}
	if (!empty($fullname)) {

		$sql = "UPDATE users SET fullname = ?  WHERE id=?";
		$stmt = $db->prepare($sql);
		$stmt->execute([$fullname, $_SESSION['id']]);
		$_SESSION['fullname'] = $fullname;
	}
	if (!empty($telNum)) {

		$sql = "UPDATE users SET tel = ?  WHERE id=?";
		$stmt = $db->prepare($sql);
		$stmt->execute([$telNum, $_SESSION['id']]);
	}
	if (!empty($DOB)) {

		$sql = "UPDATE users SET DOB = ?  WHERE id=?";
		$stmt = $db->prepare($sql);
		$stmt->execute([$DOB, $_SESSION['id']]);
	}

	if (!empty($walpicName) && $walpic['size'] <5000) {
		$walpicTmp = $walpic['tmp_name'];
		$newWalpic = resizeImage($walpicTmp, 937, 937);
		ob_start();
		imagejpeg($newWalpic);
		$Wal = ob_get_contents();
		ob_end_clean();


		$sql = "UPDATE users SET walpic =?  WHERE id=?";
		$stmt = $db->prepare($sql);
		$stmt->execute([$Wal, $_SESSION['id']]);
	}
	



	if($check == 1)
	{
		header("Location:profile.php?id=" . $_SESSION['id']);
	}
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title>UPDATE PROFILE</title>

	<link rel="stylesheet" href="./style/login.css">
	<link class="pgcss" rel="stylesheet" href="./pageloading.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="./js.js"></script>
</head>

<body>
	<div class="login-form">
		<form action="" method="POST" role="form" enctype="multipart/form-data">
			<center>
				<h3>Update Profile</h3>
			</center>

			<div class="form-group">
				<label for="">Fullname</label>
				<input type="text" class="form-control" maxlength="30" name="Fullname" id="" placeholder="<?php echo $_SESSION['fullname'] ?>">
			</div>
			<div class="form-group">
				<label for="">Phone Number</label>
				<input type="number" class="form-control" maxlength="11" name="PhoneNumber" id="" placeholder="03xxxxxxxxx">
			</div>
			<div class="form-group">
				<label for="">Date of Birth</label>
				<input type="date" class="form-control" name="DOB" id="">
			</div>
			<div class="form-group">
				<div class="input-group">
					<div class="input-group-prepend">
						<span class="input-group-text" id="inputGroupFileAddon01"><i class="fas fa-camera-retro"></i></span>
					</div>
					<div class="custom-file">
						<input type="file" class="custom-file-input" id="inputGroupFile01" name="image" aria-describedby="inputGroupFileAddon01" name="image">
						<label class="custom-file-label" for="inputGroupFile01">Avatar</label>
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="input-group">
					<div class="input-group-prepend">
						<span class="input-group-text" id="inputGroupFileAddon01"><i class="fas fa-camera-retro"></i></span>
					</div>
					<div class="custom-file">
						<input type="file" class="custom-file-input" id="inputGroupFile01" name="walpic" aria-describedby="inputGroupFileAddon01" name="image">
						<label class="custom-file-label" for="inputGroupFile01">Wallpaper</label>
					</div>
				</div>
			</div>
			<button type="submit" class="btn btn-primary">Update</button>
		</form>


		<?php if($check == -1): ?>
			
			<div class="alert alert-warning">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				<strong>Kích thước tối đa của ảnh đại diện là 5MB</strong>
			</div>
			
		<?php elseif($check == -2): ?>
			<div class="alert alert-warning">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				<strong>Kích thước tối đa của ảnh bìa là 5MB</strong>
			</div>
		<?php endif;?>

	</div>
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>

</body>

</html>