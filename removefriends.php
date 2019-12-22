<?php

require_once("Init.php");
require_once("Function.php");
$from = $_GET['from'];
$to = $_GET['to'];

removeFriends($from,$to);


$for = $_GET['for'];

if($for == 'req')
{
    header("Location:Request.php");
}
else
{
    header("Location:profile.php?id=".$to);
}

?>