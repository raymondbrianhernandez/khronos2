<?php
// generate_word_common_data.php

// Fetch common data for the current week
$commonData = [
    'week' => $week_row['select_week'],
    'date' => date ( "F j, Y", strtotime ( $week_row['date'] ) ),
    'time' => date ( "g:i", strtotime ( $week_row['time'] ) + ( 5 * 60 ) ), // add 5 minutes for opening song/prayer
    'verse' => $week_row['verse'],
    'song_open' => $week_row['song_open'],
    'song_mid' => $week_row['song_mid'],
    'song_close' => $week_row['song_close'],
];

// January 1, 1970 means midweek date is not set yet
if ( stringToDate ( $commonData['date'] ) <= stringToDate ( "January 1, 1970" ) ) {
    $commonData['date'] = "No date set yet";
}

// 12:00 means time is not set yet, so 7pm is default
if ( timeToInt ( $meetingStartTime ) < timeToInt ( DEFAULT_MEETING_START ) ) {
    $meetingStartTime = DEFAULT_MEETING_START;
    $commonData['time'] = DEFAULT_MEETING_NEXT;
}

?>
