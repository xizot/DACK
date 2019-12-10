<?php
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'phpmailer/vendor/autoload.php';

// Instantiation and passing `true` enables exceptions
SendEmail('test.160499@gmail.com','nvnhat.17ck1@gmail.com','Hau','Hello','Active your account');

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
    echo 'Message has been sent';

}

