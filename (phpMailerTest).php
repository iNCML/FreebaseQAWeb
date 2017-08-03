<?php
require '/usr/share/php/libphp-phpmailer/PHPMailerAutoload.php';
function sendMail($body,$email)
{
  $mail = new PHPMailer;
  $mail->IsSMTP();
  $mail->Host = "127.0.0.1";
  $mail->setFrom('NoReply@AutomatedEmail.com', 'Admin');
  $mail->addAddress($email, 'User');
  $mail->Subject  = 'Login Information';
  $mail->Body     = $body;
  if(!$mail->send()) {
    echo 'Message was not sent.';
    echo 'Mailer error: ' . $mail->ErrorInfo;
  } else {
    echo 'Message has been sent.';
  }
}
?>
