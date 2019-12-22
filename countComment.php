<?php
    require_once 'Function.php';
    require_once 'Init.php';
    
    $postID = $_GET['postID'];
    $data =  countCommentByPostID($postID);
    echo $data;
?>