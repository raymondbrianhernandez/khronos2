<?php

if ( session_status() !== PHP_SESSION_ACTIVE ) {
    session_start();
}

include "../private/db_config.php";

$id = $_SESSION['id'];
$con->query ( "DELETE FROM user_sessions WHERE user_id = '$id'" );
session_destroy();
header( "Location: ../index" );
exit();

?>
