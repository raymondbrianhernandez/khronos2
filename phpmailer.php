<?php

require("../private/secure.php");
require_once("../private/db_config.php");
/* include("debug.php"); */
session_start();

$to         = $_SESSION['elder_email'];
$subject    = $_POST['subject'];
$message    = $_POST['message'];
$headers    = "Service Report from: " . $_SESSION['owner'];

if ( mail ( $to, $subject, $message, $headers ) ) { ?>
    <script type = "text/javascript">
        alert ( "Your report has been sent." );
        window.location = "hours.php";
    </script> <?php
} else { ?>
    <script type = "text/javascript">
        alert ( "There's an error with the mail server. Please contact the admins at raymond@arbhie.com or carla@appsbycarla.com." );
        window.location = "hours.php";
    </script>
    <?php
} 

?>