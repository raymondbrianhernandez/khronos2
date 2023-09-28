<?php

header ( "Content-type: application/vnd.openxmlformats-officedocument.wordprocessingml.document" );
header ( "Content-Disposition: attachment; Filename=OCLM_Schedule.doc" );
header ( "Content-Type: application/vnd.ms-word; charset=UTF-8" );

echo "<html>";
echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\">";
echo "<body>";

if ( session_status() !== PHP_SESSION_ACTIVE ) {
    session_start();
}

//include ( '../public/debug.php' );
require ( 'db.php' );

mysqli_set_charset ( $con, "utf8" );

$monthPart = explode(" ", $_SESSION['week_select']);
$congregation = $_SESSION['congregation'];
$start_time = $_SESSION['midweek_time'];
$month = $monthPart[0];
$language = $_SESSION['language'];
$isTagalog = true;

if ($language != "Tagalog") {
    $isTagalog = false;
}

$song_query = "SELECT * FROM songs WHERE year = YEAR(CURDATE()) AND select_week LIKE '$month%'";
$song_result = mysqli_query($con, $song_query);

if ($song_result) {
    $weekCounter = 0; // Initialize a counter to keep track of the weeks
    
    while ( $week_row = mysqli_fetch_assoc ( $song_result ) ) {
        // Fetch common data for the current week
        $commonData = [
            'week' => $week_row['select_week'],
            'date' => date ( "F j, Y", strtotime ( $week_row['date'] ) ),
            'time' => date ( "g:i", strtotime ( $week_row['time'] ) ),
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
        if ( $commonData['time'] === "12:00" ) {
            $commonData['time'] = "7:00";
        }

        // Display common header information for the current week
        echo "<table class='letterhead'>";
        echo "  <tr>";
        echo "    <td class='congregation' style='width:50%'><h3>" . strtoupper ( $congregation ) . " CONGREGATION </h3></td>";
        echo "    <td class='schedule-header' style='width:50%;'>";
        if ( $isTagalog ) {
            echo "<h3> Iskedyul ng Pulong sa Gitnang Sanlinggo </h3>";
        } else {
            echo "<h3> Midweek Meeting Schedule </h3>";
        }
        echo "    </td>";
        echo "  </tr>";
        echo "  <tr>";
        echo "    <td style='width:50%'><b>{$commonData['date']} | {$commonData['verse']}</b></td>";
        echo "    <td style='width:50%'></td>";
        echo "  </tr>";
        echo "</table>";

        // Fetch assignment data for the current week
        $query = "SELECT * FROM assignments WHERE congregation = '$congregation' AND year = YEAR(CURDATE()) AND week = '{$commonData['week']}'";
        $result = mysqli_query ( $con, $query );

        if ($result) {
            // Display the assignment details for the current week in a table
            echo "<table class='report'>";
            
            $assignmentCounter = 0; // Initialize a counter to keep track of assignments
        
            // Chairman and Auxiliary Classroom Counselor
            $temp_row = mysqli_fetch_assoc ( $result );
            echo "<tr>";
            echo "  <td style='width:80%; text-align: right; font-size: 8pt;'>Chairman</td>"; 
            echo "  <td style='width:20%; text-align: left;'>{$temp_row['chairman']}</td>";
            echo "</tr>";
            echo "<tr>";
            echo "  <td style='width:80%; text-align: right; font-size: 8pt'>Auxiliary Classroom Counselor</td>";
            echo "  <td style='width:20%; text-align: left;'>{$temp_row['advisor']}</td>"; 
            echo "</tr>";
            
            // Reset the assignment counter
            $assignmentCounter = 0;

            $firstAssignment = true; // Initialize the flag for the first assignment
            $startTime = strtotime ( $commonData['time'] ); // Initialize the start time

            while ( $row = mysqli_fetch_assoc ( $result ) ) {
                // Extract duration time from each assignment
                preg_match ( '/\((\d+)\s+min\.\)/', $row['part'], $matches );

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
                }

                // Main loop of assignments
                echo "<tr>";
                echo "  <td style='width:80%'>" . $commonData['time'] . "&nbsp;&nbsp;&bull;&nbsp;&nbsp;" . $row['part'] . "</td>";
                if ( $row['assistant'] == " " ) {
                    echo "<td style='width:20%'>{$row['assignee']}</td>";
                } else {
                    echo "<td style='width:20%'>{$row['assignee']} / {$row['assistant']}</td>";
                }
                echo "</tr>";
        
                // Increment the assignment counter
                $assignmentCounter++;
        
                // Check if it's the 2nd assignment, and insert the additional row
                if ( $assignmentCounter == 2 ) {
                    echo "<tr>";
                    echo "  <td style='width:80%; background-color: blue; color: white;'>&nbsp;&nbsp;";
                    if ( $isTagalog ) {
                        echo "<b>KAYAMANAN MULA SA SALITA NG DIYOS</b>";
                    } else {
                        echo "<b>TREASURES FROM GOD'S WORD</b>";
                    }
                    echo "  </td>";
                    echo "  <td style='width:20%'></td>";
                    echo "</tr>";
                }
        
                // Check if it's the 5th assignment and insert the additional row
                if ( $assignmentCounter == 5 ) {
                    echo "<tr>";
                    echo "  <td style='width:80%; background-color: #B8860B; color: white;'>&nbsp;&nbsp;";
                    if ( $isTagalog ) {
                        echo "<b> MAGING MAHUSAY SA MINISTERYO </b>";
                    } else {
                        echo "<b> APPLY YOURSELF TO THE FIELD MINISTRY </b>";
                    }
                    echo "  </td>";
                    echo "  <td style='width:20%'></td>";
                    echo "</tr>";
                }

                // Check if it's the 5th assignment and insert the additional row
                if ( $assignmentCounter == 7 ) {
                    echo "<tr>";
                    echo "  <td style='width:80%; background-color: red; color: white;'>&nbsp;&nbsp;";
                    if ( $isTagalog ) {
                        echo "<b> PAMUMUHAY BILANG KRISTIYANO </b>";
                    } else {
                        echo "<b> LIVING AS CHRISTIANS </b>";
                    }
                    echo "  </td>";
                    echo "  <td style='width:20%'></td>";
                    echo "</tr>";
                }
            }
        
            echo "</table><br>";
        
            // Free the result set for the current week
            mysqli_free_result ( $result );
        } else {
            echo "Error executing query: " . mysqli_error ( $con );
        }
        
        // Increment the week counter
        $weekCounter++;

        echo "<hr>";
    }
    mysqli_free_result ( $song_result );
} else {
    echo "Error executing query for songs: " . mysqli_error ( $con );
}

// Close the database connection when you're done
mysqli_close ( $con );

echo "</body>";
echo "</html>";

?>