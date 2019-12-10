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


function LoadAllFriendPost($id)
{
    $sql = "SELECT distinct * FROM post p, friends f where p.id = f.user_1 or p.id = f.user_2 and p.id = ? order by p.postTime DESC";
    global $db;
	$stmt = $db->prepare($sql);
	$stmt->execute([$id]);
	$data = $stmt->fetchAll();
	return $data;
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

function AcceptFriends($from, $to)
{
	print($from);
	print($to);
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

function isFriend($id1, $id2)
{
	$sql = "select * from friends where user_1 = ? and user_2 = ? and friend = 1";
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
	$stmt = $db->prepare($email);
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
	$sql = "SELECT * FROM friends WHERE user_1 = ? and friend = 1";
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
	$sql = "select * from post where email = ?";
	global $db;
	$stmt = $db->prepare($sql);
	$stmt->execute([$email]);
	$data = $stmt->fetchAll();
	return $data;
}

function GetProfileByID($id)
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




function SendEmail($from, $to, $name,$content, $title)
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
	if(empty($email) || empty($code))
	{
		return 0;
	}
	//verify password
	global $db;
	$arr = $db->prepare("SELECT * From users WHERE email = ? ");
	$arr->execute([$email]);
	$data = $arr->fetchAll();
	if($code == $data[0]['code'])
	{
		$_SESSION['fullname'] = $data[0]['fullname'];
        $_SESSION['id']= $data[0]['id'];

		global $db;
		$sql = "UPDATE users SET status = ? WHERE email =?";
		$stmt = $db->prepare($sql);
		$stmt->execute(['1',$email]);

		//success
		return 1;
	}
	#Fail
	return -1;
}

function Login($email, $password) #Đăng nhập
{
	//Check empty
	if(empty($email) || empty($password))
	{
		return 0;
	}
	//verify password
	global $db;
	$arr = $db->prepare("SELECT * From users WHERE email = ? ");
	$arr->execute([$email]);
	$data = $arr->fetchAll();
	if(password_verify($password, $data[0]['password']) && $data[0]['status'] == 1)
	{
		$_SESSION['fullname'] = $data[0]['fullname'];
		$_SESSION['id'] = $data[0]['id'];
		//success
		return 1;
	}
	else if(password_verify($password, $data[0]['password']) && $data[0]['status'] == 0)
	{
		return 2;
	}
	#Fail
	return -1;
}

function Register($email, $password) #Đăng Kí
{
	#Check empty
	if(empty($email) || empty($password))
	{
		return 0;
	}
	#Check already
	global $db;

	$arr = $db->query("SELECT email FROM users");
	while ($row = $arr->fetch(PDO::FETCH_ASSOC)) {
		if($row['email'] == $email)
		{
			return -1; 
		}
	}

	$code = rand(100000,999999);
	#Add new user to database
	$stmt = $db->prepare("INSERT INTO users(email,password,code,status) VALUES(?,?,?,?)");
	$stmt -> execute([$email,$password,$code,'0']);

	SendEmail('test.160499@gmail.com',$email,'new member','http://1760131.rf.gd/BTN02/active.php?code='.$code,'Active your account');

	return 1;
}


function Forget($email)
{

	$sql = "SELECT * FROM users WHERE email = ?";
	global $db;
	$stmt = $db->prepare($sql);
	$stmt->execute([$email]);
	$data = $stmt->fetchAll();
	if(count($data) <= 0)
	{
		return -1;
	}
	SendEmail('test.160499@gmail.com',$email,'Member','http://1760131.rf.gd/BTCN08/ResetPassword.php?','Reset your account');
	return 1;

}

function ChangePassword($email,$oldPass, $newPass) #Đổi Mật Khẩu
{
	#Check empty
	if(empty($email)||empty($oldPass)||empty($newPass))
	{
		return 0;
	}
	#Check login and change password when login success
	if(Login($email,$oldPass) == 1)
	{
		#Check repeat
		if($oldPass == $newPass)
		{
			return -1; 
		}
		else
		{
			global $db;
			$hash = password_hash($newPass, PASSWORD_DEFAULT);
			$stmt= $db -> prepare("UPDATE users SET password  = ? WHERE email = ?");
			$stmt ->execute([$hash,$email]);
			return 1;
		}

	}
	else
	{
		return -2; // login failed
	}
}

function Logout()
{
	session_unset();
	header("Location:Login.php");
	exit();
}


function ResetPassword($email,$password)
{
	if(empty($password))
	{
		return 0;
	}
	global $db;

	$sql_exists = "SELECT * from users WHERE email = ?";
	$stmt = $db->prepare($sql_exists);
	$stmt -> execute([$email]);
	$arr = $stmt ->fetchAll();
	
	if(count($arr) <= 0)
	{
		return -1;
	}
	else
	{
		$hash = password_hash($password, PASSWORD_DEFAULT);
		$sql ="UPDATE users set password =? where email =?";
		$stmt = $db->prepare($sql);
		$stmt -> execute([$hash,$email]);
		return 1;
	}
}

function AddStatus($id, $email, $postStatus)
{
	global $db;
	$stmt = $db->prepare("INSERT INTO post(id,email,postStatus) VALUES(?,?,?)");
	$stmt->execute([$id,$email,$postStatus]);
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
		echo '<a href="UpdateProfile.php" class="name"><img src="uploads/'.$row['imgProfile'].'" alt=" ">'.$row['fullname'] .'</a>';
		echo '<p class="time">Đăng lúc: '.$row['postTime'].'</p>';
		echo '<p class="status">'.$row['postStatus'].'</p>';
		echo '</div>';
	}
}

?>