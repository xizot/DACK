<?php
error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE);
error_reporting(E_ERROR | E_PARSE);
require_once 'Header.php';
require_once 'Function.php';
if ($_SESSION['email'] == "") {
	header("Location:login.php");
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$avt = $_FILES['image'];
	$avtName = $avt['name'];

	$walpic = $_FILES['walpic'];
	$walpicName = $walpic['name'];

	$fullname = $_POST['Fullname'];
	global $db;
	if (!$avtName == '') {
		
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

	if (!empty($walpicName)) {
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


	
	header("Location:profile.php?id=".$_SESSION['id']);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title>Update Profile</title>
	<link rel="stylesheet" href="./css.css">
	<link rel="stylesheet" href="./update.css">
</head>

<body>
	<div class="form-update">
		<form action="" method="POST" role="form" enctype="multipart/form-data">
			<center>
				<h3>Update Profile</h3>
			</center>

			<div class="form-group">
				<label for="">Fullname</label>
				<input type="text" class="form-control" name="Fullname" id="" placeholder="<?php echo $_SESSION['fullname'] ?>">
			</div>
			<div class="form-group">
				<label for="">Avatar</label>
				<input type="file" name="image">
			</div>
			<div class="form-group">
				<label for="">WallPic</label>
				<input type="file" name="walpic">
			</div>
			<button type="submit" class="btn btn-primary">Update </button>
		</form>
	</div>

</body>

</html>