<?php

require 'Function.php';
require 'Init.php';

$fromID = $_SESSION['id'];
$toID = $_GET['toID'];

$Messages = GetMessage($toID);

$fromInfo = GetProfileByID($fromID)[0];

!empty($fromInfo['fullname']) ? $fromName = $fromInfo['fullname'] : $fromName = "NEW MEMBER";
!empty($fromInfo['avt']) ? $fromAvt = "./avt.php?id=" . $fromID . "&for=avt" : $fromAvt = "1.jpg";

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
    <script src="./js.js"></script>
</head>

<body>

    <?php foreach ($Messages as $msg) : ?>

        <?php if ($msg['user_1'] == $fromID) : ?>
            <div class="box-msg-content" id="user1">
                <img src="<?php echo $fromAvt ?>" alt="">
                <div class="msg-info">
                    <a href=""><?php echo $fromName; ?></a>
                    <p><?php echo $msg['message'] ?></p>
                </div>
            </div>
        <?php endif; ?>

    <?php endforeach; ?>
    <!-- <div class="box-msg-content">
        <a href=""><img src="1.jpg" alt=""></a>
        <div class="msg-info">
            <a href="">John Cena</a>
            <p onclick="GetMessage(1)">How are you</p>
        </div>
    </div> -->

    <!--  <div class="box-msg-content" id="user1">
        <img src="1.jpg" alt="">
        <div class="msg-info">
            <a href="">John Cena</a>
            <p>How are you?</p>
        </div>
    </div> -->

    <!-- <div class="box-msg-content" id="user2">
        <img src="1.jpg" alt="">
        <div class="msg-info">
            <a href="">John Cena</a>
            <p>How are you?</p>
        </div>
    </div> -->



</body>

</html>