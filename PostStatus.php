
<?php
require_once 'Header.php';
require_once 'Function.php';

if($_SERVER['REQUEST_METHOD']=='POST')
{
	$postStatus = $_POST['Status'];
	if(!empty($postStatus))
	{
		AddStatus($_SESSION['email'], $postStatus);
	}

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Post Status Page</title>
	<link rel="stylesheet" href="post.css">
</head>
<body>
	<div class="container">
		<form action="" method="POST" role="form">
		<h3>Create Post</h3>
	
		<div class="form-group">
			<input type="text" class="form-control" id="" name="Status" placeholder="What's on your mind?" style="height: 100px">
		</div>
	
		<button type="submit" class="btn btn-primary">Post</button>
		</form>
		
			<?php LoadStatus($_SESSION['email']);?> 
		</div>
	</div>

</body>
</html>