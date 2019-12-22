<?php

require_once 'Init.php';
require_once 'Function.php';
$postID = $_GET['postID'];
$byID = $_GET['byID'];
$type = $_GET['type'];



seenNotifications($postID,$byID,$type);
?>
