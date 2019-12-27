<?php
### THIS IS ALL FUNCTION USING FOR TEST
require_once 'Connect.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'phpmailer/vendor/autoload.php';

// Instantiation and passing `true` enables exceptions
//SendEmail('test.160499@gmail.com','nvnhat.17ck1@gmail.com','Hau','Hello','Active your account');
function addMessageNotification($from,$id)
{
	$sql = " INSERT INTO notify(postID,userID,byID,type) VALUES(0,?,?,2)";
	global $db;
	$stmt = $db->prepare($sql);
	$stmt->execute([$id,$from]);
}

function removeAllMessageNotify($id)
{
	$sql = "DELETE FROM notify where userID = ? and type = 2";
	global $db;
	$stmt = $db->prepare($sql);
	$stmt->execute([$id]);
}

function countMessageNotify($id)
{
	$sql = "SELECT * FROM notify WHERE userID = ? and type = 2";
	global $db;
	$stmt = $db->prepare($sql);
	$stmt->execute([$id]);
	$data = $stmt->fetchAll();
	return count($data);
}

function deleteAllMessage($fromId, $toID)
{
	$sql = 	"Update messages set deleteby = ? WHERE ((user_1 = ? and user_2 = ?) or(user_1 = ? and user_2 = ?)) and deleteBy = 0";
	global $db;
	$stmt = $db->prepare($sql);
	$stmt->execute([$fromId, $fromId, $toID, $toID, $fromId]);


	$sql_Delete = "DELETE FROM messages where ((user_1 = ? and user_2 = ?) or(user_1 = ? and user_2 = ?)) and deleteBy = ?";
	$stmt = $db->prepare($sql_Delete);
	$stmt->execute([$fromId, $toID, $toID, $fromId, $toID]);
}


function deleteMessage($fromID, $msgID)
{

	$sql = 	"SELECT * FROM messages WHERE id =? and deleteBy != 0";
	global $db;
	$stmt = $db->prepare($sql);
	$stmt->execute([$msgID]);
	$data = $stmt->fetchAll();

	if (count($data) >= 1) {
		$sql = "DELETE FROM messages where id = ?";
		$stmt = $db->prepare($sql);
		$stmt->execute([$msgID]);
	} else {
		echo "123123";
		$sql = "UPDATE messages SET deleteBy = ? where id = ?";
		$stmt = $db->prepare($sql);
		$stmt->execute([$fromID, $msgID]);
	}
}


function removeNotifications($postID, $byId, $type)
{
	$sql = "DELETE FROM notify where postID = ? and byID =? and type = ?";
	global $db;
	$stmt = $db->prepare($sql);
	$stmt->execute([$postID, $byId, $type]);
}
function seenNotifications($postID, $byId, $type)
{
	$sql = "UPDATE notify SET seen = 1  where postID = ? and byID =? and type = ?";
	global $db;
	$stmt = $db->prepare($sql);
	$stmt->execute([$postID, $byId, $type]);
}

function getNotifications($id)
{
	$sql = "SELECT * from notify where userID =? and userID != byID group by postID, byID,type order by createAt DESC ";
	global $db;
	$stmt = $db->prepare($sql);
	$stmt->execute([$id]);
	$data = $stmt->fetchAll();
	return $data;
}

function addNotifications($from, $to, $postID, $type)
{
	$sql = " INSERT INTO notify(postID,userID,byID,type) VALUES(?,?,?,?)";
	global $db;
	$stmt = $db->prepare($sql);
	$stmt->execute([$postID, $to, $from, $type]);
}

function countNotifications($id)
{
	$sql = "SELECT * from notify where userID =? and seen = 0 and userID != byID";
	global $db;
	$stmt = $db->prepare($sql);
	$stmt->execute([$id]);
	$data = $stmt->fetchAll();
	return count($data);
}

function countPage($id, $limit, $for)
{

	if ($for == "index") {
		$sql = "SELECT distinct p.id, p.createAt, p.postTime, p.postStatus, p.privacy FROM post p, friends f where p.createAt =$id or( p.createAt = f.user_2  and f.user_1 = ? and f.follow = 1 and p.privacy = 2)  order by p.postTime DESC";
		global $db;
		$stmt = $db->prepare($sql);
		$stmt->execute([$id]);
		$data = $stmt->fetchAll();
	} else if ($for == "profile") {
		$data = GetPostByCreateID($id);
	}

	$numPost = count($data);

	$lastpage = $numPost % $limit > 0 ? 1 : 0;
	return ((int) ($numPost / $limit) + $lastpage);
}

function setPrivacy($postID, $privacy)
{
	$sql = "UPDATE post SET privacy = ? WHERE id = ?";
	global $db;
	$stmt = $db->prepare($sql);
	$stmt->execute([$privacy, $postID]);
}


function SendMessage($from, $to, $content)
{
	$sql = " INSERT INTO messages(user_1,user_2,message) VALUES(?,?,?)";
	global $db;
	$stmt = $db->prepare($sql);
	$stmt->execute([$from, $to, $content]);
}


function GetLastMessage($id)
{
	$sql = "select * from messages where id = ?";
	global $db;
	$stmt = $db->prepare($sql);
	$stmt->execute([$id]);
	$data = $stmt->fetch();
	return $data;
}

function GetAllMessage($from)
{
	$sql = "SELECT user_2,id FROM `messages` WHERE user_1 =? and deleteBy != ?  group by user_2,id order by createAt DESC";
	global $db;
	$stmt = $db->prepare($sql);
	$stmt->execute([$from, $from]);
	$data1 = $stmt->fetchAll();


	$sql = "SELECT user_1,id FROM `messages` WHERE user_2 =? and deleteBy != ? group by user_1,id order by createAt DESC";
	$stmt = $db->prepare($sql);
	$stmt->execute([$from, $from]);
	$data2 = $stmt->fetchAll();

	$rs = array();
	foreach ($data1 as $d1) {
		array_push($rs, $d1);
	}
	foreach ($data2 as $d2) {
		array_push($rs, $d2);
	}


	//sort

	for ($i = 0; $i < count($rs) - 1; $i++) {
		for ($j = $i + 1; $j < count($rs); $j++) {
			if ($rs[$i]['id'] < $rs[$j]['id']) {
				$temp = $rs[$i];
				$rs[$i] = $rs[$j];
				$rs[$j] = $temp;
			}
		}
	}
	//remove duplication

	$n = count($rs);
	$m = count($rs);

	for ($i = 0; $i < $n - 1; $i++) {
		for ($j = $i + 1; $j < $m; $j++) {
			if ($rs[$i][0] == $rs[$j][0]) {
				unset($rs[$j]);
			}
		}
	}
	return $rs;
}

function GetMessage($fromID, $toID)
{
	$sql = "select * from messages where ((user_1 = ? and user_2 =?) or ( user_1 = ? and user_2 =?)) and (deleteBy != ?) order by createAt ASC";
	global $db;
	$stmt = $db->prepare($sql);
	$stmt->execute([$fromID, $toID, $toID, $fromID, $fromID]);
	$data = $stmt->fetchAll();
	return $data;
}

function countCommentByPostID($postID)
{
	$sql = "select * from comments where postID = ?";
	global $db;
	$stmt = $db->prepare($sql);
	$stmt->execute([$postID]);
	$data = $stmt->fetchAll();
	return count($data);
}

function sendComment($postID, $userID, $status)
{
	$sql = " INSERT INTO comments(postID,userID,cmtText) VALUES(?,?,?)";
	global $db;
	$stmt = $db->prepare($sql);
	$stmt->execute([$postID, $userID, $status]);
}

function checkLike($id, $postID)
{
	$sql = "select * from likes where userID = ? and postID = ?";
	global $db;
	$stmt = $db->prepare($sql);
	$stmt->execute([$id, $postID]);
	$data = $stmt->fetchAll();
	if (count($data) > 0)
		return true;
	else
		return false;
}


function GetCommentByPostID($postID)
{
	$sql = "select * from comments where postID = ?";
	global $db;
	$stmt = $db->prepare($sql);
	$stmt->execute([$postID]);
	$data = $stmt->fetchAll();
	return $data;
}

function DeletePostByID($id)
{
	$sql = "DELETE FROM post WHERE id = ?";
	global $db;
	$stmt = $db->prepare($sql);
	$stmt->execute([$id]);
}

function LoadAllFriendPost($id, $limit, $pagenum)
{
	$sql = "SELECT distinct p.id, p.createAt, p.postTime, p.postStatus, p.privacy FROM post p, friends f where p.createAt =$id or( p.createAt = f.user_2  and f.user_1 = ? and ((f.follow = 1 and p.privacy =2) or(f.friend =1 and p.privacy !=0)))  order by p.postTime DESC LIMIT " . $limit . " OFFSET " . $limit * ($pagenum - 1);
	global $db;
	$stmt = $db->prepare($sql);
	$stmt->execute([$id]);
	$data = $stmt->fetchAll();
	if (count($data) <= 0) {
		$data = GetPostByCreateID($id);
	}
	return $data;
}

function UnLike($postID, $ID)
{
	$sql = "DELETE FROM likes WHERE postID =? and userID=?";
	global $db;
	$stmt = $db->prepare($sql);
	$stmt->execute([$postID, $ID]);
}
function Like($postID, $ID)
{
	$sql = " INSERT INTO likes(postID,userID) VALUES(?,?)";
	global $db;
	$stmt = $db->prepare($sql);
	$stmt->execute([$postID, $ID]);
}

function GetPostLike($postID)
{
	$sql = "select * from likes where postID = ?";
	global $db;
	$stmt = $db->prepare($sql);
	$stmt->execute([$postID]);
	$data = $stmt->fetchAll();
	return count($data);
}

function LoadPostByID($id)
{
	$sql = "SELECT distinct * from post where id = ? order by postTime DESC";
	global $db;
	$stmt = $db->prepare($sql);
	$stmt->execute([$id]);
	$data = $stmt->fetchAll();
	return $data;
}


function SendRequest($id1, $id2)
{
	$sql = " INSERT INTO friends(user_1,user_2,follow) VALUES(?,?,?)";
	global $db;
	$stmt = $db->prepare($sql);
	$stmt->execute([$id1, $id2, 1]);
}

function AcceptFriends($from, $to)
{
	$sql = "UPDATE friends SET friend = 1 where (user_1= ? and user_2 = ?) or (user_1 =? and user_2 = ?)";
	global $db;
	$stmt = $db->prepare($sql);
	$stmt->execute([$from, $to, $to, $from]);

	$sql2 = "INSERT INTO friends(user_1,user_2,follow,friend) Values(?,?,?,?)";
	$stmt = $db->prepare($sql2);
	$stmt->execute([$from, $to, 1, 1]);
}


function RequestFriends($id)
{
	$sql = "select * from friends where user_2 = ? and friend = 0";
	global $db;
	$stmt = $db->prepare($sql);
	$stmt->execute([$id]);
	$data = $stmt->fetchAll();
	return $data;
}

function countRequestFriends($id)
{
	$sql = "select * from friends where user_2 = ? and friend = 0";
	global $db;
	$stmt = $db->prepare($sql);
	$stmt->execute([$id]);
	$data = $stmt->fetchAll();
	return count($data);
}


function removeFriends($from, $to)
{
	$sql = "DELETE FROM friends WHERE (user_1 = ? and user_2=?) or (user_1 = ? and user_2=?)";
	global $db;
	$stmt = $db->prepare($sql);
	$stmt->execute([$from, $to, $to, $from]);
}

function resizeImage($filename, $max_width, $max_height)
{
	list($orig_width, $orig_height) = getimagesize($filename);

	$width = $orig_width;
	$height = $orig_height;

	# taller
	if ($height > $max_height) {
		$width = ($max_height / $height) * $width;
		$height = $max_height;
	}

	# wider
	if ($width > $max_width) {
		$height = ($max_width / $width) * $height;
		$width = $max_width;
	}

	$image_p = imagecreatetruecolor($width, $height);

	$image = imagecreatefromjpeg($filename);

	imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $orig_width, $orig_height);

	return $image_p;
}


function isFollow($id1, $id2)
{
	$sql = "select * from friends where user_1 = ? and user_2 = ? and friend = 0 and follow = 1";
	global $db;
	$stmt = $db->prepare($sql);
	$stmt->execute([$id1, $id2]);
	$data = $stmt->fetchAll();

	if (count($data) > 0)
		return true;
	else
		return false;
}
function isFollow2($id1, $id2)
{
	$sql = "select * from friends where user_1 = ? and user_2 = ? and follow = 1";
	global $db;
	$stmt = $db->prepare($sql);
	$stmt->execute([$id1, $id2]);
	$data = $stmt->fetchAll();

	if (count($data) > 0)
		return true;
	else
		return false;
}


function unFollow($id1, $id2)
{
	$sql = "UPDATE friends SET follow = 0 WHERE user_1 =? and user_2 = ?";
	global $db;
	$stmt = $db->prepare($sql);
	$stmt->execute([$id1, $id2]);
	$data = $stmt->fetchAll();
}
function Follow($id1, $id2)
{
	$sql = "UPDATE friends SET follow = 1 WHERE user_1 =? and user_2 = ?";
	global $db;
	$stmt = $db->prepare($sql);
	$stmt->execute([$id1, $id2]);
	$data = $stmt->fetchAll();
}
function isFriend($id1, $id2)
{
	$sql = "select * from friends where user_1 = ? and user_2 = ?  and friend = 1";
	global $db;
	$stmt = $db->prepare($sql);
	$stmt->execute([$id1, $id2]);
	$data = $stmt->fetchAll();

	if (count($data) > 0)
		return true;
	else
		return false;
}

function Search($person)
{
	$data = SearchPersonByName($person);
	if (count($data) <= 0) {
		$data = SearchPersonByID($person);
	}
	if (count($data) <= 0) {
		$data = SearchPersonByEmail($person);
	}

	return $data;
}

function SearchPersonByName($name)
{
	$sql = "select * from users where fullname = ?";
	global $db;
	$stmt = $db->prepare($sql);
	$stmt->execute([$name]);
	$data = $stmt->fetchAll();
	return $data;
}

function SearchPersonByID($id)
{
	$sql = "select * from users where id = ?";
	global $db;
	$stmt = $db->prepare($sql);
	$stmt->execute([$id]);
	$data = $stmt->fetchAll();
	return $data;
}

function SearchPersonByEmail($email)
{

	$sql = "select * from users where email = ?";
	global $db;
	$stmt = $db->prepare($sql);
	$stmt->execute([$email]);
	$data = $stmt->fetchAll();

	return $data;
}

function GetFollower($id1, $id2)
{
	$sql = "SELECT * FROM friends WHERE (user_1 = ? and user_2= ?)  or(user_1 = ? and user_2= ? )";
	global $db;
	$stmt = $db->prepare($sql);
	$stmt->execute([$id1, $id2, $id2, $id1]);
	$data = $stmt->fetchAll();
	return $data;
}

function LoadFriends($id)
{
	$sql = "SELECT * FROM friends f, users u WHERE f.user_1 = ? and u.id = f.user_2 and friend = 1";
	global $db;
	$stmt = $db->prepare($sql);
	$stmt->execute([$id]);
	$data = $stmt->fetchAll();
	return $data;
}

function Follower($from, $to)
{
	$sql = "INSERT INTO friends(user_1,user_2,follow) VALUES(?,?,?)";
	global $db;
	$stmt = $db->prepare($sql);
	$stmt->execute([$from, $to, 1]);
}


function GetPostByEmail($email)
{
	$sql = "select * from post where email = ? order by postTime DESC";
	global $db;
	$stmt = $db->prepare($sql);
	$stmt->execute([$email]);
	$data = $stmt->fetchAll();
	return $data;
}

function GetPostByID($id)
{
	$sql = "select * from post where id = ? order by postTime DESC";
	global $db;
	$stmt = $db->prepare($sql);
	$stmt->execute([$id]);
	$data = $stmt->fetchAll();
	return $data;
}


function GetPostByCreateID($id)
{

	$sql = "select * from post where createAt = ? order by postTime DESC";
	if ($_SESSION['id'] != $id) {
		$sql = "select * from post where createAt = ? and privacy != 0 order by postTime DESC";
	}


	global $db;
	$stmt = $db->prepare($sql);
	$stmt->execute([$id]);
	$data = $stmt->fetchAll();
	return $data;
}
function GetPostByCreateIDPagination($id, $limit, $pagenum)
{

	$sql = "select * from post where createAt = ? order by postTime DESC LIMIT " . $limit . " OFFSET " . $limit * ($pagenum - 1);
	if ($_SESSION['id'] != $id) {
		$sessID = $_SESSION['id'];
		if (isFriend($sessID, $id))
			$sql = "select * from post where createAt = ? and privacy != 0 order by postTime DESC LIMIT " . $limit . " OFFSET " . $limit * ($pagenum - 1);
		else
			$sql = "select * from post where createAt = ? and privacy = 2 order by postTime DESC LIMIT " . $limit . " OFFSET " . $limit * ($pagenum - 1);
	}


	global $db;
	$stmt = $db->prepare($sql);
	$stmt->execute([$id]);
	$data = $stmt->fetchAll();
	return $data;
}

function  GetProfileByID($id)
{
	$sql = "select * from users where id = ?";
	global $db;
	$stmt = $db->prepare($sql);
	$stmt->execute([$id]);
	$data = $stmt->fetchAll();
	return $data;
}

function GetProfileByEmail($email)
{
	$sql = "select * from users where email = ?";
	global $db;
	$stmt = $db->prepare($sql);
	$stmt->execute([$email]);
	$data = $stmt->fetchAll();
	return $data;
}




function SendEmail($from, $to, $name, $content, $title)
{

	$mail = new PHPMailer(true);

	//Server settings          
	$mail->isSMTP();                                            // Send using SMTP
	$mail->Host       = 'smtp.gmail.com';
	$mail->CharSet    = 'UTF-8';
	$mail->SMTPAuth   = true;                                   // Enable SMTP authentication
	$mail->Username   = 'test.160499@gmail.com';                     // SMTP username
	$mail->Password   = 'learnenglish';                               // SMTP password
	$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
	$mail->Port       = 587;                                    // TCP port to connect to

	//Recipients
	$mail->setFrom($from, 'admin');
	$mail->addAddress($to, $name);     // Add a recipient

	// Content
	$mail->isHTML(true);                                  // Set email format to HTML
	$mail->Subject = $title;
	$mail->Body    = $content;


	$mail->send();
}


function Active($email, $code)
{
	//Check empty
	if (empty($email) || empty($code)) {
		return 0;
	}
	//verify password
	global $db;
	$arr = $db->prepare("SELECT * From users WHERE email = ? ");
	$arr->execute([$email]);
	$data = $arr->fetchAll();
	if ($code == $data[0]['code']) {
		$_SESSION['fullname'] = $data[0]['fullname'];
		$_SESSION['id'] = $data[0]['id'];

		global $db;
		$sql = "UPDATE users SET status = ? WHERE email =?";
		$stmt = $db->prepare($sql);
		$stmt->execute(['1', $email]);

		//success
		return 1;
	}
	#Fail
	return -1;
}



function Login($email, $password) #Đăng nhập
{
	//Check empty
	if (empty($email) || empty($password)) {
		return 0;
	}
	//verify password
	global $db;
	$arr = $db->prepare("SELECT * From users WHERE email = ? ");
	$arr->execute([$email]);
	$data = $arr->fetchAll();

	if (count($data) <= 0) {
		return -3;
	}


	if (password_verify($password, $data[0]['password']) && $data[0]['status'] == 1) {
		$_SESSION['fullname'] = $data[0]['fullname'];
		$_SESSION['id'] = $data[0]['id'];
		//success
		return 1;
	} else if (password_verify($password, $data[0]['password']) && $data[0]['status'] == 0) {
		return 2;
	}
	#Fail
	return -1;
}

function Register($email, $password) #Đăng Kí
{
	#Check empty
	if (empty($email) || empty($password)) {
		return 0;
	}
	#Check already
	global $db;

	$arr = $db->query("SELECT email FROM users");
	while ($row = $arr->fetch(PDO::FETCH_ASSOC)) {
		if ($row['email'] == $email) {
			return -1;
		}
	}

	$code = rand(100000, 999999);
	#Add new user to database
	$stmt = $db->prepare("INSERT INTO users(email,password,code,status) VALUES(?,?,?,?)");
	$stmt->execute([$email, $password, $code, '0']);

	SendEmail('test.160499@gmail.com', $email, 'new member', 'http://1760131.rf.gd/DACK/Active.php?code=' . $code, 'Active your account');

	return 1;
}


function Forget($email)
{

	$sql = "SELECT * FROM users WHERE email = ?";
	global $db;
	$stmt = $db->prepare($sql);
	$stmt->execute([$email]);
	$data = $stmt->fetchAll();
	if (count($data) <= 0) {
		return -1;
	}
	SendEmail('test.160499@gmail.com', $email, 'Member', 'http://1760131.rf.gd/DACK/ResetPassword.php?', 'Reset your account');
	return 1;
}

function ChangePassword($email, $oldPass, $newPass) #Đổi Mật Khẩu
{
	#Check empty
	if (empty($email) || empty($oldPass) || empty($newPass)) {
		return 0;
	}
	#Check login and change password when login success
	if (Login($email, $oldPass) == 1) {
		#Check repeat
		if ($oldPass == $newPass) {
			return -1;
		} else {
			global $db;
			$hash = password_hash($newPass, PASSWORD_DEFAULT);
			$stmt = $db->prepare("UPDATE users SET password  = ? WHERE email = ?");
			$stmt->execute([$hash, $email]);
			return 1;
		}
	} else {
		return -2; // login failed
	}
}

function Logout()
{
	session_unset();
	header("Location:Login.php");
	exit();
}


function ResetPassword($email, $password)
{
	if (empty($password)) {
		return 0;
	}
	global $db;

	$sql_exists = "SELECT * from users WHERE email = ?";
	$stmt = $db->prepare($sql_exists);
	$stmt->execute([$email]);
	$arr = $stmt->fetchAll();

	if (count($arr) <= 0) {
		return -1;
	} else {
		$hash = password_hash($password, PASSWORD_DEFAULT);
		$sql = "UPDATE users set password =? where email =?";
		$stmt = $db->prepare($sql);
		$stmt->execute([$hash, $email]);
		return 1;
	}
}


function ConvertIMG($image)
{
	$avt = $image;
	$avtName = $avt['name'];

	$avtTmp = $avt['tmp_name'];
	$newAvt = resizeImage($avtTmp, 937, 937);
	ob_start();
	imagejpeg($newAvt);
	$avatar = ob_get_contents();
	ob_end_clean();
	return $avatar;
}

function AddStatus($id, $email, $postStatus, $img)
{
	global $db;
	$stmt = $db->prepare("INSERT INTO post(createAt,email,postStatus,imgPost) VALUES(?,?,?,?)");
	$stmt->execute([$id, $email, $postStatus, $img]);
}




// function LoadStatus($email)
// {
// 	global $db;
// 	$stmt = $db->prepare("SELECT * FROM users u, Post p WHERE p.email = u.email and  u.email = ?");
// 	$stmt->execute([$email]);
// 	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
// 		echo '<div class="col">';
// 		echo '<a href="UpdateProfile.php class="name"><img src="uploads/'.$row['imgProfile'].'" alt=" ">'.$row['fullname'] .'</a>';
// 		echo '<p class="time">Đăng lúc: '.$row['postTime'].'</p>';
// 		echo '<p class="status">'.$row['postStatus'].'</p>';
// 		echo '</div>';
// 	}
// }
function LoadStatus($email)
{

	global $db;
	$stmt = $db->prepare("SELECT * FROM users u, post p WHERE p.email = u.email and  u.email = ? Order by p.postTime desc");
	$stmt->execute([$email]);
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		echo '<div class="col">';
		echo '<a href="UpdateProfile.php" class="name"><img src="uploads/' . $row['imgProfile'] . '" alt=" ">' . $row['fullname'] . '</a>';
		echo '<p class="time">Đăng lúc: ' . $row['postTime'] . '</p>';
		echo '<p class="status">' . $row['postStatus'] . '</p>';
		echo '</div>';
	}
}
