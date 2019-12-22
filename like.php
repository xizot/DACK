<?php
require_once 'Function.php';

$postID = $_GET['postID'];
$userID = $_GET['userID'];

Like($postID,$userID);

$postInfo = GetPostByID($postID)[0];
addNotifications($userID,$postInfo['createAt'],$postID,0);

echo GetPostLike($postID);

?>
