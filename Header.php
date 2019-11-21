<?php 
require_once 'Init.php';
	error_reporting(E_ALL & ~E_NOTICE);
?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css">
	<style>
		nav
		{
			position: fixed;
		}
		body
		{
			background-image: url("bg.jpg");
			background-repeat: no-repeat;
			background-size: cover;
		}
	</style>

</head>
<body>
	<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="./">BTCN07</a>
    </div>
    <ul class="nav navbar-nav">
      <li <?php echo $Path == 'index.php' ||  $Path == ''?'class="active"':'' ?> ><a href="index.php">Home</a></li>
      <?php if(($_SESSION['email']!="") && ($_SESSION['status'] == 1)):?>
      	<li <?php echo $Path == 'PostStatus.php'?'class="active"':'' ?> ><a href="PostStatus.php">Post Status</a></li>
      	<li <?php echo $Path == 'UpdateProfile.php'?'class="active"':'' ?> ><a href="UpdateProfile.php"><?php echo $_SESSION['fullname']==""?$_SESSION['email']:$_SESSION['fullname'] ?></a></li>
      	<?php endif;?>
    </ul>

    <ul class="nav navbar-nav navbar-right">
    <?php if(($_SESSION['email']=="" ) || ($_SESSION['status'] == "")):?>
	      <li <?php echo $Path == 'Register.php'?'class="active"':'' ?> >
	      	<a href="./Register.php"><span class="glyphicon glyphicon-user"></span> Sign Up</a>
	      </li>
	      <li <?php echo $Path == 'Login.php'?'class="active"':'' ?> >
	      	<a href="./Login.php"><span class="glyphicon glyphicon-log-in"></span> Log In</a>
	      </li>
	<?php else: ?>
		<li <?php echo $Path == 'ChangePassword.php'?'class="active"':'' ?>><a href="ChangePassword.php">ChangePassword</a></li>

	      <li <?php echo $Path == 'Logout.php'?'class="active"':'' ?>><a href="Logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout <?php echo '( '.$_SESSION['email'].' )'; ?></a></li>
    <?php endif;?>
    </ul>
  </div>
</nav>
</body>
</html>