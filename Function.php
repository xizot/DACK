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
	$arr = $db->prepare("SELECT code,fullname From users WHERE email = ? ");
	$arr->execute([$email]);
	$data = $arr->fetchAll();
	if($code == $data[0]['code'])
	{
		$_SESSION['fullname'] = $data[0]['fullname'];

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
	$arr = $db->prepare("SELECT password,fullname,status From users WHERE email = ? ");
	$arr->execute([$email]);
	$data = $arr->fetchAll();
	if(password_verify($password, $data[0]['password']) && $data[0]['status'] == 1)
	{
		$_SESSION['fullname'] = $data[0]['fullname'];
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

	SendEmail('test.160499@gmail.com',$email,'new member','http://1760131.rf.gd/BTN01/active.php?code='.$code,'Active your account');

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
	SendEmail('test.160499@gmail.com',$email,'Member','http://1760131.rf.gd/BTN01/ResetPassword.php?','Reset your account');
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
	header("Location:index.php");
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

function AddStatus($email, $postStatus)
{
	global $db;
	$stmt = $db->prepare("INSERT INTO Post(email,postStatus) VALUES(?,?)");
	$stmt->execute([$email,$postStatus]);
}




function LoadStatus($email)
{
	global $db;
	$stmt = $db->prepare("SELECT * FROM users u, Post p WHERE p.email = u.email and  u.email = ?");
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