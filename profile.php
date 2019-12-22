<?php

require_once './Init.php';
require_once './Function.php';
require_once './navbar.php';


$id = $_GET['id'];
if (empty($id)) {
    $id = $_SESSION['id'];
}

if (!empty($id)) {
    $data = GetProfileByID($id)[0];


    !empty($data['fullname']) ? $fullname = $data['fullname'] : $fullname = "New Member";
    !empty($data['avt']) ? $avt = "./avt.php/?id=" . $id . "&for=avt" : $avt = "1.jpg";
    !empty($data['walpic']) ? $walpic = "./avt.php/?id=" . $id . "&for=wal" : $walpic = "2.jpg";
    !empty($data['Tel']) ? $tel = substr($data['Tel'], 0, 5) . "xxxxxx" : $tel = "Chưa cập nhật";
    !empty($data['DOB']) ? $dob = substr($data['DOB'], 0, 4) . "/xx/xx" : $dob = "Chưa cập nhật";
    $email = substr($_SESSION['email'], 0, 6) . ".xxxxx" . substr($_SESSION['email'], strlen($_SESSION['email']) - 4, strlen($_SESSION['email']) - 2);
}


$postID = $_GET['postID'];
if (!empty($postID)) {
    $tmp = GetPostByID($postID)[0];
    if ($tmp['createAt'] == $id) {
        $p = GetPostByID($postID)[0];
    }
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PROFILE</title>
    <link rel="stylesheet" href="./style/pro.css">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css">
    <!-- <script src="js.js"></script> -->
    <!-- <link rel="stylesheet" href="pro.css">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css"> -->
    <link class="pgcss" rel="stylesheet" href="./pageloading.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="./js.js"></script>
    <script src="./loading.js"></script>
</head>

<body>
    <svg class='svg'>
        <rect></rect>
    </svg>
    <div class="profile">
        <?php if (empty($data)) : ?>
            <div class="error">

                <div class="alert alert-danger">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <strong>Trang cá nhân không tồn tại</strong>
                </div>

            </div>
        <?php return;
        endif;  ?>
        <div class="row">
            <div class="col-md-10">

                <div class="wal-pic">
                    <a href="./<?php echo $walpic ?>"><img src="./<?php echo $walpic ?>" alt=" "></a>
                </div>
                <div class="info">
                    <div class="avt">
                        <a href="./<?php echo $avt ?>"><img src="./<?php echo $avt ?>" alt=" "></a>
                    </div>
                    <div class="name">

                        <a href=""><?php echo $fullname ?></a>
                    </div>
                    <?php if (!empty($id) && $id != $_SESSION['id']) : ?>
                        <a href="./Message.php?toID=<?php echo $id ?>" class="Message"><i class="fas fa-comment-dots"> Message</i> </a>
                    <?php endif; ?>
                </div>
                <div class="menu">
                    <div class="blank">
                    </div>
                    <ul>
                        <li><a href="" class="about"><i class="fas fa-address-card"> About</i></a></li>
                        <!-- Person profile -->
                        <?php if ($id == $_SESSION['id'] || $id == "") : ?>
                            <li><a href="./UpdateProfile.php?id=<?php echo $_SESSION['id'] ?>" class="update"><i class="fas fa-user-edit"> Update info</i></a></li>
                            <!-- End person profile -->
                        <?php elseif (!empty($id)) : ?>
                            <!-- Another profile -->



                            <?php if (!empty($id) && isFollow($_SESSION['id'], $id)) : ?>

                                <li class="nav-item dropdown" id="dropFriend">
                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-user-check">Following</i>
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="<?php echo "./removefriends.php?from=" . $_SESSION['id'] . "&to=" . $id ?>">Delete request</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="#">Something else here</a>
                                    </div>
                                </li>
                            <?php elseif (!empty($id) && isFollow($id, $_SESSION['id'])) : ?>

                                <li class="nav-item dropdown" id="dropFriend">
                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-user-check">Respon to Friend Request</i>
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="<?php echo "./removefriends.php?from=" . $_SESSION['id'] . "&to=" . $id ?>">Delete request</a>
                                        <a class="dropdown-item" href="<?php echo "./acceptFriend.php?from=" . $_SESSION['id'] . "&to=" . $id ?>">Confirm</a>
                                    </div>
                                </li>
                            <?php elseif (!empty($id) && isFriend($_SESSION['id'], $id)) : ?>
                                <li class="nav-item dropdown" id="dropFriend">
                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-user-check">Friend</i>
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        <?php if (!isFollow2($_SESSION['id'], $id)) : ?>
                                            <a class="dropdown-item" href="<?php echo "./unfollow.php?fromID=" . $_SESSION['id'] . "&toID=" . $id . "&for=follow" ?>">Follow</a>
                                        <?php elseif (isFollow2($_SESSION['id'], $id)) : ?>
                                            <a class="dropdown-item" href="<?php echo "./unfollow.php?fromID=" . $_SESSION['id'] . "&toID=" . $id . "&for=unfollow" ?>">Unfollow</a>
                                        <?php endif; ?>

                                        <a class="dropdown-item" href="<?php echo "./removefriends.php?from=" . $_SESSION['id'] . "&to=" . $id ?>">Unfriend</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="#">Something else here</a>
                                    </div>
                                </li>



                            <?php elseif (!empty($id) && !isFriend($_SESSION['id'], $id) && !isFollow($_SESSION['id'], $id)) : ?>
                                <li><a href="<?php echo "./sendRequest.php?from=" . $_SESSION['id'] . "&to=" . $id ?>" class="update"><i class="fas fa-user-plus"> Add friend</i></a></li>

                            <?php endif; ?>
                            <!-- End another profile -->

                        <?php endif; ?>
                    </ul>
                </div>





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
                    <?php if (empty($postID)) : ?>
                        <?php require_once 'post.php'; ?>
                    <?php elseif (!empty($p)) :


                        $time = $p['postTime'];
                        $status = $p['postStatus'];

                        $postPrivacy = $p['privacy'];
                        $img = "./avt.php?id=" . $postID . "&for=post"

                    ?>
                        <div class="box-status-content">

                            <div class="box-status-edit" id="<?php echo $postID ?>">
                                <div class="edit-info">
                                    <a href="" class="avt"><img src="<?php echo $avt ?>" alt=""></a>
                                    <a href="" class="name" style="text-transform:uppercase"><?php echo $fullname ?></a>
                                </div>

                                <div class="dropdown" id="delete">
                                    <a class="btn btn-secondary" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-ellipsis-h"></i>
                                    </a>
                                    <div style="height: 60px;border-radius:5px" class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                        <p style="cursor:pointer" class="dropdown-item" href="#" onclick="DeletePost(<?php echo $postID ?>)" value="hih" id="DeleteNow"> <i class="fas fa-globe-europe"></i> Xóa bài viết</p>
                                    </div>
                                </div>
                            </div>


                            <div class="clearfix"></div>
                            <div class="status-info">
                                <p class="time"><?php echo $time ?></p>
                                <div class="dropdown" id="privacy">
                                    <a class="btn btn-secondary dropdown-toggle" href="#" role="button" style="background: white;color:#616770; border:none; margin: 0 20px;padding: 0;" id="pri<?php echo $postID ?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <?php if ($postPrivacy == 2) : ?>
                                            <i class="fas fa-globe-europe"></i>
                                        <?php elseif ($postPrivacy == 1) : ?>
                                            <i class="fas fa-user-friends"></i>
                                        <?php elseif ($postPrivacy == 0) : ?>
                                            <i class="fas fa-lock"></i>
                                        <?php endif; ?>
                                    </a>

                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                        <p style="cursor:pointer" class="dropdown-item" onclick="Setprivacy('2',<?php echo $postID ?>)"><i class="fas fa-globe-europe"></i> Public</p>
                                        <p style="cursor:pointer" class="dropdown-item" onclick="Setprivacy('1',<?php echo $postID ?>)"><i class="fas fa-user-friends"></i> Friends</p>
                                        <p style="cursor:pointer" class="dropdown-item" onclick="Setprivacy('0',<?php echo $postID ?>)"><i class="fas fa-lock"></i> Only Me</p>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>


                            <p class="status"><?php echo $status ?></p>
                            <?php if ($img != "") : ?>
                                <a href="" class="imgPost"><img src="./<?php echo $img ?>" alt=""></a>
                            <?php endif; ?>
                            <div class="react-info">
                                <a href="" id="<?php echo "numLike" . $postID ?>"><?php echo GetPostLike($postID) . (GetPostLike($postID) > 1 ? " Likes" : " Like") ?></a>
                                <a href="" value="<?php echo countCommentByPostID($postID) ?>" id="<?php echo "numCmt" . $postID ?>"><?php echo countCommentByPostID($postID) . (countCommentByPostID($postID) > 1 ? " Comments" : " Comment") ?></a>
                            </div>
                            <div class="react-button">
                                <button class="like" value="<?php echo checkLike($_SESSION['id'], $postID) ? "1" : "0" ?>" id="<?php echo "post" . $postID ?>" onclick="Like(<?php echo $postID ?>,<?php echo $_SESSION['id'] ?>)"><?php echo checkLike($_SESSION['id'], $postID) ? "<i class='fas fa-thumbs-up'></i> <span class='repon'> Liked</span>" : "<i class='far fa-thumbs-up'></i><span class='repon'> Like</span>" ?></button>
                                <button class="comment" onclick="getComment(<?php echo $postID ?>)" value="0" id="btnComment<?php echo $postID ?>"><i class="far fa-comment-alt"></i><span class="repon"> Comment</span></button>
                                <button class="share"><i class="far fa-share-square"></i><span class="repon"> Share</span> </button>
                            </div>
                            <div class="react-comment" id="comment<?php echo $postID ?>">

                            </div>

                        </div>
                    <?php endif; ?>
                </div>
                <?php if (!empty($p)) : ?>
                    <div class="pagination" style="width: 100%;position: relative;justify-content: center; margin-top:20px">
                        <nav aria-label="...">
                            <ul class="pagination">
                                <?php
                                $numpage = countPage($id, 5, 'profile');
                                for ($i = 1; $i <= $numpage; $i++) : ?>

                                    <?php if ($i == 1) : ?>
                                        <li class="page-item active" id="<?php echo "page" . $i; ?>" style="cursor:pointer">
                                        <?php else : ?>
                                        <li class="page-item" id="<?php echo "page" . $i; ?>" style="cursor:pointer">
                                        <?php endif; ?>
                                        <p class="page-link" onclick="Pagination(<?php echo $i ?>,'profile',<?php echo $id ?>)" href="#"><?php echo $i ?></p>
                                        </li>
                                    <?php endfor; ?>
                            </ul>
                        </nav>
                    </div>

                <?php endif; ?>
            </div>

            <div class="col-md-2">
                <div class="About">
                    <h4><i class="fas fa-address-card"></i> About</h4>
                    <i class="fas fa-mobile-alt"> <?php echo $tel ?></i><br>
                    <i class="fas fa-envelope"> <?php echo $email ?></i><br>
                    <i class="fas fa-birthday-cake"> <?php echo $dob ?></i><br>
                </div>
                <h4 style="position:relative; margin-top:30px"><i class="fas fa-users"></i>Friends</h4>
                <?php require_once 'friend.php' ?>
            </div>
        </div>

    </div>

    <footer style="height:300px;position:relative;padding:50px;margin-top:100px;background-image: radial-gradient( circle farthest-corner at 10% 20%, rgba(0,93,133,1) 0%, rgba(0,181,149,1) 90% );">

        <?php require_once 'footer.php' ?>
    </footer>


    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>

</body>

</html>