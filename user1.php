<?php
require_once 'Init.php';
require_once 'Function.php';

$content = $_GET['content'];

$fromInfo = GetProfileByID($_SESSION['id'])[0];
!empty($fromInfo['fullname']) ? $fromName = $fromInfo['fullname'] : $fromName = "NEW MEMBER";
!empty($fromInfo['avt']) ? $fromAvt = "./avt.php?id=" . $_SESSION['id'] . "&for=avt" : $fromAvt = "1.jpg";


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="./style/message.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>

<body>
    <div class="box-msg-content" id="user1">
        <img src="<?php echo $fromAvt ?>" alt="">
        <div class="msg-info">
            <a href=""><?php echo $fromName; ?></a>
            <p><?php echo $content ?></p>
        </div>
    </div>
</body>

</html>