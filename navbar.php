<?php
ob_start();
require_once 'Init.php';
require_once 'Function.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['q'])) {
        header("Location:search.php?q=" . $_POST['q']);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="./style/nav.css">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="icon" type="image/gif" href="icon.gif" />
    <link href="https://fonts.googleapis.com/css?family=IBM+Plex+Sans:300,400,400i,500,500i,600,600i,700&display=swap&subset=vietnamese" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css" />
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light" id="nav">
    
        <a class="navbar-brand" href="<?php echo $_SESSION['id']!=null?"./profile.php?id=".$_SESSION['id'] :"./Login.php" ?>">X I Z O T</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <form class="form-inline my-6 ml-lg-auto" method="POST">
                <div class="input-group input-group-sm">
                    <input type="text" class="form-control" name="q" placeholder="Input ID, Email or Name" aria-label="Recipient's username" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                        <button class="btn btn-secondary my-2 my-sm-0" type="submit">Search</button>
                    </div>
                </div>
            </form>
            <ul class="navbar-nav ml-lg-auto">
                <!-- <li class="nav-item active">
                        <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                    </li> -->
                <?php if ($_SESSION['email'] == "") : ?>
                    <li class="nav-item" id="login">
                        <a class="nav-link" href="Login.php"><button class="btn
                                btn-success my-2 my-sm-0">LOG IN</button></a>
                    </li>
                    <li class="nav-item" id="signup">
                        <a class="nav-link" href="./Register.php"><button class="btn
                                btn-outline-primary my-2 my-sm-0 bg-primary
                                text-white">SIGN UP</button></a>
                    </li>
                    <li class="nav-item" id="login_signup">
                        <a class="nav-link" href="./Login.php"><button class="btn
                                btn-outline-primary my-2 my-sm-0 bg-primary
                                text-white">LOG IN/SIGN UP</button></a>
                    </li>

                <?php elseif ($_SESSION['email'] != "") : ?>


                    <li class="nav-item" id="dropdown">
                        <a class="nav-link" href="./index.php"><i class="fas fa-home"> HOME</i></a>
                    </li>
                    <li class="nav-item" id="dropdown">
                        <a class="nav-link " id="requestfr" href="./Request.php"><i class="fas fa-user-friends">
                                <span class="fa fa-comment"></span>
                                <span class="num"><?php echo countRequestFriends($_SESSION['id']) ?></span>
                            </i></a>
                    </li>
                    <li class="nav-item" id="dropdown">
                        <a class="nav-link" href="./message.php"><i class="fas fa-envelope"></i></a>
                    </li>

                    <li class="nav-item dropdown" id="dropdown">
                        <a class="nav-link" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-bell">
                                <span class="fa fa-comment"></span>
                                <span class="num"><?php echo countNotifications($_SESSION['id']) ?></span>
                            </i>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown" id="navdrop" style="width:200px">

                            <?php $notify = getNotifications($_SESSION['id']);
                                foreach ($notify as $noti) :
                                    $notiInfo = GetProfileByID($noti['byID']);
                                    $notiName = $notiInfo['fullname'];
                                    $notiAvt = "./avt.php?id=" . $noti['byID'] . "&for=avt";
                                    $notiType = $noti['type'];

                                    ?>
                                <?php if ($noti['type'] == 0) : ?>
                                    <?php if ($noti['seen'] == 0) : ?>
                                        <a class="dropdown-item" href="" style="position:relative; background: yellow;height:30px; margin-top:10px">
                                            <img style="width:20px;height:20px;float:left;position:absolute; border-radius:50%" src="<?php echo $notiAvt ?>" alt=" ">
                                            <a style="position:absolute; font-size:12px; margin-top:-25px; padding-left:60px" onclick="seenNotiFy(<?php echo $noti['byID'] ?>,<?php echo $noti['postID'] ?>,<?php echo $notiType ?>)" href="./profile.php?id=<?php echo $_SESSION['id'] . "&postID=" . $noti['postID'] ?>"> Like your post</a>
                                        </a>
                                    <?php elseif ($noti['seen'] == 1) : ?>
                                        <a class="dropdown-item" href="" style="position:relative; background: white;height:30px; margin-top:10px">
                                            <img style="width:20px;height:20px;float:left;position:absolute; border-radius:50%" src="<?php echo $notiAvt ?>" alt=" ">
                                            <a style="position:absolute; font-size:12px; margin-top:-25px; padding-left:60px" onclick="seenNotiFy(<?php echo $noti['byID'] ?>,<?php echo $noti['postID'] ?>,<?php echo $notiType ?>)" href="./profile.php?id=<?php echo $_SESSION['id'] . "&postID=" . $noti['postID'] ?>"> Like your post</a>
                                        </a>
                                    <?php endif; ?>
                                <?php elseif ($noti['type'] == 1) : ?>
                                    <?php if ($noti['seen'] == 0) : ?>
                                        <a class="dropdown-item" href="" style="position:relative; background: yellow;height:30px; margin-top:10px">
                                            <img style="width:20px;height:20px;float:left;position:absolute; border-radius:50%" src="<?php echo $notiAvt ?>" alt=" ">
                                            <a style="position:absolute; font-size:12px; margin-top:-25px; padding-left:60px" onclick="seenNotiFy(<?php echo $noti['byID'] ?>,<?php echo $noti['postID'] ?>,<?php echo $notiType ?>)" href="./profile.php?id=<?php echo $_SESSION['id'] . "&postID=" . $noti['postID'] ?>"> Comment on your post</a>
                                        </a>
                                    <?php elseif ($noti['seen'] == 1) : ?>
                                        <a class="dropdown-item" href="" style="position:relative; background: white;height:30px; margin-top:10px">
                                            <img style="width:20px;height:20px;float:left;position:absolute; border-radius:50%" src="<?php echo $notiAvt ?>" alt=" ">
                                            <a style="position:absolute; font-size:12px; margin-top:-25px; padding-left:60px" onclick="seenNotiFy(<?php echo $noti['byID'] ?>,<?php echo $noti['postID'] ?>,<?php echo $notiType ?>)" href="./profile.php?id=<?php echo $_SESSION['id'] . "&postID=" . $noti['postID'] ?>"> Comment on your post</a>
                                        </a>
                                    <?php endif; ?>

                                <?php endif; ?>
                            <?php endforeach; ?>
                    </li>
                    <li class="nav-item dropdown" id="dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-user-ninja"></i>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown" id="navdrop">
                            <a class="dropdown-item" href="<?php echo "./profile.php?id=" . $_SESSION['id'] ?>">Profile</a>
                            <a class="dropdown-item" href="./ChangePassword.php">Change password</a>
                            <a class="dropdown-item" href="./UpdateProfile.php?id=<?php echo $_SESSION['id'] ?>">Update information</a>
                            <a class="dropdown-item" href="./search.php">Find friends</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Something else here</a>
                        </div>
                    </li>


                    <li class="nav-item" id="logout">
                        <a class="nav-link" href="Logout.php"><button class="btn btn-warning my-2 my-sm-0">LOG OUT</button></a>
                    </li>
                <?php endif; ?>

            </ul>

        </div>
    </nav>

</body>

</html>