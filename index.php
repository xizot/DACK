<?php
require_once 'Header.php';
require_once 'Init.php';

if(isset($_POST['status']))
{
    AddStatus($_SESSION['id'], $_SESSION['email'],$_POST['status']);
}
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<link rel="stylesheet" href="./css.css">
	<link rel="stylesheet" href="./poststyle.css">
	<link rel="stylesheet" href="./profile_css.css">
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body>
	<?php if($_SESSION['id'] != "" && $_SESSION['email']!= ""): ?>
	<div class="row">
		<div class="col-md-10">
			<div class="box-post">
					<form action="./index.php?id=<?php echo $id ?>" method="POST" role="form">
						<center>
							<h3>Create Post</h3>
						</center>
						<div class="form-group">
							<input type="text" class="form-control" id="" placeholder="What's on your mind" style="height:100px;" name="status">
						</div>
						<button type="submit" class="btn btn-primary" style="width: 100%">Đăng Bài</button>
					</form>
				</div> 

				<div class="box-status">
					<h3>Posts</h3>
                    <?php 
                        $data = LoadAllFriendPost($_SESSION['id']);

                        foreach($data as $p):
                        $pID = $p['id'];
                        $pAvt = "avt.php?id=".$pID."&for=avt";
                        $postTime = $p['postTime'];
                        $postStatus = $p['postStatus'];
                        $pInFo = GetProfileByID($pID);
                        $pName = $pInFo[0]['fullname'];
                     
                    ?>
                        <div class="content">
						<img src="<?php echo $pAvt ?>" alt="">
						<p class="content-name"><?php echo $pName?></p>
						<p class="content-time"><?php echo $postTime?></p>
						<p class="content-status"><?php echo $postStatus?></p>
				    	</div>
                    <?php endforeach; ?>
				</div>
		</div>
		<div class="col-md-2">
			<?php if($_SESSION['email'] != ""): ?>
			<?php
			$friends = LoadFriends($_SESSION['id']);
			foreach ($friends as $f) :
				$info = GetProfileByID($f['user_2']);
				$frAvt = "avt.php?id=" . $info[0]['id'] . "&for=avt";
				if (empty($info[0]['avt'])) {
					$frAvt = "1.jpg";
				}
				?>
				<div class="friends">
					<div class="friends-img">
						<a href="./profile.php?id=<?php echo $info[0]['id'] ?>"><img src="<?php echo $frAvt ?>" alt=""></a>
					</div>
					<div class="friends-name">
						<a href="./profile.php?id=<?php echo $info[0]['id'] ?>">
							<p><?php echo $info[0]['fullname']; ?></p>
						</a>
					</div>
				</div>
			<?php endforeach; ?>
		<?php endif; ?>
		</div>
	</div>
    <?php endif; ?>
</body>
</html>