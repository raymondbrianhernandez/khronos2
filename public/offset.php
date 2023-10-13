<?php

if ( session_status() !== PHP_SESSION_ACTIVE ) { 
    session_start(); 
}

if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
    // Check if the form has been submitted via POST
    
    // Validate and sanitize the offset value (e.g., prevent malicious input)
    $valid_offsets = ['5', '10', '15', '25', '50', '100', '1000'];
    if ( isset ( $_POST['offset']) && in_array ( $_POST['offset'], $valid_offsets ) ) {
        $_SESSION['offset'] = $_POST['offset']; // Save the offset value to the session
    }
}

// Redirect back to the previous page or any other appropriate action
header ( 'Location: ../public/territories' ); // Replace "previous_page.php" with your desired destination
exit; // Terminate the script

?>
