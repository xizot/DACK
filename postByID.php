<?php
require_once 'Init.php';
require_once 'Function.php';


$postID = $_GET['postID'];


$Info = GetProfileByID($_SESSION['id'])[0];
$Name = $Info['fullname'];
$avt = "./avt.php?id=" . $_SESSION['id'] . "&for=avt";
$p = GetPostByID($postID)[0];
$time = $p['postTime'];
$status = $p['postStatus'];

$postPrivacy = $p['privacy'];
$img = "./avt.php?id=" . $postID . "&for=post"

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="./style/pro.css">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css">
    <script src="js.js"></script>
</head>

<body>
     <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>

    <div class="box-status-content">

        <div class="box-status-edit" id="<?php echo $postID ?>">
            <div class="edit-info">
                <a href="" class="avt"><img src="<?php echo $avt ?>" alt=""></a>
                <a href="" class="name"><?php echo $Name ?></a>
            </div>

            <div class="dropdown" id="delete">
                <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
</body>

</html>