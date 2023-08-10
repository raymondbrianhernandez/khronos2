<?php

require("../private/secure.php");
require_once("../private/db_config.php");
include("debug.php");

$to             = $_POST['admin_email'];
$message        = $_POST['message'];
$sender_name    = $_POST['sender_name'];
$sender_email   = $_POST['sender_email'];
$subject        = $_POST['subject'] . " [Message from " . $sender_email . "]";

// Set the headers to include the sender's email.
$headers = "From: " . $sender_name . " <" . "raymondhernandez@khronos.pro" . ">\r\n";
$headers .= "Reply-To: " . $sender_email . "\r\n";
$headers .= "X-Mailer: PHP/" . phpversion();

$isMailSent = mail($to, $subject, $message, $headers);
if ($isMailSent) {
?>
    <script type="text/javascript">
        alert("Your message has been sent.\n\nTo: <?php echo $to; ?>\nSubject: <?php echo $subject; ?>\nMessage: <?php echo $message; ?>\nSender Name: <?php echo $sender_name; ?>\nSender Email: <?php echo $sender_email; ?>");
        window.location.href = "about.php"; 
    </script>

<?php 
} else {
    echo "Email sending failed. Error: " . error_get_last()['message'];
?>
    <script type="text/javascript">
        alert("There's an error with the mail server. Please contact the admins at raymond@arbhie.com or carla@appsbycarla.com.");
        window.location = "about.php";
    </script>
<?php
}

?>