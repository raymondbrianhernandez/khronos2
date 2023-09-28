<?php

if ( session_status() !== PHP_SESSION_ACTIVE ) {
    session_start();
}

$congregation = $_SESSION['congregation'];
$publishers   = array();

// Define the roles and their display names
$privileges = array(
    'elder' => '--ELDERS--',
    'servant' => '--SERVANTS--',
    'brother' => '--BROTHERS--',
    'sister' => '--SISTERS--'
);

foreach ($privileges as $privilege => $displayName) {
    // Add the display name for the role
    $publishers[] = " ";
    $publishers[] = $displayName;

    // Query the database for publishers with the current role
    $query = "SELECT first_name, last_name FROM publishers WHERE congregation = '$congregation' AND privilege = '$privilege' ORDER BY first_name ASC;";
    // echo $query;
    
    $result = mysqli_query($con, $query);

    while ( $row = mysqli_fetch_assoc ( $result ) ) {
        $publishers[] = $row['first_name'] . " " . $row['last_name'];
    }
}

