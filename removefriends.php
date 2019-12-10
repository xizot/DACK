<?php

require_once("Init.php");
require_once("Function.php");
$from = $_GET['from'];
$to = $_GET['to'];

removeFriends($from,$to);
header("Location:profile.php?id=".$to);


?>