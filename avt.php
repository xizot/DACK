<?php

require_once("Function.php");
require_once("Init.php");

$id = $_GET['id'];
$for = $_GET['for'];

$data = GetProfileByID($id);
$data= $data[0];

if($for == 'avt')
{
    header("content-type:image/jpg");
    echo $data['avt'];
}
else if($for == 'wal')
{
    header("content-type:image/jpg");
    echo $data['walpic'];
}

?>