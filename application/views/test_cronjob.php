<?php
$to = "ahsankhan50@gmail.com";
$from= "info@khybersoft.com";
$subject = 'Testing Cron';
$message = '<h2>Cron is working, remove test cron job now.</h2>';
$headers = "From: $from\n";
$headers .= "MIME-Version: 1.0\n";
$headers .= "Content-type: text/html; charset=iso-8859-1\n";
mail($to,$subject,$message,$headers);
?>