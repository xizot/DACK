<?php

require_once 'Init.php';
require_once 'Function.php';
$msgID= $_GET['msgID'];
$fromID = $_SESSION['id'];

deleteMessage($fromID, $msgID);

?>