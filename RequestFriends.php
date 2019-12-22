<?php

require_once("Init.php");
require_once("Function.php");
require_once("navbar.php");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="./style/request.css">
    <link rel="stylesheet" href="./style/index.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>

<body>
    <div class="row">
        <div class="col-md-10" style="margin-top: 30px">
            <div class="box-request">

                <?php $requests = RequestFriends($_SESSION['id']);
                    foreach($requests as $rq):
                        $rq_Info = GetProfileByID($rq['user_1']);
                        $rqAvt ="avt.php?id=" . $rq_Info[0]['id'] . "&for=avt";
                        if (empty($rq_Info[0]['avt'])) {
                            $rqAvt = "1.jpg";
                        }
                        $rqName = $rq_Info[0]['fullname'];
                        $rqID = $rq_Info[0]['id'];
                        $rqProFile = "profile.php?id=".$rqID;
                ?>

                <div class="content">
                    <div class="info">
                        <a href="<?php echo $rqProFile ?>"><img src="<?php echo $rqAvt ?>" alt=""></a>
                        <a href="<?php echo $rqProFile ?>" class="name"><?php echo $rqName ?></a>
                        <a href="./confirm.php?from=<?php echo $_SESSION['id']."&to=".$rqID."&for=act" ?>" class="accept"> Confirm</a>
                        <a href="./confirm.php?from=<?php echo $_SESSION['id']."&to=".$rqID."&for=del" ?>" class="delete"> Delete Request</a>
                    </div>
                </div>

                    <?php endforeach; ?>
            </div>
        </div>

            <div class="col-md-2">
                <?php
                $friends = LoadFriends($_SESSION['id']);
                foreach ($friends as $f) :
                    $info = GetProfileByID($f['user_2']);
                    $frAvt = "avt.php?id=" . $info[0]['id'] . "&for=avt";
                    if (empty($info[0]['avt'])) {
                        $frAvt = "1.jpg";
                    }
                    ?>
                    <div class="friends">
                        <div class="friends-img">
                            <a href="./profile.php?id=<?php echo $info[0]['id'] ?>"><img src="<?php echo $frAvt ?>" alt=""></a>
                        </div>
                        <div class="friends-name">
                            <a href="./profile.php?id=<?php echo $info[0]['id'] ?>">
                                <p><?php echo $info[0]['fullname']; ?></p>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</body>

</html>