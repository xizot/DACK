<?php
{
	
	session_start();
	$Url = $_SERVER['REQUEST_URI'];
	$Path = explode('/', $Url);
	$Path = $Path[2];

}
