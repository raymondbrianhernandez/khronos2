<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OCLM Report - Khronos Pro 2</title>
    <link rel="stylesheet" href="report_style.css">
</head>
<body>

<?php

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

// isFullParts Logic
if ( !isset ( $_SESSION['$isFullParts'] ) ) {
    $_SESSION['$isFullParts'] = false;
}

$isFullParts = $_SESSION['$isFullParts'];

if ( isset ( $_POST['view_full_parts'] ) ) {
    $_SESSION['$isFullParts'] = !$_SESSION['$isFullParts']; // Toggles
}

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

echo "
    <div class='button-container'>
        <form method='post'>
            <button type='submit' name='view_full_parts' class='button'>View/Hide Complete Parts</button>
        </form>
        <a class='button' href='generate_word.php' target='_blank'> Save as .docx </a>
        <a class='button' href='report_debug.php' target=\"_blank\"> View as RAW </a>
        <hr>
    </div>";

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
        echo "    <td class='congregation'><h3>" . strtoupper ( $congregation ) . " CONGREGATION </h3></td>";
        echo "    <td class='schedule-header'>";
        echo $isTagalog ? 
            "<h3> Iskedyul ng Pulong sa Gitnang Sanlinggo </h3>" :
            "<h3> Midweek Meeting Schedule </h3>";
        echo "    </td>";
        echo "  </tr>";
        echo "  <tr>";
        echo "    <td class='col-1'><b>{$commonData['date']} | {$commonData['verse']}</b></td>";
        echo "  </tr>";
        echo "</table>";

        // Prepared statements to avoid SQL
        $result = getAssignmentsForWeek ( $tmscon, $congregation, $commonData['week']);

        if ( $result ) { 
            // Display the assignment details for the current week in a table
            echo "<table class='report'>";
            
            $assignmentCounter = 0; // Initialize a counter to keep track of assignments
            $partCounter = 0; // Initialize a counter to keep track of the parts per week
        
            // Chairman, Auxiliary Classroom Counselor and Opening Song/Prayer
            $temp_row = mysqli_fetch_assoc ( $result );
            echo "<tr>";
            echo "  <td class='col-1'>  </td>";
            echo "  <td class='col-2'> Chairman: </td>"; 
            echo "  <td class='col-3'> {$temp_row['chairman']} </td>";
            echo "</tr>";
            echo "<tr>";
            echo "  <td class='col-1'>  </td>";
            if ( $isTagalog ) {
                echo "  <td class='col-2'> Tagapayo sa Karagdagang Klase: </td>";
            } else {
                echo "  <td class='col-2'> Auxiliary Classroom Counselor </td>";
            }
            
            echo "  <td class='col-3'> {$temp_row['advisor']} </td>"; 
            echo "</tr>";
            echo "<tr>";
            echo "  <td class='col-1'>{$meetingStartTime}&nbsp;&nbsp;&bull;&nbsp;&nbsp;{$commonData['song_open']} and Opening Prayer </td>";
            echo "  <td class='col-2'> Prayer: </td>";
            echo "  <td class='col-3'> {$temp_row['assignee']} </td>";  
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
                include 'extract_time.php';

                // At the last loop, dsiplay closing song and prayer
                if ( $assignmentCounter == $totalRows-1 ) {
                    $closingTime = date ( "g:i", strtotime ( $commonData['time'] ) );
                    echo "  <tr>";
                    echo "    <td class='col-1'> {$closingTime}&nbsp;&nbsp;&bull;&nbsp;&nbsp;{$commonData['song_close']} and {$row['part']} </td>";
                    echo "    <td class='col-2'> Prayer: </td>";
                    echo "    <td class='col-3'> {$row['assignee']} </td>";
                    echo "  </tr>";
                    echo "</table>";
                    break;
                }

                // Main loop of assignments
                echo "<tr>";
                
                if ( !$isFullParts ) {
                    echo "  <td class='col-1'>{$commonData['time']}&nbsp;&nbsp;&bull;&nbsp;&nbsp;".trimParts($row['part'])."</td>";
                } else {
                    echo "  <td class='col-1'>{$commonData['time']}&nbsp;&nbsp;&bull;&nbsp;&nbsp;{$row['part']}</td>";
                }
                
                if ( $partCounter == 3 ) { // Bible Reader first
                    echo $isTagalog ? "<td class='col-2'> Estudyante: </td>" : "<td class='col-2'> Student: </td>"; 
                    
                } elseif ( $partCounter > 2 && $partCounter < 7 ) {
                    // If an assignment contains the words "Talk" then it doesn't need a student assistant
                    if ( ( strpos ( $row['part'], 'Pahayag') !== false 
                        || strpos ( $row['part'], 'Talk' ) !== false ) 
                        && ( $partCounter == 6 ) ) {
                        echo $isTagalog ? "<td class='col-2'> Estudyante: </td>" : "<td class='col-2'> Student: </td>";
                    }
                    else {
                        echo $isTagalog ? "<td class='col-2'> Estudyante/Katulong: </td>" : "<td class='col-2'> Student/Assistant: </td>";
                    }
                } elseif ( $assignmentCounter == $totalRows - 3 ) { // CBS
                    echo $isTagalog ? 
                        "<td class='col-2'> Konduktor/Tagabasa: </td>" : 
                        "<td class='col-2'> Conductor/Reader: </td>";
                } else {
                    echo "  <td class='col-2'> </td>";
                }
                
                if ( $row['assistant'] == " " || !$row['assistant'] ) {
                    echo "<td class='col-3'>{$row['assignee']}</td>";
                } else {
                    echo "<td class='col-3'>{$row['assignee']} / {$row['assistant']}</td>";
                }
                echo "</tr>";
                
                // Increment the assignment counter
                $assignmentCounter++;
                $partCounter++;
        
                // Check if it's the 2nd assignment, and insert the additional row
                if ( $assignmentCounter == 1 ) {
                    echo "<tr>";
                    echo "  <td class='col-1-2' colspan=2 style='background-color: silver; color: white;'> &nbsp;&nbsp;";
                    echo $isTagalog ?
                        "<b> KAYAMANAN MULA SA SALITA NG DIYOS </b>":
                        "<b> TREASURES FROM GOD'S WORD </b>";
                    echo "  </td>";
                    echo "  <td class='col-3'></td>";
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

echo "<center><i> End of Report Page </i></center>";

?>

    <div class="footer">
        <?php include '../private/shared/footer.php'; ?>
    </div>

</body>
</html>
