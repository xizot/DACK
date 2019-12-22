<?php

require_once("Init.php");
require_once("Function.php");
require_once("navbar.php");

$data_search = Search($_GET['q']);


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="./style/request.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link class="pgcss" rel="stylesheet" href="./pageloading.css">
	<script src="./loading.js"></script>

</head>

<body>
    <div class="row" style="margin-top: 70px">
        <div class="col-md-12">
            <?php if (count($data_search) <= 0 && !empty($_GET['q'])): ?>
                
                <div class="alert alert-warning">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <center><strong>Không tìm thấy người dùng nào</strong></center>
                
            <?php endif; ?>
            <div class="box-request">
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
                                <?php if (isFollow($_SESSION['id'], $sr_ID) || isFollow($sr_ID, $_SESSION['id'])) : ?>
                                    <a href="./confirm.php?from=<?php echo $_SESSION['id'] . "&to=" . $sr_ID . "&for=del" ?>" class="accept">Delete Request</a>
                                <?php elseif (!isFriend($_SESSION['id'], $sr_ID) && $sr_ID != $_SESSION['id']) : ?>
                                    <a href="./follow.php?<?php echo "from=" . $_SESSION['id'] . "&to=" . $sr_ID ?>" class="accept">Add friend</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    </div>
</body>

</html>