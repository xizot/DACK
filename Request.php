<?php
require_once 'Init.php';
require_once 'Function.php';
require_once 'navbar.php';

if (empty($_SESSION['id'])) {
	header("Location:Login.php");
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>REQUEST FRIENDS</title>
    <link rel="stylesheet" href="./style/request.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="./pageloading.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="./js.js"></script>
    <link class="pgcss" rel="stylesheet" href="./pageloading.css">
	<script src="./loading.js"></script>

</head>

<body>
    <div class="boxrequest">
        <div class="row">
            <div class="col-md-10" style="top:70px">
                <div class="boxrequest-content">
                    <?php $requests = RequestFriends($_SESSION['id']);
                    foreach ($requests as $rq) :
                        $rq_Info = GetProfileByID($rq['user_1']);
                        $rqAvt = "avt.php?id=" . $rq_Info[0]['id'] . "&for=avt";
                        if (empty($rq_Info[0]['avt'])) {
                            $rqAvt = "1.jpg";
                        }
                        $rqName = $rq_Info[0]['fullname'];
                        $rqID = $rq_Info[0]['id'];
                        $rqProFile = "profile.php?id=" . $rqID;
                        ?>

                        <div class="content">
                            <div class="info">
                                <a href="<?php echo $rqProFile ?>"><img src="<?php echo $rqAvt ?>" alt=""></a>
                                <a href="<?php echo $rqProFile ?>" class="name"><?php echo $rqName ?></a>
                                <a href="./acceptFriend.php?from=<?php echo $_SESSION['id'] . "&to=" . $rqID  ?>" class="accept"> Confirm</a>
                                <a href="./removefriends.php?from=<?php echo $_SESSION['id'] . "&to=" . $rqID . "&for=req" ?>" class="delete"> Delete Request</a>
                            </div>
                        </div>

                    <?php endforeach; ?>
                </div>
            </div>
            <div class="col-md-2" style="top:70px; background:white">
            <h4><i class="fas fa-users"></i>Friends</h3>
                <div class="box-friend">
                    <?php require './friend.php' ?>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>

    <footer style="position:relative;padding:50px;background-image: radial-gradient( circle farthest-corner at 10% 20%, rgba(0,93,133,1) 0%, rgba(0,181,149,1) 90% );">

			<?php require_once 'footer.php' ?>
		</footer>
</body>

</html>