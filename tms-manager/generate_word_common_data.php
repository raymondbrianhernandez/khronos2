<?php
// generate_word_common_data.php

$commonData = [
    'week' => $week_row['select_week'],
    'date' => date ( "F j, Y", strtotime ( $week_row['date'] ) ),
    // add 5 minutes for opening song/prayer
    'time' => date ( "g:i", strtotime ( $week_row['time'] ) + ( 5 * 60 ) ), 
    'verse' => $week_row['verse'],
    'song_open' => $week_row['song_open'],
    'song_mid' => $week_row['song_mid'],
    'song_close' => $week_row['song_close'],
];

// January 1, 1970 means midweek date is not set yet
if ( $commonData['date'] === "January 1, 1970" ) {
    $commonData['date'] = "No date set yet";
}

// 12:00 means time is not set yet, so 7pm is default
if ( $meetingStartTime === "12:00" ) {
    $meetingStartTime = DEFAULT_MEETING_START;
    $commonData['time'] = DEFAULT_MEETING_NEXT;
}

?>
