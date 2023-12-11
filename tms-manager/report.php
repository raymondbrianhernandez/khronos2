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

include 'debug.php';
require 'db.php';
include '_functions.php';
include '_globals.php';

$month        = trim ( explode ( " ", $_SESSION['week_select'] )[0] );
$year         = $_SESSION['workbook_year'];
$congregation = $_SESSION['congregation'];
$start_time   = $_SESSION['midweek_time'];
$language     = $_SESSION['language'];
$isTagalog    = true;

include '_buttons.php';

//**************************** REPORT STARTS HERE ****************************/ 

// Grab the songs
$song_result = getSongsForMonth ( $tmscon, $month, $year, $congregation );

if ( $song_result ) {
    
    $weekCounter = 0; // Initialize a counter to keep track of the weeks
    
    while ( $week_row = mysqli_fetch_assoc ( $song_result ) ) {
        
        $meetingStartTime = date ( "g:i", strtotime ( $week_row['time'] ) );
        // echo "{$meetingStartTime}<br>";

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
        // print_r ( $commonData );

        // January 1, 1970 means midweek date is not set yet
        if ( stringToDate ( $commonData['date'] ) <= stringToDate ( "January 1, 1970" ) ) {
            $commonData['date'] = "No date set yet";
        }

        // 12:00 means time is not set yet, so 7pm is default
        if ( timeToInt ( $meetingStartTime ) < timeToInt ( DEFAULT_MEETING_START ) ) {
            $meetingStartTime = DEFAULT_MEETING_START;
            $commonData['time'] = DEFAULT_MEETING_NEXT;
        }

        $startTime = strtotime ( $commonData['time'] ); // Initialize the start time

        // Display common header information for the current week
        include '_header.php';

        // Main Table Starts Here
        $result = getAssignmentsForWeek ( $tmscon, $congregation, $commonData['week'], $year );
                
        if ( $result ) { 
            $assignmentCounter = 0; // Initialize a counter to keep track of assignments
            $partCounter = 0; // Initialize a counter to keep track of the parts per week

            echo "<table class='report'>";
            
            // Chairman, Auxiliary Classroom Counselor and Opening Song/Prayer
            $temp_row = mysqli_fetch_assoc ( $result );
            $result->data_seek(0);
            $prayer = $isTagalog ? "Panalangin:" : "Prayer:";
            $and_prayer = $isTagalog ? "at Panalangin:" : "and Prayer:";
            echo "<tr>";
            echo "  <td class='col-1'>  </td>";
            echo "  <td class='col-2'> Chairman: </td>"; 
            echo "  <td class='col-3'> {$temp_row['chairman']} </td>";
            echo "</tr>";
            echo "<tr>";
            echo "  <td class='col-1'>  </td>";
            $auxCouncilor = $isTagalog ? "Tagapayo sa Karagdagang Klase:" : "Auxiliary Classroom Counselor";
            echo "  <td class='col-2'> $auxCouncilor </td>";
            echo "  <td class='col-3'> {$temp_row['advisor']} </td>"; 
            echo "</tr>";
            echo "<tr>";
            echo "  <td class='col-1'>{$meetingStartTime}&nbsp;&nbsp;&bull;&nbsp;&nbsp;{$commonData['song_open']} {$and_prayer} </td>";
            echo "  <td class='col-2'> {$prayer} </td>";
            echo "  <td class='col-3'> {$temp_row['assignee']} </td>";  
            echo "</tr>";

            // Opening Comments (1 min.)
            echo "<tr>";
            $openingPart = $isTagalog ? "Pambungad na Komento (1 min.)" : "Opening Comments (1 min.)";
            echo "  <td class='col-1'>{$commonData['time']}&nbsp;&nbsp;&bull;&nbsp;&nbsp;{$openingPart} </td>";
            preg_match ( '/\((\d+)\W+min\.\)/', $openingPart, $matches );
            include 'extract_time.php';
            echo "  <td class='col-2'></td>";
            echo "  <td class='col-3'></td>";  
            echo "</tr>";
            echo "<tr>";
            echo "  <td class='col-1-2' colspan=2 style='background-color: silver; color: white;'> &nbsp;&nbsp;";
            $treasures = $isTagalog ? "<b>KAYAMANAN MULA SA SALITA NG DIYOS</b>" : "<b>TREASURES FROM GOD'S WORD</b>";
            echo $treasures;
            echo "  </td>";
            echo "  <td class='col-3'></td>";
            echo "</tr>";

            // Fetch all parts first
            $rows = mysqli_fetch_all ( $result, MYSQLI_ASSOC );
            mysqli_data_seek ( $result, 0 );

            // Count the total parts
            $totalParts = count ( $rows );

            include '_livingAsChristiansIndex.php';
            
            for ( $i = 0; $i < $totalParts; $i++ ) {
                $row = $rows[$i];
                //echo "Debug: Iteration $i - Part: {$row['part']}<br>";

                // Extract duration time from each assignment
                preg_match ( '/\((\d+)\W+min\.\)/', $row['part'], $matches );
                include 'extract_time.php';

                // Main loop of assignments
                echo "<tr>";

                // Column 1 - Parts Title
                $part = !$isFullParts ? trimParts ( $row['part'] ) : $row['part'];
                echo "<td class='col-1'>{$commonData['time']}&nbsp;&nbsp;&bull;&nbsp;&nbsp;{$part}</td>";
                
                // Column 2 - Decription of assignee (Student, Assitant, Conductor, or Reader)
                $lowercasePart = strtolower ( $row['part'] );

                if 
                ( 
                    ( strpos ( $lowercasePart, 'pagbabasa ng bibliya' ) !== false ) 
                    ||
                    ( strpos ( $lowercasePart, 'bible reading' ) !== false ) 
                    ||

                    ( 
                        ( strpos ( $lowercasePart, 'pahayag' ) !== false ) 
                        && 
                        ( 
                            ( strpos ( $lowercasePart, 'th' ) !== false ) 
                            || 
                            ( strpos ( $lowercasePart, 'ipaliwanag ang paniniwala mo' !== false )
                        )
                      )
                    )
                    ||
                    ( 
                        ( strpos ( $lowercasePart, 'talk' ) !== false ) 
                        && 
                        ( 
                            ( strpos ( $lowercasePart, 'th' ) !== false ) 
                            || 
                            ( strpos ( $lowercasePart, 'explaining your beliefs' !== false )
                        )
                      )
                    )
                ) { echo $isTagalog ? "<td class='col-2'> Estudyante: </td>" : "<td class='col-2'> Student: </td>";
                
                } else if (
                    strpos ( $lowercasePart, 'pagpapasimula ng pakikipag-usap' ) !== false ||
                    strpos ( $lowercasePart, 'starting a conversation' ) !== false ||
                    
                    strpos ( $lowercasePart, 'pagdalaw-muli' ) !== false ||
                    strpos ( $lowercasePart, 'following up' ) !== false ||
                    
                    strpos ( $lowercasePart, 'paggawa ng mga alagad' ) !== false ||
                    strpos ( $lowercasePart, 'making disciples' ) !== false ||

                    strpos ( $lowercasePart, 'ipaliwanag ang paniniwala mo' ) !== false ||
                    strpos ( $lowercasePart, 'explaining your beliefs' ) !== false
                    ) {
                    echo $isTagalog ? "<td class='col-2'> Estudyante/Katulong: </td>" : "<td class='col-2'> Student/Assistant: </td>";
                } else if ( 
                    strpos ( $lowercasePart, 'pag-aaral ng kongregasyon sa bibliya' ) !== false ||
                    strpos ( $lowercasePart, 'congregation bible study' ) !== false 
                    ) {
                    echo $isTagalog ? "<td class='col-2'> Konduktor/Tagabasa: </td>" : "<td class='col-2'> Conductor/Reader: </td>";
                } else {
                    echo "<td class='col-2'> </td>";
                }                  
                
                // Column 3 - Name of Assignee / Assistant
                if ( $row['assistant'] == " " || !$row['assistant'] ) {
                    echo "<td class='col-3'>{$row['assignee']}</td>";
                } else {
                    echo "<td class='col-3'>{$row['assignee']} / {$row['assistant']}</td>";
                }
                echo "</tr>";
                
                // Increment the assignment counter
                $assignmentCounter++;
                $partCounter++;

                // Check if it's the 5th assignment and insert the additional row
                if ( $assignmentCounter == 3 ) {
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
                if ( $i == $indexToKeep - 1 ) {
                    echo "<tr>";
                    echo "  <td colspan=2 style='width:80%; background-color: red; color: white;'>&nbsp;&nbsp;";
                    echo $isTagalog ? "<b> PAMUMUHAY BILANG KRISTIYANO </b>" : "<b> LIVING AS CHRISTIANS </b>";
                    echo "  </td>";
                    echo "  <td style='width:20%'></td>";
                    echo "</tr>";
                    echo "<tr>";
                    
                    $commonData['time'] = date("g:i", $startTime); // Convert the start time back to your desired format
                    $startTime += 3 * 60;  // Add 3 minutes (in seconds) to the start time
                    echo "  <td style='width:80%'>{$commonData['time']}&nbsp;&nbsp;&bull;&nbsp;&nbsp;{$commonData['song_mid']}</td>";  
                    echo "</tr>";
                }

                $closingTime = date ( "g:i", ( strtotime ( $commonData ['time'] ) + ( 30 * 60 ) ) );
            }

            echo "<tr>";
            $closingPart = $isTagalog ? "Pangwakas na Komento (3 min.)" : "Concluding Comments (3 min.)";
            echo "  <td class='col-1'>{$closingTime}&nbsp;&nbsp;&bull;&nbsp;&nbsp;{$closingPart} </td>";

            preg_match ( '/\((\d+)\W+min\.\)/', $closingPart, $matches );
            include 'extract_time.php';
            
            echo "  <td class='col-2'></td>";
            echo "  <td class='col-3'></td>";  
            echo "</tr>";
            
            $closingTime = date ( "g:i", ( strtotime ( $commonData ['time'] ) + ( 3 * 60 ) ) );
            
            echo "  <tr>";
            echo "    <td class='col-1'> {$closingTime}&nbsp;&nbsp;&bull;&nbsp;&nbsp;{$commonData['song_close']} {$and_prayer} </td>";
            echo "    <td class='col-2'> {$prayer} </td>";
            echo "    <td class='col-3'> {$row['assignee']} </td>";
            echo "  </tr>";
            echo "</table>";
        
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
