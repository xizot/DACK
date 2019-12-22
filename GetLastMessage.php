<?php

require_once 'Function.php';
require_once 'Init.php';
// require 'navbar.php';

$fromID = $_SESSION['id'];
$data = GetAllMessage($fromID);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="./style/message.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="./js.js"> </script>
</head>

<body>
    <?php foreach ($data as $d) :
        $msg = GetLastMessage($d[1]);
        $toID = $d[0];
        $toInfo = GetProfileByID($toID)[0];
        !empty($toInfo['fullname']) ? $toName = $toInfo['fullname'] : $toName = "NEW MEMBER";
        !empty($toInfo['avt']) ? $toAvt = "./avt.php?id=" . $toID . "&for=avt" : $toAvt = "1.jpg";
        $msgContent = $msg['message'];
        if ((strlen($msgContent)) > 20) {
            $msgContent = substr($msgContent, 0, 20) . "...";
        }
        ?>


        <div class="box-msg-content" id = <?php echo "Last".$toID ?>>
            <a href="<?php echo "./profile.php?id=" . $toID ?>"><img src="<?php echo $toAvt ?>" alt=" "></a>
            <div class="msg-info">
                <a href="<?php echo "./profile.php?id=" . $toID ?>"><?php echo $toName; ?></a>
                <p style="cursor:pointer" onclick="GetMessage(<?php echo $fromID ?>,<?php echo $toID ?>)"><?php echo ($d['user_1'] == $fromID) ? "You: " . $msgContent : $msgContent ?></p>
            </div>
            <div class="dropdown" id="delete">
                    <a style="background: transparent; border:none; position:absolute; margin-left:-30px " class="btn btn-secondary" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-ellipsis-h"></i>
                    </a>
                    <div style="height: 60px;border-radius:5px" class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <p style="cursor:pointer" class="dropdown-item" href="#" onclick="DeleteAllMessage(<?php echo $_SESSION['id'] ?>,<?php echo $toID ?>)" value="hih" id="DeleteNow"> <i class="fas fa-trash-alt"></i> Xóa cuộc trò chuyện</p>
                    </div>
                </div>
        </div>
    <?php endforeach; ?>
</body>

</html>