<?php
    require("../private/secure.php");
    require_once("../private/db_config.php");
    /* include("debug.php"); */
    session_start();
    require 'vendor/autoload.php';
    use PHPMailer\PHPMailer\PHPMailer;

    $mail = new PHPMailer;
    $mail->isSMTP();
    $mail->SMTPDebug = 2;
    $mail->Host = 'smtp.titan.email';
    $mail->Port = 587;
    $mail->SMTPAuth = true;
    $mail->Username = 'mailer@appsbycarla.com';
    $mail->Password = 'My$tr0ngPa55w0rd!';
    $mail->setFrom('mailer@appsbycarla.com', $_SESSION['owner']);
    $mail->addReplyTo($_SESSION['email'], $_SESSION['owner']);
    $mail->addAddress($_POST['elder_phone'], $_POST['elder_name']);
    $mail->Subject = 'From: '.$_SESSION['owner'];
    //$mail->msgHTML(file_get_contents('message.html'), __DIR__);
    $mail->Body = $_POST['message'];
    //$mail->addAttachment('attachment.txt');
    if (!$mail->send()) { ?>
        <script type = "text/javascript">
        alert("There's an error with the SMS server.  Please contact the admins.");
        window.location = "hours.php";
        </script>
    <?php
    } else { ?>
        <script type = "text/javascript">
        alert("Your text message has been sent.");
        window.location = "hours.php";
        </script>
        <?php 
        $_SESSION['reported'] = TRUE;    
    }
?>