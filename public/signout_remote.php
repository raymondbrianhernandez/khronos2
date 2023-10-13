<?php // signout_remote.php

if ( session_status() !== PHP_SESSION_ACTIVE ) {
    session_start();
}

include "../private/db_config.php";

// Get user ID from the URL
$userId = isset ( $_GET['user_id'] ) ? intval ( $_GET['user_id'] ) : 0;

if ( $userId ) {
    // Delete all existing sessions for this user from the user_sessions table
    $con->query ( "DELETE FROM user_sessions WHERE user_id = '$userId'" );

    // Optionally, if the current session belongs to the same user, destroy it
    if ( isset ( $_SESSION['user_id']) && $_SESSION['user_id'] == $userId ) {
        session_destroy();
    }

    header ( "Location: ../index.php" ); // Redirect to the home page or login page
    exit();
} else {
    // Handle invalid user ID here, e.g., show an error message or redirect to the home page
    header ( "Location: ../index.php" );
    exit();
}

?>
