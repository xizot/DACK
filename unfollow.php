<?php

require_once 'Function.php';
$from = $_GET['fromID'];
$to = $_GET['toID'];
$for = $_GET['for'];

if($for=="unfollow")
{
    unFollow($from,$to);
}
else if($for == "follow")
{
    Follow($from,$to);
}

header("Location:./profile.php?id=".$to);

?>