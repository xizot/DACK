<?php

require_once("Function.php");

$postID = $_GET['postID'];
$userID = $_GET['userID'];
$status = $_GET['status'];
$postInfo = GetPostByID($postID)[0];

sendComment($postID, $userID, $status);
addNotifications($userID,$postInfo['createAt'],$postID,1);
$cmtInfo = GetProfileByID($userID)[0];
$cmtName = $cmtInfo['fullname'];
!empty($cmtInfo['avt']) ? $cmtAvt = "./avt.php?id=" . $userID . "&for=avt" : $cmtAvt = "1.jpg";
$cmtText = $status;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <div class="box-comment" id="cmt<?php echo $postID ?>">
        <div class="react-comment-info">
            <a href="" class="react-comment-avt"><img src="<?php echo $cmtAvt ?>" alt=""></a>
            <a href="" class="react-comment-name"><?php echo $cmtName ?></a>
        </div>

        <p class="react-comment-txt"><?php echo $cmtText ?>
        </p>
    </div>
</body>

</html>