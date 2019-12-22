<?php
require_once 'Function.php';
require_once 'Init.php';

$postID = $_GET['postID'];
$data = GetCommentByPostID($postID);
$currentAvt = GetProfileByID($_SESSION['id'])[0]['avt'];

!empty($currentAvt) ? $currentAvt = "./avt.php?id=" . $_SESSION['id'] . "&for=avt" : $currentAvt = "1.jpg"
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="./style/comment.css">
</head>

<body>

    <?php foreach ($data as $cmt) :
        $cmtID = $cmt['userID'];
        $cmtInfo = GetProfileByID($cmtID)[0];
        $cmtName = $cmtInfo['fullname'];
        !empty($cmtInfo['avt']) ? $cmtAvt = "./avt.php?id=" . $cmtID . "&for=avt" : $cmtAvt = "1.jpg";
        $cmtText = $cmt['cmtText'];

        ?>
        <div class="box-comment" id="cmt<?php echo $postID ?>">
            <div class="react-comment-info">
                <a href="" class="react-comment-avt"><img src="<?php echo $cmtAvt ?>" alt=""></a>
                <a href="" class="react-comment-name"><?php echo $cmtName ?></a>
            </div>

            <p class="react-comment-txt"><?php echo $cmtText ?>
            </p>
        </div>
    <?php endforeach; ?>
    <div class="box-write" id="boxInput<?php echo $postID ?>">
        <a href="" class="cmtIMG"><img src="<?php echo $currentAvt ?>" alt=""></a>
        <input type="text" class="cmtInput<?php echo $postID ?>" onkeyup="sendComment(<?php echo $postID ?>,<?php echo $_SESSION['id'] ?>,event)">
    </div>
</body>

</html>