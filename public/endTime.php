<?php

if ( session_status() == PHP_SESSION_NONE ) {
    session_start();
}

$data = json_decode ( file_get_contents ( "php://input" ) );
$_SESSION['endTime'] = $data->time;
 