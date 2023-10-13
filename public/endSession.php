<?php

if ( session_status() !== PHP_SESSION_ACTIVE ) {
    session_start();
}

$_SESSION['clockedIn'] = false;

echo json_encode ( ['success' => true] );
