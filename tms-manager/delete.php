<?php

if ( session_status() !== PHP_SESSION_ACTIVE ) {
    session_start();
}

include ( 'db.php' );
include ( 'debug.php' );

$id = $_GET['id'];
$congregation = $_SESSION['congregation'];

$query = "DELETE FROM publishers WHERE id=$id AND congregation='$congregation'";
echo $query;

mysqli_query ( $con, $query );
mysqli_close ( $con );
header ( "Location: publishers" );

?>
