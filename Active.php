<?php 
require_once 'init.php';
require_once 'Header.php';
require_once 'Function.php';

//Test Commit

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
		<form action="" method="GET" role="form">
		<h3>Active account</h3>
			<div class="form-group">
				<label for="">Activation Code</label>
				<input type="text" class="form-control" name ="code" id="code" placeholder="Code">
			</div>
			
		<button type="submit" class="btn btn-primary">Submit</button>
	</div>
	
</body>
</html>