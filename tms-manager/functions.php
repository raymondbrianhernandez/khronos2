<?php

function process_date ( $date_range ) {
    /* TEST CASE */
    /* $date_range = "Enero 30–Pebrero 5"; */  

    // extract "Enero 30" from "Enero 30–Pebrero 5"
    $start_date = substr ( $date_range, 0, strpos ( $date_range, '–' ) );

    // seperate "Enero" and "30"
    $month = trim ( substr ( $start_date, 0, strpos ( $start_date, ' ' ) ) );
    $day   = trim ( substr ( $start_date, strpos ( $start_date, ' ' ) ) );

    // translate "Enero" to english month "January"
    $month_translated = '';
    switch ( $month ) {
        case "Enero":
            $month_translated = "January";
            break;
        case "Pebrero":
            $month_translated = "February";
            break;
        case "Marso":
            $month_translated = "March";
            break;
        case "Abril":
            $month_translated = "April";
            break;
        case "Mayo":
            $month_translated = "May";
            break;
        case "Hunyo":
            $month_translated = "June";
            break;
        case "Hulyo":
            $month_translated = "July";
            break;
        case "Agosto":
            $month_translated = "August";
            break;
        case "Setyembre":
            $month_translated = "September";
            break;
        case "Oktubre":
            $month_translated = "October";
            break;
        case "Nobyembre":
            $month_translated = "November";
            break;
        case "Disyembre":
            $month_translated = "December";
            break;
    }

    // concat to make "January 30"
    $start_date_translated = $month_translated . ' ' . $day;

    // use date() to add 4 days to "January 30" which should be "February 3".
    $new_date = date ( 'F j, Y', strtotime ( $start_date_translated . ' + 4 days' ) );

    // return "February 3, 2023"
    /* return $new_date; */
    return strpos ( $date_range, '–' );
}


function extract_and_add_duration ( $part, $formatted_time ) {
    preg_match ( "/\((\d+) min\.\)/", $part, $matches );
    $duration = $matches[1];
    $time = strtotime ( $formatted_time ) ;
    $new_time = strtotime ( "+{$duration} minutes", $time );
    echo $duration /* . "<br>" . $time . "<br>" . $new_time */;  
    return date ( "g:i A", $new_time );
}