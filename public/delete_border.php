<?php

if ( session_status() == PHP_SESSION_NONE ) {
    session_start();
}

// Check if data is received
if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
    $data = json_decode ( file_get_contents ( 'php://input' ), true );
    $borderName = $data['border_name'];
    $congregation = $data['congregation'];

    // Ensure that the congregation matches the session's congregation for security purposes
    if ( $congregation !== $_SESSION['congregation'] ) {
        echo 'Congregation name mismatch.  Please log out and log back in';
        exit;
    }

    if ( $stmt = $con->prepare ( "DELETE FROM borders WHERE border_name = ? AND congregation = ?" ) ) {
        $stmt->bind_param ( "ss", $borderName, $congregation ); 

        if ( $stmt->execute() ) {
            echo 'success';
        } else {
            echo 'Database error: Failed to delete border.';
        }
        $stmt->close();
    } else {
        echo 'Database error: Failed to prepare the SQL statement.';
    }
    $con->close();
} else {
    http_response_code ( 405 ); // Method Not Allowed
}
?>
