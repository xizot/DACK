<?php


require_once 'Function.php';

$postID = $_GET['postID'];
$userID = $_GET['userID'];

UnLike($postID,$userID);

echo GetPostLike($postID);

?>
