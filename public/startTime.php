<?php

if ( session_status() == PHP_SESSION_NONE ) {
    session_start();
}

$data = json_decode(file_get_contents("php://input"), true);
$time = $data['time'];

$_SESSION['startTime'] = $time;
$_SESSION['clockedIn'] = true;

// You can also return a response to confirm the session was set.
echo json_encode(['success' => true]);
?>
