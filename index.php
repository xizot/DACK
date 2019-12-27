<?php

require_once 'Init.php';
require_once 'Function.php';
require_once 'navbar.php';

if(empty($_SESSION['id']))
{
	header("Location:./Login.php");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if (isset($_POST['status']) && isset($_FILES['image'])) {
		$Image = "";
		if (!empty($_FILES['image']['name'])) {
			$Image = ConvertIMG($_FILES['image']);
		}
		if ($_POST['status'] != "" || $Image != "") {
			AddStatus($_SESSION['id'], $_SESSION['email'], $_POST['status'], $Image);
		}
	}
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title>HOME</title>
	<link rel="stylesheet" href="./style/index.css" />
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<link rel="stylesheet" href="./pageloading.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="./js.js"></script>
	<link class="pgcss" rel="stylesheet" href="./pageloading.css">
	<script src="./loading.js"></script>

</head>

<body>
	<?php if ($_SESSION['id'] != "" && $_SESSION['email'] != "") : ?>
		<div class="index">
			<div class="row">
				<div class="col-md-10">
					<div class="index-box">
						<div class="box-form-post" style="width: 80%">
							<form action="" method="POST" role="form" enctype="multipart/form-data">
								<legend>CREATE POST</legend>

								<div class="form-group">
									<input type="text" class="form-control" id="" placeholder="What's on your mind?" style="height:100px" name="status">
								</div>
								<div class="form-group">
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text" id="inputGroupFileAddon01"><i class="fas fa-camera-retro"></i></span>
										</div>
										<div class="custom-file">
											<input type="file" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01" name="image">
											<label class="custom-file-label" for="inputGroupFile01">Photo</label>
										</div>
									</div>
								</div>

								<button type="submit" class="btn btn-primary">POST</button>
							</form>

						</div>
						<div class="box-status" style="width: 80%">
							<?php require_once './post.php' ?>
						</div>
					</div>
					<div class="pagination" style="width: 100%;position: relative;justify-content: center;margin-top:-50px">
						<nav aria-label="...">
							<ul class="pagination">
								<?php
								$numpage = countPage($id, 5, 'index');
								for ($i = 1; $i <= $numpage; $i++) : ?>
									<?php if ($i == 1) : ?>
										<li class="page-item active" id="<?php echo "page" . $i; ?>" style="cursor:pointer">
										<?php else : ?>
										<li class="page-item" id="<?php echo "page" . $i; ?>" style="cursor:pointer">
										<?php endif; ?>
										<p class="page-link" onclick="Pagination(<?php echo $i ?>,'index')" href="#"><?php echo $i ?></p>
										</li>
									<?php endfor; ?>
							</ul>
						</nav>
					</div>
				</div>
				<div class="col-md-2" style="margin-top: 70px">
					<h4><i class="fas fa-users"></i>Friends</h3>
						<div class="box-friend">
							<?php require_once './friend.php' ?>
						</div>

				</div>
			</div>
		<?php endif; ?>
		</div>
		<footer style="position:relative;padding:50px;margin-top:70vh;background-image: radial-gradient( circle farthest-corner at 10% 20%, rgba(0,93,133,1) 0%, rgba(0,181,149,1) 90% );">

			<?php require_once 'footer.php' ?>
		</footer>
</body>

</html>