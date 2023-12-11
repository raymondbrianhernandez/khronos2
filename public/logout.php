<?php

if ( session_status() !== PHP_SESSION_ACTIVE ) {
    session_start();
}

// include "debug.php"; 
include "../private/db_config.php";

// Check if user id is set in the session
if ( isset ( $_SESSION['id'] ) ) {
    $id = $_SESSION['id'];
    
    // Delete user session
    if ( $con->query ( "DELETE FROM user_sessions WHERE user_id = '$id'" ) === TRUE ) {
        echo "Record deleted successfully";
    } else {
        echo "Error deleting record: " . $con->error;
    }
    
    // Destroy PHP session
    session_destroy();

    // Remove JWT token cookie
    setcookie("auth_token", "", [
        'expires' => time() - 3600, // Past time to expire the cookie
        'path' => '/',
        'domain' => '.khronos.pro', // Same domain as when the cookie was set
        'secure' => true, // Same as when the cookie was set
        'httponly' => true, // Same as when the cookie was set
        'samesite' => 'None' // Same as when the cookie was set
    ]);
    
} else {
    echo "User ID not found in session";
}

header ( "Location: ../index.php" );
exit();

?>