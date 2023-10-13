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

mysqli_query ( $tmscon, $query );
mysqli_close ( $tmscon );
header ( "Location: publishers" );

?>
