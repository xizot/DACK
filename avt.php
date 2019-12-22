<?php

require_once("Function.php");
require_once("Init.php");

$id = $_GET['id'];
$for = $_GET['for'];



if ($for == 'avt') {
    $data = GetProfileByID($id);
    $data = $data[0];
    header("content-type:image/jpg");
    echo $data['avt'];
} else if ($for == 'wal') {
    $data = GetProfileByID($id);
    $data = $data[0];
    header("content-type:image/jpg");
    echo $data['walpic'];
} else if ($for == 'post') {

 
    $data = GetPostByID($id)[0];
 
    header("content-type:image/jpg");
    echo $data['imgPost'];

}
