<?php

if ( session_status() !== PHP_SESSION_ACTIVE ) { 
    session_start(); 
}

include '../private/db_config.php';
include '../public/debug.php';

// Get the content of the POST request
$rawData = file_get_contents ( "php://input" );
$data = json_decode ( $rawData, true );

// Save the received polygon data to the session
$_SESSION['border'] = $data;

// Retrieve boundary and markers from posted data
$boundary = isset ( $data['boundary'] ) ? json_encode ( $data['boundary'] ) : null;
$markers = isset ( $data['markers'] ) ? $data['markers'] : [];
$border_name  = isset ( $data['border_name'] ) ? $data['border_name'] : null;
$congregation = $_SESSION['congregation'];

// Prepare the SQL statement
$stmt = $con->prepare ( "INSERT INTO borders (congregation, boundary, border_name) VALUES (?, ?, ?)" );

// Bind the parameters
$stmt->bind_param ( "sss", $congregation, $boundary, $border_name );

// Execute the statement
if ( $stmt->execute() ) {
    echo 'New territory boundary saved.';

    // Get the ID of the newly inserted border
    $polygon_id = $stmt->insert_id;

    // Prepare statement for inserting markers
    $markerStmt = $con->prepare ( "INSERT INTO markers (latitude, longitude, polygon_id, address_ID) VALUES (?, ?, ?, ?)" );

    // Get coordinates of the polygon
    //$polygonCoords = $boundary['geometry']['coordinates'][0];
    $polygonCoords = json_decode ( $boundary, true )['geometry']['coordinates'][0];

    foreach ( $markers as $marker ) {
        $latitude   = $marker['latitude'];
        $longitude  = $marker['longitude'];
        $address_ID = $marker['address_ID'];
        
        if ( isPointInPolygon([$longitude, $latitude], $polygonCoords) ) {
            // You can comment out the next lines if you don't want to execute the statement
            $markerStmt->bind_param("ddii", $latitude, $longitude, $polygon_id, $address_ID);
            if (!$markerStmt->execute()) {
                echo 'Error: ' . $markerStmt->error;
            }
        }
    }    
    // Close the marker statement
    $markerStmt->close();
} else {
    echo 'Error: ' . $stmt->error;
}

// Close the statement and connection
$stmt->close();
$con->close();

function isPointInPolygon ( $point, $polygon ) {
    $c = false;
    $i = -1;
    $l = count ( $polygon );
    $j = $l - 1;

    // The $i variable is incremented before every iteration of the while loop.
    // The loop will continue as long as $i is less than $l, where $l is the length (or count) of $polygon array.
    while ( ++$i < $l ) {
        // For each iteration, the algorithm checks whether the y-coordinate of the point is between the y-coordinates
        // of the consecutive vertices of the polygon, i.e., the point is in the horizontal scope of a polygon edge.
        // If the point satisfies this condition for any edge of the polygon, it enters into the next condition.
        if ( ( ( ( $polygon[$i][1] <= $point[1] ) && ( $point[1] < $polygon[$j][1] ) ) || 
            ( ( $polygon[$j][1] <= $point[1]) && ($point[1] < $polygon[$i][1] ) ) ) &&
            // The next condition checks whether the x-coordinate of the point is to the left of the aforementioned edge.
            // If the point is to the left of any edge of the polygon while being in the horizontal scope of it, 
            // this condition is satisfied.
            ( $point[0] < ($polygon[$j][0] - $polygon[$i][0] ) * ( $point[1] - $polygon[$i][1] ) / 
            ( $polygon[$j][1] - $polygon[$i][1] ) + $polygon[$i][0] ) ) {
            // If both conditions are satisfied, it means a ray casted to the right from the point crossed the polygon edge.
            // The $c variable holds the crossing state. Every time a crossing is detected, the state is toggled.
            $c = !$c;
        }
        // The $j variable is used to hold the previous value of $i in every iteration.
        // So, $polygon[$i] and $polygon[$j] represent the consecutive vertices of the polygon.
        $j = $i;
    }
    return $c;
}

?>
