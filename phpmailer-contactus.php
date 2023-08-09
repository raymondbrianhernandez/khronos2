<?php

require("../private/secure.php");
require_once("../private/db_config.php");
include("debug.php");
session_start();

// Get the email of the admin from the POST data.
$to         = $_POST['admin_email'];
$subject    = $_POST['subject'];
$message    = $_POST['message'];

// Sender's details.
$sender_name = $_POST['sender_name'];
$sender_email = $_POST['sender_email'];

// Set the headers to include the sender's email.
$headers = "From: " . $sender_name . " <" . $sender_email . ">\r\n";
$headers .= "Reply-To: " . $sender_email . "\r\n";
$headers .= "X-Mailer: PHP/" . phpversion();

$isMailSent = mail($to, $subject, $message, $headers);
if ($isMailSent) {
?>
    <script type="text/javascript">
        alert("Your message has been sent.");
        window.close();
    </script>
<?php 
} else {
    echo "Email sending failed. Error: " . error_get_last()['message'];
    echo "<br>" . $to; echo "<br>" . $subject; echo "<br>" . $message; echo "<br>" . $sender_name; echo "<br>" . $sender_email;
?>
    <script type="text/javascript">
        alert("There's an error with the mail server. Please contact the admins at raymond@arbhie.com or carla@appsbycarla.com.");
        window.close();
    </script>
<?php
}

?>