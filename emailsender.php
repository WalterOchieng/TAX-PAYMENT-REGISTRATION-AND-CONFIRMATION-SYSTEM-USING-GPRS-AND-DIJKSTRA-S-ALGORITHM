<?php


require 'PHPMailer/PHPMailerAutoload.php';


$mail = new PHPMailer(true);
try{


$mail->IsSMTP(true);
//$mail->SMTPDebug = 2;
$mail->From = "walterochieng6950@gmail.com";
$mail->FromName = "Innovative Digital Computers";
$mail->Host = "smtp.gmail.com";
//$mail->Host = "email-smtp.us-east-1.amazonaws.com";
$mail->SMTPSecure= "ssl";
$mail->Port = 465;
$mail->SMTPAuth = true;
$mail->Username = "walterochieng6950@gmail.com";
$mail->Password = "digitaldombo";
$mail->AddAddress("walterochieng6950@gmail.com");
$mail->AddReplyTo("walterochieng6950@gmail.com");
$mail->WordWrap = 50;
$mail->IsHTML(true);
$mail->Subject = 'Notification From B-Tax Systems';
$mail->Body = 'Your password is ';

$mail->Send();

echo  'Password sent to your email';

}catch(Exception $e)
{
echo 'Sorry, we are Unable to send your password. Check your network connection';
echo 'Mail error' . $mail->ErrorInfo;


}

?>