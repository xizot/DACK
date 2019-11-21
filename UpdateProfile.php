
<?php
require_once 'Header.php';
require_once 'Function.php';
if($_SESSION['email'] =="")
{
	header("Location:login.php");
}


if($_SERVER['REQUEST_METHOD'] == 'POST')
{
	$file = $_FILES['image'];
	$fileName= $file['name'];
	$fullname = $_POST['Fullname'];
	global $db;
	if(!$fileName =='')
	{

		
		$fileTmp = $file['tmp_name'];

		$ex = explode('.', $fileName);
		$newName = $_SESSION['email'].'.'.$ex[1];
		move_uploaded_file($fileTmp, 'uploads/'.$newName);

		$sql = "UPDATE users SET imgProfile =?  WHERE email=?";
		$stmt = $db->prepare($sql);
		$stmt -> execute([$newName,$_SESSION['email']]);
	}
	if (!empty($fullname)) {

		$sql = "UPDATE users SET fullname = ?  WHERE email=?";
		$stmt = $db->prepare($sql);
		$stmt -> execute([$fullname,$_SESSION['email']]);
		$_SESSION['fullname'] = $fullname;

	}

	header("Location:PostStatus.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Update Profile</title>
</head>
<body>
	<div class="container">
		<form action="" method="POST" role="form" enctype="multipart/form-data">
		<h3>Update Profile</h3>
	
		<div class="form-group">
			<label for="">Fullname</label>
			<input type="text" class="form-control" name ="Fullname" id="" placeholder="<?php echo $_SESSION['fullname'] ?>">
		</div>
		<div class="form-group">
			<label for="">Avatar</label>
	  	<input type="file" name="image">
 	</div>
		<button type="submit" class="btn btn-primary">Update </button>
	</form>
	</div>
	
</body>
</html>