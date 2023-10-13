<?php

session_start();

$response = [
    'clockedIn' => isset ( $_SESSION['clockedIn']) ? $_SESSION['clockedIn'] : false,
    'startTime' => isset ( $_SESSION['startTime']) ? $_SESSION['startTime'] : null
];

echo json_encode ( $response );
