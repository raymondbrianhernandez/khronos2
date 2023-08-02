<?php

/* This script resets the time and submits total hours */

require("../private/secure.php");
require_once("../private/db_config.php");
/* include("debug.php"); */

// Saves info from user first
$username = $_SESSION['username'];
// _Using POST instead of _SESSION just in case user changes password  
$password = $_SESSION['password']; 
// logouts user
session_unset(); 

/* logs them again */
session_start();
$sql = "SELECT * 
        FROM logins 
        WHERE username = '$username' and password = '$password'";  
$result = mysqli_query($con, $sql);  
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);   
$_SESSION['owner']          = $row['name'];
$_SESSION['username']       = $row['username'];
$_SESSION['email']          = $row['email'];
$_SESSION['password']       = $row['password'];
$_SESSION['goal']           = $row['goal'];
$_SESSION['elder_name']     = $row['elder_name'];
$_SESSION['elder_email']    = $row['elder_email'];
$_SESSION['elder_phone']    = $row['elder_phone'];
$_SESSION['logged_in']      = TRUE;
$_SESSION['status']         = "Timer not started";
$_SESSION['startTime']      = NULL;
$_SESSION['endTime']        = NULL;
$_SESSION['totalTime']      = 0;
$_SESSION['clockedIn']      = FALSE;
$_SESSION['clockedOut']     = FALSE;

$curr_year = date('Y');
$prev_year = (string)((int)date('Y') - 1);
$currentDate = new DateTime();
$startDate = DateTimeImmutable::createFromFormat('Y-m-d', $prev_year.'-09-01');
$endDate = DateTimeImmutable::createFromFormat('Y-m-d', $curr_year.'-08-31');

$_SESSION['service_year'] = $currentDate >= $startDate && $currentDate <= $endDate ? $curr_year : $_SESSION['service_year'] = $prev_year;

$owner = $_SESSION['owner'];
$date = date('Y-m-d');
$hours = $_SESSION['totalTime'];

?>

<script type = "text/javascript">
    /* alert("Timer has been reset."); */
    window.location = ("hours.php#clock");
</script>