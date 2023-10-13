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

// Prepared statements to avoid SQL
$song_result = getSongsForMonth ( $tmscon, $month );

ob_start();

?>

<body>

<?php

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
        
        ?>
        
        <table>
            <tr>
                <td style="white-space: normal; width: 50%;">
                    <h3><?php echo strtoupper ( $congregation ); ?> CONGREGATION</h3>
                </td>
                <td style="white-space: normal; width: 50%; font-family: Cambria, Cochin, Georgia, Times, Times New Roman, serif; font-size: 12pt;">
                    <?php 
                        if ( $isTagalog ) {
                            echo "<h3>Iskedyul ng Pulong sa Gitnang Sanlinggo</h3>";
                        } else {
                            echo "<h3>Midweek Meeting Schedule</h3>";
                        }
                    ?>
                </td>
            </tr>
            <tr>
                <td style="white-space: normal; word-wrap: break-word; overflow: hidden; width: 4in; text-align: left; padding-right: 5px;">
                    <b><?php echo $commonData['date']; ?> | <?php echo $commonData['verse']; ?></b>
                </td>
                <td style="white-space: normal; width: 1.27in; text-align: right; font-size: 8pt; font-style: italic; padding-left: 5px; padding-right: 5px;"></td>
                <td style="white-space: normal; width: 2in; text-align: left; padding-left: 5px;"></td>
            </tr>
        </table>


        <?php

        // Prepared statements to avoid SQL
        $result = getAssignmentsForWeek ( $tmscon, $congregation, $commonData['week']);

        if ( $result ) { 

            ?>

            <table>
        
            <?php
                $assignmentCounter = 0; // Initialize a counter to keep track of assignments
                $partCounter = 0; // Initialize a counter to keep track of the parts per week
                $temp_row = mysqli_fetch_assoc ( $result );
            ?>

            <tr>
                <td style="white-space: normal; width: 4in; text-align: left; padding-right: 5px;"></td>
                <td style="white-space: normal; width: 1.27in; text-align: right; font-size: 8pt; font-style: italic; padding-left: 5px; padding-right: 5px;">Chairman:</td>
                <td style="white-space: normal; width: 2in; text-align: left; padding-left: 5px;"><?php echo $temp_row['chairman']; ?></td>
            </tr>
            <tr>
                <td style="white-space: normal; width: 4in; text-align: left; padding-right: 5px;"></td>
                <td style="white-space: normal; width: 1.27in; text-align: right; font-size: 8pt; font-style: italic; padding-left: 5px; padding-right: 5px;">
                    <?php 
                    if ($isTagalog) {
                        echo "Tagapayo sa Karagdagang Klase:";
                    } else {
                        echo "Auxiliary Classroom Counselor";
                    }
                    ?>
                </td>
                <td style="white-space: normal; width: 2in; text-align: left; padding-left: 5px;"><?php echo $temp_row['advisor']; ?></td>
            </tr>
            <tr>
                <td style="white-space: normal; width: 4in; text-align: left; padding-right: 5px;"><?php echo "{$meetingStartTime}&nbsp;&nbsp;&bull;&nbsp;&nbsp;{$commonData['song_open']} and Opening Prayer"; ?></td>
                <td style="white-space: normal; width: 1.27in; text-align: right; font-size: 8pt; font-style: italic; padding-left: 5px; padding-right: 5px;">Prayer</td>
                <td style="white-space: normal; width: 2in; text-align: left; padding-left: 5px;"><?php echo $temp_row['assignee']; ?></td>
            </tr>

            <?php

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

                    ?>
                    
                    <tr>
                        <td style='white-space: normal; word-wrap: break-word; overflow: hidden; width: 4in; text-align: left; padding-right: 5px;'> <?= $closingTime ?>&nbsp;&nbsp;&bull;&nbsp;&nbsp;<?= $commonData['song_close'] ?> and <?= $row['part'] ?> </td>
                        <td style='white-space: normal; word-wrap: break-word; overflow: hidden; width: 1.27in; text-align: right; font-size: 8pt; font-style: italic; padding-left: 5px; padding-right: 5px;'> Prayer: </td>
                        <td style='white-space: normal; word-wrap: break-word; overflow: hidden; width: 2in; text-align: left; padding-left: 5px;'> <?= $row['assignee'] ?> </td>
                    </tr>
                    </table>
                    
                    <?php
                    
                    break;
                }

                ?>

                <tr>

                <?php if ( !$isFullParts ) : ?>
                    <td style='white-space: normal; word-wrap: break-word; overflow: hidden; width: 4in; text-align: left; padding-right: 5px;'><?= $commonData['time'] ?>&nbsp;&nbsp;&bull;&nbsp;&nbsp;<?= trimParts($row['part']) ?></td>
                <?php else : ?>
                    <td style='white-space: normal; word-wrap: break-word; overflow: hidden; width: 4in; text-align: left; padding-right: 5px;'><?= $commonData['time'] ?>&nbsp;&nbsp;&bull;&nbsp;&nbsp;<?= $row['part'] ?></td>
                <?php endif; ?>

                <?php
                    $displayString = "";
                    if ( $partCounter == 3 ) {
                        $displayString = $isTagalog ? "Estudyante:" : "Student:";
                    } elseif ( $partCounter > 2 && $partCounter < 7 ) {
                        if ( ( strpos ( $row['part'], 'Pahayag' ) !== false || strpos ( $row['part'], 'Talk' ) !== false ) && ( $partCounter == 6 ) ) {
                            $displayString = $isTagalog ? "Estudyante:" : "Student:";
                        } else {
                            $displayString = $isTagalog ? "Estudyante/Katulong:" : "Student/Assistant:";
                        }
                    } elseif ( $assignmentCounter == $totalRows - 3 ) {
                        $displayString = $isTagalog ? "Konduktor/Tagabasa:" : "Conductor/Reader:";
                    }
                ?>

                <td style='white-space: normal; word-wrap: break-word; overflow: hidden; width: 1.27in; text-align: right; font-size: 8pt; font-style: italic; padding-left: 5px; padding-right: 5px;'><?= $displayString ?></td>

                <?php if ( !$row['assistant'] || $row['assistant'] == " " ) : ?>
                    <td style='white-space: normal; word-wrap: break-word; overflow: hidden; width: 2in; text-align: left; padding-left: 5px;'><?= $row['assignee'] ?></td>
                <?php else : ?>
                    <td style='white-space: normal; word-wrap: break-word; overflow: hidden; width: 2in; text-align: left; padding-left: 5px;'><?= $row['assignee'] ?> / <?= $row['assistant'] ?></td>
                <?php endif; ?>
                
                </tr>

            <?php
                $assignmentCounter++;
                $partCounter++;

                // Check if it's the 2nd assignment, and insert the additional row
                if ( $assignmentCounter == 1 ) { ?>
                    <tr>
                        <td colspan=2 style='white-space: normal; word-wrap: break-word; overflow: hidden; width: 5.27in; text-align: left; background-color: silver; color: white;'> &nbsp;&nbsp;";
                            <?php if ( $isTagalog ) { ?>
                                <b> KAYAMANAN MULA SA SALITA NG DIYOS </b> 
                            <?php } else { ?>
                                <b> TREASURES FROM GOD'S WORD </b>
                            <?php } ?>
                        </td>
                        <td style='white-space: normal; word-wrap: break-word; overflow: hidden; width: 2in; text-align: left; padding-left: 5px;'></td>
                    </tr>
                <?php } ?>
        
                <?php if ( $assignmentCounter == 4 ) { ?>
                    <tr>
                        <td colspan=2 style='width:80%; background-color: #B8860B; color: white;'>&nbsp;&nbsp;
                            <?php if ( $isTagalog ) { ?>
                                <b> MAGING MAHUSAY SA MINISTERYO </b>
                            <?php } else { ?>
                                <b> APPLY YOURSELF TO THE FIELD MINISTRY </b>
                            <?php } ?>
                        </td>
                        <td style='width:20%'></td>
                    </tr>
                <?php } ?>

                <?php if ( $assignmentCounter == 7 ) { ?>
                    <tr>
                        <td colspan=2 style='width:80%; background-color: red; color: white;'>&nbsp;&nbsp;
                            <?php if ( $isTagalog ) { ?>
                                <b> PAMUMUHAY BILANG KRISTIYANO </b>
                            <?php } else { ?>
                                <b> LIVING AS CHRISTIANS </b>
                            <?php } ?>
                        </td>
                        <td style='width:20%'></td>
                    </tr>

                    <tr>
                    
                    <?php
                        $commonData['time'] = date("g:i", $startTime); // Convert the start time back to your desired format
                        $startTime += 3 * 60;  // Add 3 minutes (in seconds) to the start time
                    ?>

                        <td style='width:80%'>{$commonData['time']}&nbsp;&nbsp;&bull;&nbsp;&nbsp;{$commonData['song_mid']}</td>
                        <td style="white-space: normal; width: 1.27in; text-align: right; font-size: 8pt; font-style: italic; padding-left: 5px; padding-right: 5px;"></td>
                        <td style="white-space: normal; width: 2in; text-align: left; padding-left: 5px;"></td>
                    </tr>
                <?php } ?>
             <?php } ?>
        
            <?php
             // Free the result set for the current week
            mysqli_free_result ( $result );
            $partCounter = 0;

        } else { ?> 
            echo "Error executing query: " . mysqli_error ( $tmscon );
        <?php }  ?> 
        
        <?php
            // Increment the week counter
            $weekCounter++;
        ?>
        
        <hr>
    <?php }
    mysqli_free_result ( $song_result );

} else {
    echo "Error executing query for songs: " . mysqli_error ( $tmscon );
} 

// Close the database connection when you're done
mysqli_close ( $tmscon );

?>

</body>

<?php
    // Anything echoed or included above this line is now in the buffer

$bufferedContent = ob_get_contents();

// Store the buffered content in the session (if needed)
$_SESSION['saved_html'] = $bufferedContent;

// Clear the output buffer without turning it off
ob_clean();

header ( 'Location: generate_word.php' );
?>
