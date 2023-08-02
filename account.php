<?php

require("../private/secure.php");
require_once("../private/db_config.php");
/* include("debug.php"); */
session_start();

$query  = "UPDATE logins SET ";
$query .= "`password` = '" . $_POST['owner-password'] ."', ";
$query .= "`email` = '" . $_POST['email'] ."', ";
$query .= "`elder_name` = '" . $_POST['elder_name'] ."', ";
$query .= "`elder_email` = '" . $_POST['elder_email'] ."', ";
$query .= "`elder_phone` = '" . $_POST['elder_phone'].$_POST['carrier'] ."', ";
$query .= "`goal` = '" . $_POST['goal'] ."' ";
$query .= "WHERE `name` = '" . $_SESSION['owner'] . "'";
/* echo $query; */
if ($_POST['owner-password'] == $_POST['owner-password2']) {
    $result = mysqli_query($con, $query);

    // Saves info from user first
    $username = $_SESSION['username'];
    // _Using POST instead of _SESSION just in case user changes password  
    $password = $_POST['owner-password']; 
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
    $_SESSION['startTime']      = NULL;
    $_SESSION['startTime']      = 0;

    ?>
    
    <script type = "text/javascript">
        alert("Account settings have been updated.");
        window.location = ("dashboard.php");
    </script>
    
<?php } else { ?>
    <script type = "text/javascript">
        alert("Password doesn't match.");
        
        window.location = "dashboard.php";
    </script>
<?php } ?>