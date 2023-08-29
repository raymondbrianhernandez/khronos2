<?php

require("../private/secure.php");
require_once("../private/db_config.php");
include("debug.php");
session_start();

// Use prepared statements to protect against SQL injection
$stmt = $con->prepare ( "UPDATE logins SET 
    email = ?, 
    elder_name = ?, 
    elder_email = ?, 
    elder_phone = ?, 
    carrier = ?,
    goal = ? 
    WHERE name = ?"
);

$stmt->bind_param ( "sssssss", 
    $_POST['email'], 
    $_POST['elder_name'], 
    $_POST['elder_email'], 
    $_POST['elder_phone'],
    $_POST['carrier'], 
    $_POST['goal'], 
    $_SESSION['owner']
);

$stmt->execute();
$stmt->close();

// Update the session variables after the database update
$_SESSION['email']          = $_POST['email'];
$_SESSION['goal']           = $_POST['goal'];
$_SESSION['elder_name']     = $_POST['elder_name'];
$_SESSION['elder_email']    = $_POST['elder_email'];
$_SESSION['elder_phone']    = $_POST['elder_phone'];
$_SESSION['carrier']        = $_POST['carrier'];

echo "<script type='text/javascript'>
          alert('Account settings have been updated.');
          window.location='dashboard.php';
      </script>";

?>