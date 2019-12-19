<?php

require_once './Init.php';
require_once './Function.php';



$id = $_GET['id'];
if (!empty($id)) {
    $data = GetProfileByID($id)[0];

    !empty($data['fullname']) ? $fullname = $data['fullname'] : $fullname = "New Member";
    !empty($data['avt']) ? $avt = "./avt.php/?id=" . $id . "&for=avt" : $avt = "1.jpg";
    !empty($data['walpic']) ? $walpic = "./avt.php/?id=" . $id . "&for=wal" : $walpic = "2.jpg";
} else {
    $id = $_SESSION['id'];
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="./style/pro.css">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css">
    <script src="js.js"></script>
</head>

<body>
    <?php
    $url = $_SERVER['REQUEST_URI'];
    $url = explode('/', $url);
    $path = explode('?', ($url[count($url) - 1]))[0];
    if ($path == "index.php" || $path == "") {
        $data = LoadAllFriendPost($_SESSION['id'],5,1);
    } else {
       $data = GetPostByCreateIDPagination($id,5,1);
       
    }

    if (!empty($data)) : ?>
        <?php foreach ($data as $p) :

                $eachID = $p['createAt'];
                $eachData = GetProfileByID($eachID)[0];


                !empty($eachData['fullname']) ? $fullname = $eachData['fullname'] : $fullname = "New Member";
                !empty($eachData['avt']) ? $avt = "./avt.php/?id=" . $eachID . "&for=avt" : $avt = "1.jpg";
                !empty($eachData['walpic']) ? $walpic = "./avt.php/?id=" . $eachID . "&for=wal" : $walpic = "2.jpg";
                $time = $p['postTime'];
                $status = $p['postStatus'];
                $postID = $p['id'];
                $postPrivacy = $p['privacy'];
                (!empty($p)) ? $img = "./avt.php?id=" . $p['id'] . "&for=post" : $img = "";


                ?>
            <div class="box-status-content">

                <div class="box-status-edit" id="<?php echo $postID ?>">
                    <div class="edit-info">
                        <a href="<?php echo "./profile.php?id=".$p['createAt'] ?>" class="avt"><img src="<?php echo $avt ?>" alt=""></a>
                        <a href="<?php echo "./profile.php?id=".$p['createAt'] ?>" class="name"><?php echo $fullname ?></a>
                    </div>
                <?php if ($_SESSION['id'] == $eachID) : ?>
                    <div class="dropdown" id="delete">
                        <a  style="background: transparent;" class="btn btn-secondary " href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-h"></i>
                        </a>
                        <div style="height: 60px;border-radius:5px" class="dropdown-menu" aria-labelledby="dropdownMenuLink" >
                            <p style="cursor:pointer" class="dropdown-item" href="#" onclick="DeletePost(<?php echo $postID ?>)" value="hih" id="DeleteNow"> <i class="fas fa-globe-europe"></i> Xóa bài viết</p>
                        </div>
                    </div>
                <?php endif; ?>
                </div>


                <div class="clearfix"></div>
                <div class="status-info">
                    <p class="time"><?php echo $time ?></p>
                    <?php if ($_SESSION['id'] == $eachID) : ?>
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
                    <?php else : ?>
                        <?php if ($postPrivacy == 2) : ?>
                            <i style="background: white;color:#616770; border:none; margin: 0 30px;padding-top: 5px;" class="fas fa-globe-europe"></i>
                        <?php elseif ($postPrivacy == 1) : ?>
                            <i style="background: white;color:#616770; border:none; margin: 0 30px;padding-top: 5px;" class="fas fa-user-friends"></i>
                        <?php elseif ($postPrivacy == 0) : ?>
                            <i style="background: white;color:#616770; border:none; margin: 0 30px;padding-top: 5px;" class="fas fa-lock"></i>
                        <?php endif; ?>
                    <?php endif; ?>
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
        <?php endforeach; ?>
    <?php endif; ?>
</body>

</html>