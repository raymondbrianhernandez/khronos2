<?php

if ( session_status() !== PHP_SESSION_ACTIVE ) { 
    session_start(); 
}

if ( isset ( $_POST['latitude'] ) && isset ( $_POST['longitude'] ) ) {
    $_SESSION['centerY'] = $_POST['latitude'];
    $_SESSION['centerX'] = $_POST['longitude'];
}

?>
