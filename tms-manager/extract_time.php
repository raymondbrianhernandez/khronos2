<?php

// Check if a duration is found in the assignment
if ( !empty ( $matches ) ) {
    // Extract the minutes from the match
    $durationMinutes = ( int ) $matches[1];
    
    // Calculate the end time for this assignment
    $endTime = $startTime + ( $durationMinutes * 60 ); // Convert minutes to seconds

    // Update the time in 12-hour
    $commonData['time'] = date ( "g:i", $startTime );

    // Set the start time for the next assignment
    $startTime = $endTime; // Use the end time as the start time for the next assignment

} else {
    // If no duration is found, just display the current time without updating it.
    $commonData['time'] = date ( "g:i", $startTime );
}

?>