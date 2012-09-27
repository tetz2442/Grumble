<?php 
require_once "Mail.php"; 
$from = "Grumble <no-reply@grumbleonline.com>"; 
$to = "Grumbler <tetz2442@gmail.com>"; 
$subject = "Hi!"; 
$body = "Hi,\n\nHow are you?"; 
$host = "test.grumbleonline.com"; 
$username = "grumble1"; 
$password = "Clayweb2442!!"; 
$headers = array ('From' => $from, 
'To' => $to, 
'Subject' => $subject); 
$smtp = Mail::factory('smtp', 
array ('host' => $host, 
'auth' => true, 
'username' => $username, 
'password' => $password)); 
$mail = $smtp->send($to, $headers, $body); 
if (PEAR::isError($mail)) { 
echo("<p>" . $mail->getMessage() . "</p>"); 
} else { 
echo("<p>Message successfully sent!</p>"); 
} 
?>