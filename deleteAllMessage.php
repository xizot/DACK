<?php

require_once 'Function.php';

$fromID=$_GET["fromID"];
$toID=$_GET["toID"];


deleteAllMessage($fromID,$toID);

?>