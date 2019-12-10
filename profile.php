<?php
require_once('Header.php');
require_once('Function.php');
$id = $_GET['id'];
$data = GetProfileByID($id);
$name = $data[0]['fullname'];
$avt = $data[0]['imgProfile'];
$email = $data[0]['email'];
$avt = "avt.php?id=" . $id . "&for=avt";
$wal = "avt.php?id=" . $id . "&for=wal";

if (empty($data[0]['avt'])) {
	$avt = "1.jpg";
}
if (empty($data[0]['walpic'])) {
	$wal = "2.jpg";
}

$follow = -1;
if ($id != $_SESSION['id']) {
	$fr = GetFollower($_SESSION['id'], $id);
	if ($fr[0]['follow'] == 1 && $fr[0]['friend'] == 0) {
		if($fr[0]['user_1'] == $_SESSION['id'])
		{
			$follow = 1; //Đang theo dõi
		}
		else if($fr[0]['user_1'] == $id)
		{
			$follow = 3; // Nhận theo dõi => chấp nhận or delete
		}
	} else if ($fr[0]['follow'] == 0) {
		$follow = 0; // chưa kết bạn
	} else if ($fr[0]['follow'] == 1 && $fr[0]['friend'] == 1) {
		$follow = 2; // đã kết bạn
	}
}
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_POST['status'])) {
	if ($follow == 0) {
		$str = "Location:follow.php?from=" . $_SESSION['id'] . "&to=" . $id;
		header($str);
	} else if ($follow == 2 || $follow == 1) {
		removeFriends($_SESSION['id'], $id);
		header("Location:profile.php?id=" . $id);
	}
}

if(isset($_POST['status']))
{
    AddStatus($_SESSION['id'], $_SESSION['email'],$_POST['status']);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title>[name]</title>
	<link rel="stylesheet" href="./css.css">
	<link rel="stylesheet" href="./poststyle.css">
	<link rel="stylesheet" href="./profile_css.css">
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>

<body>
	<div class="row">
		<div class="col-md-10">
			<div class="container">
				<div class="header">
					<div class="wal-pic">
						<img src="<?php echo $wal ?>" alt=" ">
					</div>
					<div class="info">
						<div class="avt">
							<img src="<?php echo $avt ?>" alt=" ">
						</div>
						<div class="name">

							<p><?php echo $name ?></p>
						</div>
					</div>
					<div class="menu">
						<div class="blank">


						</div>
						<ul>
							<li><a href="">Timeline</a></li>
							<li>
								<form action="" <?php echo 'from=' . $_SESSION['id'] . '&to=' . $id ?>" method="POST" role="form">
									<?php if ($follow == 1) : ?>
										<div class="dropdown">
											<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
												Đang theo dõi
											</button>
											<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
												<a class="dropdown-item" href="removefriends.php?<?php echo "from=" . $_SESSION['id'] . "&to=" . $id ?>">Bỏ theo dõi</a>
											</div>
										</div>
									<?php elseif ($follow == 0) : ?>
										<button type="submit" class="btn btn-primary">Kết bạn</button>
									<?php elseif ($follow == 2) : ?>
										<div class="dropdown">
											<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
												Bạn Bè
											</button>
											<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
												<a class="dropdown-item" href="removefriends.php?<?php echo "from=" . $_SESSION['id'] . "&to=" . $id ?>">Hủy kết bạn</a>
												<!-- <a class="dropdown-item" href="removefriends.php?<?php echo "from=" . $_SESSION['id'] . "&to=" . $id ?>">Bỏ theo dõi</a> -->
											</div>
										</div>
									<?php elseif ($follow == 3) : ?>
										<div class="dropdown">
											<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
												Chấp Nhận Kết Bạn
											</button>
											<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
												<a class="dropdown-item" href="./confirm.php?from=<?php echo $_SESSION['id']."&to=".$id."&for=act" ?>">OK</a>
												<a class="dropdown-item" href="./confirm.php?from=<?php echo $_SESSION['id']."&to=".$id."&for=del" ?>">Delete</a>
												<!-- <a class="dropdown-item" href="removefriends.php?<?php echo "from=" . $_SESSION['id'] . "&to=" . $id ?>">Bỏ theo dõi</a> -->
											</div>
										</div>
									<?php elseif ($follow == -1) : ?>

										<a href="./UpdateProfile.php?id=<?php echo $_SESSION['id'] ?>">Cập nhật thông tin cá nhân</a>
									<?php endif; ?>
								</form>
							</li>
						</ul>
					</div>
				</div>
				<div class="box-post">
					<form action="./profile.php?id=<?php echo $id ?>" method="POST" role="form">
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
                        $data = LoadPostByID($id);
                        foreach($data as $p):
                        $postTime = $p['postTime'];
                        $postStatus = $p['postStatus'];
                    ?>
                        <div class="content">
						<img src="<?php echo $avt ?>" alt="">
						<p class="content-name"><?php echo $name?></p>
						<p class="content-time"><?php echo $postTime?></p>
						<p class="content-status"><?php echo $postStatus?></p>
				    	</div>
                    <?php endforeach; ?>
				</div>
			</div>
		</div>
		<div class="col-md-2">
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
		</div>
	</div>
</body>

</html>