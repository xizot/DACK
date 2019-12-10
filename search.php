<?php

require_once("Init.php");
require_once("Function.php");
require_once("Header.php");

$data_search = Search($_GET['q']);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="request.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>

<body>
    <div class="row">
        <div class="col-md-10">
            <div class="box-request">

                <form action="" method="GET" role="form">
                    <center>
                        <legend>Tìm kiếm</legend>
                    </center>

                    <div class="form-group">
                        <input type="text" class="form-control" id="" name="q" placeholder="Nhập vào tên, id hoặc email để tìm">
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>

                <?php
                if (!empty($data_search))
                    foreach ($data_search as $vl) :
                        $sr_Name = $vl['fullname'];
                        $sr_ID = $vl['id'];
                        $sr_Avt = "avt.php?id=" . $sr_ID . "&for=avt";
                        if (empty($vl['avt'])) {
                            $sr_Avt = "1.jpg";
                        }
                        ?>
                    <div class="box-search">
                        <div class="content">
                            <div class="info">
                                <a href="./profile.php?id=<?php echo $sr_ID ?>" alt=""><img src="<?php echo $sr_Avt ?>" alt=""></a>
                                <a href="./profile.php?id=<?php echo $sr_ID ?>" class="name"><?php echo $sr_Name ?></a>
                                <!-- <a href="./confirm.php?from=<?php echo $_SESSION['id'] . "&to=" . $sr_ID . "&for=act" ?>" class="accept">Confirm</a> -->
                                <?php if (isFollow($_SESSION['id'], $sr_ID) || isFollow($sr_ID,$_SESSION['id'])) : ?>
                                    <a href="./confirm.php?from=<?php echo $_SESSION['id']."&to=".$sr_ID."&for=del" ?>" class="accept">Delete Request</a>
                                <?php elseif (!isFriend($_SESSION['id'], $sr_ID) && $sr_ID != $_SESSION['id']) : ?>
                                    <a href="./follow.php?<?php echo "from=" . $_SESSION['id'] . "&to=" . $sr_ID ?>" class="accept">Add friend</a>
                                <?php endif; ?>
                            </div>
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