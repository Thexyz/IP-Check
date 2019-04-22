<?php 
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

$errors = '';
require_once('config.php');
$myemail = IPConfig::email;

$use_smtp = IPConfig::use_smtp;
$smtp_host = IPConfig::smtp_host;
$smtp_auth = IPConfig::smtp_auth;
$smtp_user = IPConfig::smtp_user;
$smtp_pass = IPConfig::smtp_pass;
$smtp_encryption = IPConfig::smtp_encryption;
$smtp_port = IPConfig::smtp_port;

if( ! empty($_POST['ip_form']) && ! empty($_POST['name']) && ! empty($_POST['email']))
{
  $name = $_POST['name'];
  $email_address = $_POST['email'];
  $message = $_POST['message'];
  if (!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/i", $email_address))
  {
      $errors .= '%0A'.htmlentities("Error: Invalid email address");
  }

  if( empty($errors))
  {
    $proxied_from = ($_POST['ip_forwarded'] == 'N/A') ? '' : " - Proxied From: ".$_POST['ip_forwarded'];
    $to = $myemail;
    $email_subject = "Client IP of $name: ".$_POST['ip']; 
    $email_body = 'Primary: '.$_POST['ip'].
    $proxied_from."\n Name: $name \n ".
    "Email: $email_address\n ------------- \n $message";
    $headers = "From: $email_address\n";
    $headers .= "Reply-To: $email_address";
    if ($use_smtp === "true")
    {
      require 'PHPMailer/PHPMailerAutoload.php';
      $mail = new PHPMailer;
      $mail->isSMTP(); 

      $mail->Host = $smtp_host;
      $mail->Port = $smtp_port;
      if ($smtp_auth === "true")
      {
        $mail->SMTPAuth = true;
        $mail->Username = $smtp_user;
        $mail->Password = $smtp_pass;
      }
      if ($smtp_encryption !== "na")
      {
        $mail->SMTPSecure = $smtp_encryption;
      }

      $mail->setFrom($to);
      $mail->addAddress($to);
      $mail->addReplyTo($to);

      $mail->Subject = $email_subject/* . "(via SMTP)"*/;
      $mail->Body = $email_body;

      if (!$mail->send()) {
        $errors = '%0A'.htmlentities("Error: ".$mail->ErrorInfo);
      }
      else {
        //redirect
        header('Location: ../form_success.php');
        exit;
      }
    }
    else
    {
      mail($to,$email_subject,$email_body,$headers);
      //redirect
      header('Location: ../form_success.php');
      exit;
    }
  }
  $errors = str_replace(array("\r", "\n"), '', $errors);
  $email_address = str_replace(array("\r", "\n"), '', $email_address);
  $name = str_replace(array("\r", "\n"), '', $name);
  //redirect
  header('Location: ../?name='.$name.'&email='.$email_address.'&error='.$errors);
}
