<?php

require_once 'Init.php';
require_once 'Function.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="./style/friend.css">
    <title>Document</title>
</head>

<body>
    <?php $data = LoadFriends($_SESSION['id']);
    foreach ($data as $fr) :
        $frID = $fr['id'];
        !empty($fr['fullname']) ? $frName = $fr['fullname'] : $frName = "NEW MEMBER";
        !empty($fr['avt']) ? $frAvt = "./avt.php?id=" . $frID . "&for=avt" : $frAvt = "1.jpg";
        ?>
        <div class="box-friend-content">
            <a href="<?php echo "./profile.php?id=" . $frID ?>"> <img src="<?php echo $frAvt ?>" alt=" "></a>
            <a href="<?php echo "./profile.php?id=" . $frID ?>" class="friend-name"><?php echo $frName ?></a>
        </div>

    <?php endforeach; ?>
</body>

</html>