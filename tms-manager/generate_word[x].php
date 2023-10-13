<?php

require_once '../vsword/VsWord.php'; 

// header ( "Content-type: application/vnd.openxmlformats-officedocument.wordprocessingml.document" );
// header ( "Content-Disposition: attachment; Filename=OCLM_Schedule.doc" );
// header ( "Content-Type: application/vnd.ms-word; charset=UTF-8" );


echo "<html>";
echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\">";
echo "<body style='width: 8.27in; height: 11.69in; font-family: Calibri, Arial, sans-serif; font-size: 10pt; box-sizing: border-box;'>";

if ( session_status() !== PHP_SESSION_ACTIVE ) {
    session_start();
}

include '../public/debug.php';
require '../tms-manager/db.php';

define ( 'DEFAULT_MEETING_START', '7:00' );
define ( 'DEFAULT_MEETING_NEXT', '7:05' );

$month          = trim ( explode ( " ", $_SESSION['week_select'] )[0] );
$congregation   = $_SESSION['congregation'];
$start_time     = $_SESSION['midweek_time'];
$language       = $_SESSION['language'];
$isTagalog      = true;
if ( $language != "Tagalog" ) { 
    $isTagalog = false; 
}

$isFullParts = !$_SESSION['$isFullParts'];

/**
 * trimParts Function
 * 
 * This function takes a string as an argument and trims anything after the first ')'.
 * If no ')' character is found in the string, the original string is returned.
 * 
 * @param string $inputString The input string that needs to be trimmed.
 * 
 * @return string The trimmed string with content only up to the first ')', or the original string if ')' is not found.
 */
function trimParts ( $inputString ) {
    // Find the position of the first ')'
    $position = strpos ( $inputString, ')' );
    
    if ( $position !== false ) {
        return substr ( $inputString, 0, $position + 1 );
    }

    return $inputString;
}

/**
 * getSongsForMonth Function
 * 
 * Retrieves all songs for a given month in the current year from the 'songs' table.
 * 
 * @param mysqli $con          The database connection object.
 * @param string $month        The desired month for which songs need to be retrieved.
 * 
 * @return mysqli_result       Result set containing songs for the specified month.
 */
function getSongsForMonth ( $con, $month ) {
    $stmt = $con->prepare ( "SELECT * FROM songs WHERE year = YEAR(CURDATE()) AND select_week LIKE ?" );
    $like_value = $month . "%";
    $stmt->bind_param ( "s", $like_value );
    $stmt->execute();
    return $stmt->get_result();
}

/**
 * getAssignmentsForWeek Function
 * 
 * Retrieves all assignments for a specified congregation and week in the current year from the 'assignments' table.
 * 
 * @param mysqli $con                  The database connection object.
 * @param string $congregation         The specific congregation's name or ID.
 * @param string $week                 The desired week for which assignments need to be retrieved.
 * 
 * @return mysqli_result               Result set containing assignments for the specified congregation and week.
 */
function getAssignmentsForWeek ( $con, $congregation, $week ) {
    $stmt = $con->prepare ( "SELECT * FROM assignments WHERE congregation = ? AND year = YEAR(CURDATE()) AND week = ?" );
    $stmt->bind_param ( "ss", $congregation, $week );
    $stmt->execute();
    return $stmt->get_result();
}

// Prepared statements to avoid SQL
$song_result = getSongsForMonth ( $tmscon, $month );

if ( $song_result ) {
    $weekCounter = 0; // Initialize a counter to keep track of the weeks
    
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
        
        // January 1, 1970 means midweek date is not set yet
        if ( $commonData['date'] === "January 1, 1970" ) {
            $commonData['date'] = "No date set yet";
        }

        // 12:00 means time is not set yet, so 7pm is default
        if ( $meetingStartTime === "12:00" ) {
            $meetingStartTime = DEFAULT_MEETING_START;
            $commonData['time'] = DEFAULT_MEETING_NEXT;
        }

        // Display common header information for the current week
        echo "<table>";
        echo "  <tr>";
        echo "    <td style='white-space: normal; width: 50%;'><h3>" . strtoupper ( $congregation ) . " CONGREGATION </h3></td>";
        echo "    <td style='white-space: normal; width: 50%; font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif; font-size: 12pt;'>";
        echo $isTagalog ? 
            "<h3> Iskedyul ng Pulong sa Gitnang Sanlinggo </h3>" :
            "<h3> Midweek Meeting Schedule </h3>";
        echo "    </td>";
        echo "  </tr>";
        echo "  <tr>";
        echo "    <td style='white-space: normal; word-wrap: break-word; overflow: hidden; width: 4in; text-align: left; padding-right: 5px;'><b>{$commonData['date']} | {$commonData['verse']}</b></td>";
        echo "  </tr>";
        echo "</table>";

        // Prepared statements to avoid SQL
        $result = getAssignmentsForWeek ( $tmscon, $congregation, $commonData['week']);

        if ( $result ) { 
            // Display the assignment details for the current week in a table
            echo "<table>";
            
            $assignmentCounter = 0; // Initialize a counter to keep track of assignments
            $partCounter = 0; // Initialize a counter to keep track of the parts per week
        
            // Chairman, Auxiliary Classroom Counselor and Opening Song/Prayer
            $temp_row = mysqli_fetch_assoc ( $result );
            echo "<tr>";
            echo "  <td style='white-space: normal; word-wrap: break-word; overflow: hidden; width: 4in; text-align: left; padding-right: 5px;'>  </td>";
            echo "  <td style='white-space: normal; word-wrap: break-word; overflow: hidden; width: 1.27in; text-align: right; font-size: 8pt; font-style: italic; padding-left: 5px; padding-right: 5px;'> Chairman: </td>"; 
            echo "  <td style='white-space: normal; word-wrap: break-word; overflow: hidden; width: 2in; text-align: left; padding-left: 5px;'> {$temp_row['chairman']} </td>";
            echo "</tr>";
            echo "<tr>";
            echo "  <td style='white-space: normal; word-wrap: break-word; overflow: hidden; width: 4in; text-align: left; padding-right: 5px;'>  </td>";
            if ( $isTagalog ) {
                echo "  <td style='white-space: normal; word-wrap: break-word; overflow: hidden; width: 1.27in; text-align: right; font-size: 8pt; font-style: italic; padding-left: 5px; padding-right: 5px;'> Tagapayo sa Karagdagang Klase: </td>";
            } else {
                echo "  <td style='white-space: normal; word-wrap: break-word; overflow: hidden; width: 1.27in; text-align: right; font-size: 8pt; font-style: italic; padding-left: 5px; padding-right: 5px;'> Auxiliary Classroom Counselor </td>";
            }
            
            echo "  <td style='white-space: normal; word-wrap: break-word; overflow: hidden; width: 2in; text-align: left; padding-left: 5px;'> {$temp_row['advisor']} </td>"; 
            echo "</tr>";
            echo "<tr>";
            echo "  <td style='white-space: normal; word-wrap: break-word; overflow: hidden; width: 4in; text-align: left; padding-right: 5px;'>{$meetingStartTime}&nbsp;&nbsp;&bull;&nbsp;&nbsp;{$commonData['song_open']} and Opening Prayer </td>";
            echo "  <td style='white-space: normal; word-wrap: break-word; overflow: hidden; width: 1.27in; text-align: right; font-size: 8pt; font-style: italic; padding-left: 5px; padding-right: 5px;'> Prayer </td>";
            echo "  <td style='white-space: normal; word-wrap: break-word; overflow: hidden; width: 2in; text-align: left; padding-left: 5px;'> {$temp_row['assignee']} </td>";  
            echo "</tr>";

            $firstAssignment = true; // Initialize the flag for the first assignment
            $startTime = strtotime ( $commonData['time'] ); // Initialize the start time
            $loopCount = 0;

            // Fetch all results first
            $rows = mysqli_fetch_all ( $result, MYSQLI_ASSOC );

            // Count the total rows
            $totalRows = count ( $rows );
            
            for ( $i = 0; $i < $totalRows; $i++ ) {
                $row = $rows[$i];
                $loopCount++;

                // Extract duration time from each assignment
                preg_match ( '/\((\d+)\W+min\.\)/', $row['part'], $matches );

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

                // At the last loop, dsiplay closing song and prayer
                if ( $assignmentCounter == $totalRows-1 ) {
                    $closingTime = date ( "g:i", strtotime ( $commonData['time'] ) );
                    echo "  <tr>";
                    echo "    <td style='white-space: normal; word-wrap: break-word; overflow: hidden; width: 4in; text-align: left; padding-right: 5px;'> {$closingTime}&nbsp;&nbsp;&bull;&nbsp;&nbsp;{$commonData['song_close']} and {$row['part']} </td>";
                    echo "    <td style='white-space: normal; word-wrap: break-word; overflow: hidden; width: 1.27in; text-align: right; font-size: 8pt; font-style: italic; padding-left: 5px; padding-right: 5px;'> Prayer: </td>";
                    echo "    <td style='white-space: normal; word-wrap: break-word; overflow: hidden; width: 2in; text-align: left; padding-left: 5px;'> {$row['assignee']} </td>";
                    echo "  </tr>";
                    echo "</table>";
                    break;
                }

                // Main loop of assignments
                echo "<tr>";
                
                if ( !$isFullParts ) {
                    echo "  <td style='white-space: normal; word-wrap: break-word; overflow: hidden; width: 4in; text-align: left; padding-right: 5px;'>{$commonData['time']}&nbsp;&nbsp;&bull;&nbsp;&nbsp;".trimParts($row['part'])."</td>";
                } else {
                    echo "  <td style='white-space: normal; word-wrap: break-word; overflow: hidden; width: 4in; text-align: left; padding-right: 5px;'>{$commonData['time']}&nbsp;&nbsp;&bull;&nbsp;&nbsp;{$row['part']}</td>";
                }
                
                if ( $partCounter == 3 ) { // Bible Reader first
                    echo $isTagalog ? "<td style='white-space: normal; word-wrap: break-word; overflow: hidden; width: 1.27in; text-align: right; font-size: 8pt; font-style: italic; padding-left: 5px; padding-right: 5px;'> Estudyante: </td>" : "<td style='white-space: normal; word-wrap: break-word; overflow: hidden; width: 1.27in; text-align: right; font-size: 8pt; font-style: italic; padding-left: 5px; padding-right: 5px;'> Student: </td>"; 
                    
                } elseif ( $partCounter > 2 && $partCounter < 7 ) {
                    // If an assignment contains the words "Talk" then it doesn't need a student assistant
                    if ( ( strpos ( $row['part'], 'Pahayag') !== false 
                        || strpos ( $row['part'], 'Talk' ) !== false ) 
                        && ( $partCounter == 6 ) ) {
                        echo $isTagalog ? "<td style='white-space: normal; word-wrap: break-word; overflow: hidden; width: 1.27in; text-align: right; font-size: 8pt; font-style: italic; padding-left: 5px; padding-right: 5px;'> Estudyante: </td>" : "<td style='white-space: normal; word-wrap: break-word; overflow: hidden; width: 1.27in; text-align: right; font-size: 8pt; font-style: italic; padding-left: 5px; padding-right: 5px;'> Student: </td>";
                    }
                    else {
                        echo $isTagalog ? "<td style='white-space: normal; word-wrap: break-word; overflow: hidden; width: 1.27in; text-align: right; font-size: 8pt; font-style: italic; padding-left: 5px; padding-right: 5px;'> Estudyante/Katulong: </td>" : "<td style='white-space: normal; word-wrap: break-word; overflow: hidden; width: 1.27in; text-align: right; font-size: 8pt; font-style: italic; padding-left: 5px; padding-right: 5px;'> Student/Assistant: </td>";
                    }
                } elseif ( $assignmentCounter == $totalRows - 3 ) { // CBS
                    echo $isTagalog ? 
                        "<td style='white-space: normal; word-wrap: break-word; overflow: hidden; width: 1.27in; text-align: right; font-size: 8pt; font-style: italic; padding-left: 5px; padding-right: 5px;'> Konduktor/Tagabasa: </td>" : 
                        "<td style='white-space: normal; word-wrap: break-word; overflow: hidden; width: 1.27in; text-align: right; font-size: 8pt; font-style: italic; padding-left: 5px; padding-right: 5px;'> Conductor/Reader: </td>";
                } else {
                    echo "  <td style='white-space: normal; word-wrap: break-word; overflow: hidden; width: 1.27in; text-align: right; font-size: 8pt; font-style: italic; padding-left: 5px; padding-right: 5px;'> </td>";
                }
                
                if ( $row['assistant'] == " " || !$row['assistant'] ) {
                    echo "<td style='white-space: normal; word-wrap: break-word; overflow: hidden; width: 2in; text-align: left; padding-left: 5px;'>{$row['assignee']}</td>";
                } else {
                    echo "<td style='white-space: normal; word-wrap: break-word; overflow: hidden; width: 2in; text-align: left; padding-left: 5px;'>{$row['assignee']} / {$row['assistant']}</td>";
                }
                echo "</tr>";
                
                // Increment the assignment counter
                $assignmentCounter++;
                $partCounter++;
        
                // Check if it's the 2nd assignment, and insert the additional row
                if ( $assignmentCounter == 1 ) {
                    echo "<tr>";
                    echo "<td colspan=2 style='white-space: normal; word-wrap: break-word; overflow: hidden; width: 5.27in; text-align: left; background-color: silver; color: white;'>
                    &nbsp;&nbsp;";
                    echo $isTagalog ?
                        "<b> KAYAMANAN MULA SA SALITA NG DIYOS </b>":
                        "<b> TREASURES FROM GOD'S WORD </b>";
                    echo "  </td>";
                    echo "  <td style='white-space: normal; word-wrap: break-word; overflow: hidden; width: 2in; text-align: left; padding-left: 5px;'></td>";
                    echo "</tr>";
                }
        
                // Check if it's the 5th assignment and insert the additional row
                if ( $assignmentCounter == 4 ) {
                    echo "<tr>";
                    echo "  <td colspan=2 style='width:80%; background-color: #B8860B; color: white;'>&nbsp;&nbsp;";
                    echo $isTagalog ?
                        "<b> MAGING MAHUSAY SA MINISTERYO </b>" :
                        "<b> APPLY YOURSELF TO THE FIELD MINISTRY </b>";
                    echo "  </td>";
                    echo "  <td style='width:20%'></td>";
                    echo "</tr>";
                }

                // Check if it's the 7th assignment and insert the additional row
                if ( $assignmentCounter == 7 ) {
                    echo "<tr>";
                    echo "  <td colspan=2 style='width:80%; background-color: red; color: white;'>&nbsp;&nbsp;";
                    echo $isTagalog ?
                        "<b> PAMUMUHAY BILANG KRISTIYANO </b>" :
                        "<b> LIVING AS CHRISTIANS </b>";
                    echo "  </td>";
                    echo "  <td style='width:20%'></td>";
                    echo "</tr>";
                    echo "<tr>";
                    
                    $commonData['time'] = date("g:i", $startTime); // Convert the start time back to your desired format
                    $startTime += 3 * 60;  // Add 3 minutes (in seconds) to the start time
                    echo "  <td style='width:80%'>{$commonData['time']}&nbsp;&nbsp;&bull;&nbsp;&nbsp;{$commonData['song_mid']}</td>";  
                    echo "</tr>";
                }
            } /** END for ( $i = 0; $i < $totalRows; $i++ ) **/
        
            // Free the result set for the current week
            mysqli_free_result ( $result );
            $partCounter = 0;

        } else {
            echo "Error executing query: " . mysqli_error ( $tmscon );
        } /** end if ( $result ) **/  
        
        // Increment the week counter
        $weekCounter++;

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