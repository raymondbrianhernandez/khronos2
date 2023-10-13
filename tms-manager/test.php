<?php

// Start the session
if ( session_status() !== PHP_SESSION_ACTIVE ) {
     session_start();
}

// Print all session variables
echo "<h2>Session Variables:</h2>";
echo "<pre>";
foreach ( $_SESSION as $key => $value ) {
    echo "<h2>$key => $value<h2>";
}
echo "</pre>";

?>
