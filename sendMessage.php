<?php

require_once 'Init.php';
require_once 'Function.php';


$to = $_GET['to'];
$from = $_SESSION['id'];
$content = $_GET['content'];

SendMessage($from,$to,$content);


if(strlen($content) > 30)
{
    $content = substr($content,0,30).'...';
}


$fromInFo = GetProfileByID($from)[0];
$toInFo = GetProfileByID($to)[0];

$fromName =$fromInFo['fullname'];
$toEmail = $toInFo['email'];
$toName = $toInFo['fullname'];

echo $toEmail;

SendEmail('test.160499@gmail.com', $toEmail, $toName,'Bạn nhận được tin nhắn mới từ <a href ="http://localhost:8080/daCK_v2/DACK/message.php?toID='.$from.'">'.$fromName.'</a>: '.$content , 'Tin nhắn mới');


?>