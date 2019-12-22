<?php 

require_once 'Function.php';

$privacy = $_GET['privacy'];
$postID = $_GET['postID'];

setPrivacy($postID,$privacy);


?>