<?php 
require 'C:\xampp\htdocs\halipa\PHPMailer-master\src\PHPMailer.php';
require 'C:\xampp\htdocs\halipa\PHPMailer-master\src\SMTP.php';
require 'C:\xampp\htdocs\halipa\PHPMailer-master\src\Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);
$mail->isSMTP();
$mail->Host = 'smtp.gmail.com';
$mail->Port = 587;
$mail->SMTPAuth = true;
$mail->Username = 'lagrosaedrian06@gmail.com';
$mail->Password = 'Gwapoako123';
$mail->SMTPSecure = 'tls'; //

$mail->setFrom('lagrosaedrian06@gmail.com', 'Your Name');
$mail->addAddress('recipient@example.com', 'Recipient Name');
$mail->Subject = 'Test Email';
$mail->Body = 'This is a test email sent using PHPMailer.';

if (!$mail->send()) {
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'Email sent successfully!';
}


?>