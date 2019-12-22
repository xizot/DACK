<?php


require_once 'Init.php';
require_once 'navbar.php';

if (empty($_SESSION['id'])) {
    header("Location:Login.php");
}


$tofrID = $_GET['toID'];
$fromID = $_SESSION['id'];
$fromInfo = GetProfileByID($fromID)[0];
!empty($fromInfo['fullname']) ? $fromName = $fromInfo['fullname'] : $fromName = "NEW MEMBER";
!empty($fromInfo['avt']) ? $fromAvt = "./avt.php?id=" . $fromID . "&for=avt" : $fromAvt = "1.jpg";

if (!empty($tofrID)) {


    $Messages = GetMessage($fromID, $tofrID);



    $tofrInfo = GetProfileByID($tofrID)[0];
    !empty($tofrInfo['fullname']) ? $tofrName = $tofrInfo['fullname'] : $tofrName = "NEW MEMBER";
    !empty($tofrInfo['avt']) ? $tofrAvt = "./avt.php?id=" . $tofrID . "&for=avt" : $toAvt = "1.jpg";
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>MESSAGE</title>
    <link rel="stylesheet" href="./style/message.css">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <!-- <meta http-equiv="refresh" content="5"> -->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="./js.js"></script>
    <link class="pgcss" rel="stylesheet" href="./pageloading.css">
	<script src="./loading.js"></script>

<body>


    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

    <div class="Mess" style="position:relative; top:90px;">
        <div class="row" style="height:80vh">
            <div class="col-md-4">
                <div class="msgLeft" style="padding:20px">
                    <?php require_once './GetLastMessage.php' ?>
                </div>
            </div>
            <div class="col-md-8">
                <div class="msgRight">
                    <?php if (!empty($Messages)) : ?>
                        <?php foreach ($Messages as $msg) :  ?>
                            <?php if ($msg['user_1'] == $fromID) : ?>
                                <div class="box-msg-content <?php echo "msg" . $msg['id'] ?>" id="user1">
                                    <img src="<?php echo $fromAvt ?>" alt="">
                                    <div class="msg-info">
                                        <a href=""><?php echo $fromName; ?></a>
                                        <p><?php echo $msg['message'] ?></p>
                                    </div>

                                    <div class="dropdown" id="delete">
                                        <a style="background: transparent; border:none; position:absolute; margin-left:-30px" class="btn btn-secondary" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-h"></i>
                                        </a>
                                        <div style="height: 60px;border-radius:5px" class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                            <p style="cursor:pointer" class="dropdown-item" href="#" onclick="DeleteMessage(<?php echo $msg['id'] ?>)" value="hih" id="DeleteNow"> <i class="fas fa-trash-alt"></i> Xóa tin nhắn</p>
                                        </div>
                                    </div>
                                </div>
                            <?php elseif ($msg['user_1'] == $tofrID) :

                            ?>
                                <div class="box-msg-content <?php echo "msg" . $msg['id'] ?>" id="user2">
                                    <img src="<?php echo $tofrAvt ?>" alt="">
                                    <div class="msg-info">
                                        <a href=""><?php echo $tofrName ?></a>
                                        <p><?php echo $msg['message'] ?></p>
                                    </div>
                                    <div class="dropdown" id="delete">
                                        <a style="background: transparent; border:none; position:absolute; margin-left:-30px" class=" btn btn-secondary" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-h"></i>
                                        </a>
                                        <div style="height: 60px;border-radius:5px" class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                            <p style="cursor:pointer" class="dropdown-item" href="#" onclick="DeleteMessage(<?php echo $msg['id'] ?>)" value="hih" id="DeleteNow"> <i class="fas fa-trash-alt"></i> Xóa tin nhắn</p>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>

                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <div class="msgWrite">
                    <img class="img" src="<?php echo $fromAvt ?>" alt=" ">
                    <input style="text-align:center" type="text" id="chat" onkeyup="SendMessage(<?php echo $tofrID ?>,event)">

                </div>
            </div>

        </div>
    </div>
</body>

</html>