<?php

require_once("Function.php");
require_once("Init.php");

$from = $_GET['from'];
$to = $_GET['to'];

AcceptFriends($from,$to);
header("Location:profile.php?id=".$to);

// if($for == "act")
// {
//     AcceptFriends($from,$to);
    
// }
// else if($for == "del")
// {
//    removeFriends($from,$to);
//    header("Location:RequestFriends.php?id=".$_SESSION['id']);
// }



?>