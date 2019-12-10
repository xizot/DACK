<?php
require_once('Function.php');

$from = $_GET['from'];
$to = $_GET['to'];

Follower($from,$to);

header("Location:profile.php?id=$to");


?>