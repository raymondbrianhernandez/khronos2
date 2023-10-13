<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>[DEBUG MODE] OCLM Report by Khronos Pro 2</title>
</head>
<body>

<?php

if ( session_status() !== PHP_SESSION_ACTIVE ) {
    session_start();
}

require '../tms-manager/debug.php';
require '../tms-manager/db.php';

$monthPart = explode(" ", $_SESSION['week_select']);
$congregation = $_SESSION['congregation'];
$start_time = $_SESSION['midweek_time'];
$month = $monthPart[0];
$language = $_SESSION['language'];
$isTagalog = true;

if ( $language != "Tagalog" ) {
    $isTagalog = false;
}

echo "*********************************************************************************<br>";
echo "<h3>\$congregation: " . strtoupper ( $congregation ) . "</h3>";
echo "<h3>\$language: {$language}</h3>";
echo "*********************************************************************************<br>";

$song_query = "SELECT * FROM songs WHERE year = YEAR(CURDATE()) AND select_week LIKE '$month%'";
$song_result = mysqli_query ( $tmscon, $song_query );

if ( $song_result ) {
    $weekCounter = 0; // Initialize a counter to keep track of the weeks
    $partCounter = 0; // Initialize a counter to keep track of the parts per week
    
    while ( $week_row = mysqli_fetch_assoc ( $song_result ) ) {

        $meetingStartTime = date ( "g:i", strtotime ( $week_row['time'] ) );

        // Fetch common data for the current week
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

        echo "<h3>Week of: {$commonData['week']}</h3>";
        echo "<h3>\$commonData['verse']: {$commonData['verse']}</h3>";
        echo "--------------------------<br>";

        // January 1, 1970 means midweek date is not set yet
        if ( $commonData['date'] === "January 1, 1970" ) {
            $commonData['date'] = "No date set yet";
        }

        // 12:00 means time is not set yet, so 7pm is default
        if ( $commonData['time'] == "12:00" ) {
            $commonData['time'] = "7:00";
        }

        // Display common header information for the current week
        echo "<strong>\$congregation:</strong> {$congregation}<br>";
        echo "<strong>\$commonData['date']:</strong> {$commonData['date']}<br>";
        echo "--------------------------<br>";

        // Fetch assignment data for the current week
        $query = "SELECT * FROM assignments WHERE congregation = '$congregation' AND year = YEAR(CURDATE()) AND week = '{$commonData['week']}'";
        $result = mysqli_query ( $tmscon, $query );

        if ( $result ) {
            $assignmentCounter = 0; // Initialize a counter to keep track of assignments
            $startTime = strtotime ( $commonData['time'] ); // Initialize the start time

            // Chairman and Auxiliary Classroom Counselor
            $temp_row = mysqli_fetch_assoc ( $result );
            echo "<strong>\$temp_row['chairman']:</strong> {$temp_row['chairman']}<br>";
            echo "<strong>\$temp_row['advisor']:</strong> {$temp_row['advisor']}<br>";
            echo "--------------------------<br>";
            
            /*** OPENING SONG AND PRAYER ***/
            echo "<strong>\$meetingStartTime:</strong> {$meetingStartTime}<br>";
            echo "<strong>\$commonData['song_open']:</strong> {$commonData['song_open']} and Prayer<br>";
            echo "--------------------------<br>";

            while ( $row = mysqli_fetch_assoc ( $result ) ) {
                
                $countParts = mysqli_num_rows ( $result ) - 2;
                
                // If this is the last loop, break out before processing it.
                if ( $partCounter == $countParts ) {
                    break;
                }
                
                // Extract duration time from each assignment
                // preg_match ( '/\((\d+)\s+min\.\)/', $row['part'], $matches ); // OUTDATED: Only works on English Strings
                preg_match ( '/\((\d+)\W+min\.\)/', $row['part'], $matches );    // UPDATED: Now works for both Tagalog/English 

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

                // Main loop of assignments
                echo "<strong> \$partCounter {$partCounter} / {$countParts} </strong><br>";
                echo "<strong> \$commonData['time']:</strong> {$commonData['time']} <br>";
                echo "<strong> \$row['part']:</strong> {$row['part']} <br>";
                echo "<strong> \$row['assistant']:</strong> {$row['assistant']} <br>";
                echo "<strong> \$row['assignee']:</strong> {$row['assignee']} <br>";
                echo "--------------------------<br>";
                $partCounter++;

                /*** TREASURES FROM GOD'S WORD ***/
                if ( $partCounter == 1 ) {
                    echo "<strong>\$partCounter {$partCounter}</strong><br>";
                    if ( $isTagalog ) {
                        echo "<strong> KAYAMANAN MULA SA SALITA NG DIYOS </strong><br>";
                    } else {
                        echo "<strong> TREASURES FROM GOD'S WORD </strong><br>";
                    }
                    echo "--------------------------<br>";
                }

                /*** APPLY YOURSELF TO THE FIELD MINISTRY ***/
                if ( $partCounter == 4 ) {
                    echo "<strong>\$partCounter {$partCounter}</strong><br>";
                    if ( $isTagalog ) {
                        echo "<strong> MAGING MAHUSAY SA MINISTERYO </strong><br>";
                    } else {
                        echo "<strong> APPLY YOURSELF TO THE FIELD MINISTRY </strong><br>";
                    }
                    echo "--------------------------<br>";
                }

                /*** MIDDLE SONG & LIVING AS CHRISTIANS ***/
                if ( $partCounter == 7 ) {
                    echo "<strong>\$partCounter {$partCounter}</strong><br>";
                    if ( $isTagalog ) {
                        echo "<strong> PAMUMUHAY BILANG KRISTIYANO </strong><br>";
                    } else {
                        echo "<strong> LIVING AS CHRISTIANS </strong><br>";
                    }

                    // Convert the start time back to your desired format
                    $commonData['time'] = date ( "g:i", $startTime ); 
                    // Add 3 minutes (in seconds) to the start time
                    $startTime += 3 * 60;  

                    echo "<strong>\$commonData['time']:</strong> {$commonData['time']}<br>";
                    echo "<strong>\$commonData['song_mid']:</strong> {$commonData['song_mid']}<br>";
                    echo "--------------------------<br>";
                }
            }

            /*** LAST LOOP IS FOR CLOSING SONG/PRAYER ***/
            if ( isset ( $row ) && $row ) {
                // Add 3 minutes to the time
                $closingTime = date ( "g:i", strtotime ( $commonData['time'] . " +3 minutes" ) );

                echo "<strong> \$partCounter {$partCounter} / {$partCounter}</strong><br>";
                echo "<strong>\$commonData['time']:</strong> {$closingTime}<br>";
                echo "<strong>\$commonData['song_close'] & \$row['part']:</strong> {$commonData['song_close']} and {$row['part']} <br>";
                echo "<strong>\$row['assistant']:</strong> {$row['assistant']}<br>";
                echo "<strong>\$row['assignee']:</strong> {$row['assignee']}<br>";
                echo "--------------------------<br>";
            }

            // Free the result set for the current week
            mysqli_free_result ( $result );
        } else {
            echo "Error executing query: " . mysqli_error ( $tmscon );
        }
        
        // Increment the week counter
        $weekCounter++;

        // Reset parts counter
        $partCounter = 0;

        echo "<hr>";
    }
    mysqli_free_result ( $song_result );
} else {
    echo "Error executing query for songs: " . mysqli_error ( $tmscon );
}

// Close the database connection when you're done
mysqli_close ( $tmscon );

?>

</body>
</html>
