<?php

require_once("Function.php");

$from = $_GET['from'];
$to = $_GET['to'];
if(empty($from))
{
    header("Location:Login.php?id=".$to);
}
else
{
    SendRequest($from,$to);

    $fromInFo = GetProfileByID($from)[0];
    $toInFo = GetProfileByID($to)[0];

    $fromName =$fromInFo['fullname'];
    $toEmail = $toInFo['email'];
    $toName = $toInFo['fullname'];

    echo $toEmail;

    SendEmail('test.160499@gmail.com', $toEmail, $toName,'Bạn nhận được lời mời kết bạn từ <a href ="http://localhost:8080/daCK_v2/DACK/profile.php?id='.$from.'">'.$fromName.'</a>' , 'Lời mời kết bạn mới');

    header("Location:profile.php?id=".$to);
}


?>