<?php
// generate_word.php

if ( session_status() !== PHP_SESSION_ACTIVE ) {
    session_start();
}

include 'debug.php';
include '_functions.php';
include '_globals.php';
require 'db.php';
require 'vendor/autoload.php';

$current_timezone = date_default_timezone_get();

/************ All phpWord() related settings are here ************/
$phpWord = new \PhpOffice\PhpWord\PhpWord(); 

$sectionStyle = array(
    'paperSize' => 'A4',
    'marginLeft' => 720,    // 0.5 inch in twips (1 inch = 1440 twips)
    'marginRight' => 720,
    'marginTop' => 720,
    'marginBottom' => 720,
    'headerHeight' => 0,
    'footerHeight' => 0,
    'orientation' => 'portrait'  // Can be 'landscape' if you want.
);
$section = $phpWord->addSection ( $sectionStyle );
$availableWidth    = 10_464.8;  // 7.27 inches in twips
$availableHeight   = 427_680;
$desiredCellHeight = 300;
/*****************************************************************/

$month        = trim ( explode ( " ", $_SESSION['week_select'] )[0] );
$year         = $_SESSION['workbook_year'];
$congregation = $_SESSION['congregation'];
$start_time   = $_SESSION['midweek_time'];
$language     = $_SESSION['language'];
$isTagalog    = true;

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

// Prepared statements to avoid SQL injection
$song_result = getSongsForMonth ( $tmscon, $month, $year, $congregation );

if ( $song_result ) {
    $weekCounter = 0; // Initialize a counter to keep track of the weeks
    
    while ( $week_row = mysqli_fetch_assoc ( $song_result ) ) {

        $meetingStartTime = date ( "g:i", strtotime ( $week_row['time'] ) );
        
        // Fetch common data for the current week
        include 'generate_word_common_data.php';
        
        /******************** Letterhead Section *************************/
        include 'generate_word_letterhead.php';    

        /******************** Assignments Section ************************/
        include 'generate_word_assignments_styles.php'; 
        
        $result = getAssignmentsForWeek ( $tmscon, $congregation, $commonData['week'], $year );

        if ( $result ) {
            $assignmentCounter = 0; // Initialize a counter to keep track of assignments
            $partCounter = 0; // Initialize a counter to keep track of the parts per week
            
            /******************** Chairman, Advisor & Opening ************************/
            include 'generate_word_chairman_advisor_opening.php';
            
            $firstAssignment = true; 
            $startTime       = strtotime ( $commonData['time'] );
            $loopCount       = 0;

            // Fetch all results first
            $result->data_seek(0);
            $rows = mysqli_fetch_all ( $result, MYSQLI_ASSOC );

            // Count the total rows
            $totalRows = count ( $rows );

            include '_livingAsChristiansIndex.php';
            
            for ( $i = 0; $i < $totalRows; $i++ ) { 
                $row = $rows[$i];
                $loopCount++;

                // Extract duration time from each assignment, then add it to time
                preg_match ( '/\((\d+)\W+min\.\)/', $row['part'], $matches );
                include 'extract_time.php';

                /**************************  Main loop of assignments ***********************/
                /****************************************************************************/
                $rowAssignment = $assignmentTable->addRow ( $desiredCellHeight, array ( "exactHeight" => true ) );;
                
                // Column 1: Display Assignment (4 inches wide)
                if ( $isFullParts ) { // toggled from report.php
                    $trimmedPart = trimParts ( $row['part'] ); 
                    $partTitle = "{$commonData['time']} • {$trimmedPart}"; 
                } else {
                    $partTitle = "{$commonData['time']} • {$row['part']}"; 
                }
                $cellAssignment = $rowAssignment->addCell ( null, $cellStyle4in, $noSpace );
                $cellAssignment->addText ( $partTitle, $defaultFont ); 
                
                // Column 2: Optional (1.27 inch wide)
                $lowercasePart = strtolower($row['part']);
                
                if (strpos($lowercasePart, 'pagbabasa ng bibliya') !== false ||
                    strpos($lowercasePart, 'bible reading') !== false ||
                    strpos($lowercasePart, 'paggawa ng mga alagad') !== false ||
                    (strpos($lowercasePart, 'pahayag') !== false && strpos($lowercasePart, 'th') !== false) ||
                    strpos($lowercasePart, 'ipaliwanag ang paniniwala mo') !== false
                ) {
                    $partItalics = $isTagalog ? 'Estudyante: ' : 'Student: ';
                } else if (
                    strpos($lowercasePart, 'pagpapasimula ng pakikipag-usap') !== false ||
                    strpos($lowercasePart, 'pagdalaw-muli') !== false ||
                    strpos($lowercasePart, 'paggawa ng mga alagad') !== false ||
                    strpos($lowercasePart, 'ipaliwanag ang paniniwala mo') !== false
                ) {
                    $partItalics = $isTagalog ? 'Estudyante/Katulong: ' : 'Student/Assistant: ';
                } else if (strpos($lowercasePart, 'pag-aaral ng kongregasyon sa bibliya') !== false) {
                    $partItalics = $isTagalog ? 'Konduktor/Tagabasa: ' : 'Conductor/Reader: ';
                } else {
                    $partItalics = '';
                }
               
                $cellItalics = $rowAssignment->addCell ( null, $cellStyle1_27in, $noSpace );  // Add a cell with a specific width
                $cellItalics->addText ( $partItalics, $fontStyleItalic, $rightAlignedParagraph );  // Add your optional text to the cell

                // Column 3: Display assignee's name (2 inches wide)
                if ( $row['assistant'] == " " || !$row['assistant'] ) {
                    $partAssignee = $row['assignee'];
                } else {
                    $partAssignee = $row['assignee'] . ' / ' . $row['assistant'];
                }
                $cellAssignee = $rowAssignment->addCell ( null, $cellStyle2in, $noSpace );  // Add a cell for the assignee's name
                $cellAssignee->addText ( $partAssignee, $defaultFont );  // Add the assignee's name to the name cell
                /****************************************************************************/
                
                // Increment the assignment counter
                $assignmentCounter++;
                $partCounter++;

                // APPLY YOURSELF TO THE FIELD MINISTRY
                if ( $assignmentCounter == 3 ) {
                    $rowAssignment = $assignmentTable->addRow ( $desiredCellHeight, array ( "exactHeight" => true ) );;

                    // Column 1 & 2: Display Header (5.27 inches wide)
                    $cellAssignment = $rowAssignment->addCell ( null, array_merge ( $cellStyle1_2in, $cellApplyYourself, $noSpace ) );
                    $headerContent = $isTagalog ? "MAGING MAHUSAY SA MINISTERYO" : "APPLY YOURSELF TO THE FIELD MINISTRY";
                    $cellAssignment->addText ( $headerContent, $fontStyleWhiteBold ); 
                }

                // LIVING AS CHRISTIANS & Middle Song
                if ( $i == $indexToKeep - 1 ) {
                    $rowAssignment = $assignmentTable->addRow ( $desiredCellHeight, array ( "exactHeight" => true ) );;
                    $rowMiddleSong = $assignmentTable->addRow ( $desiredCellHeight, array ( "exactHeight" => true ) );;

                    // Column 1 & 2: Display Header (5.27 inches wide)
                    $cellAssignment = $rowAssignment->addCell ( null, array_merge ( $cellStyle1_2in, $cellLivingAsChristians, $noSpace ) );
                    $headerContent = $isTagalog ? "PAMUMUHAY BILANG KRISTIYANO" : "LIVING AS CHRISTIANS";
                    $cellAssignment->addText ( $headerContent, $fontStyleWhiteBold ); 

                    // Column 1: Display Middle Song (4 inches wide)
                    $midSongTime = $commonData['time'] = date("g:i", $startTime);
                    $startTime += 3 * 60;  // Add 3 minutes to the start time
                    $cellMiddleText = "{$midSongTime} • {$commonData['song_mid']}";
                    $cellMiddle =  $rowMiddleSong->addCell ( null, $cellStyle4in, $noSpace );  // Add an empty cell with a specific width
                    $cellMiddle->addText ( $cellMiddleText, $defaultFont );  // Add the opening text to the cell
                }
                $commonData['time'] = date ( "g:i", strtotime ( $commonData['time'] ) + 30 * 60 ); // Add 30 mins
            }
            $row3 = $assignmentTable->addRow ( $desiredCellHeight, array ( "exactHeight" => true ) ); 
            /* CLOSING COMMENTS */
            // Column 1: Display Assignment (4 inches wide)
            $openingPart = $isTagalog ? "Pangwakas na Komento (3 min.)" : "Closing Comments (1 min.)";

            $cellOpeningText = "{$commonData['time']} • {$openingPart}";
            $cellOpening = $row3->addCell ( null, $cellStyle4in, $noSpace );  // Add an empty cell with a specific width
            $cellOpening->addText ( $cellOpeningText, $defaultFont );  // Add the opening text to the cell

            // Column 2: Optional (1.27 inch wide)
            $row3->addCell ( null, $cellStyle1_27in );  // The 2nd column remains blank

            // Column 3: Display assignee's name (2 inches wide)
            $cellAssignee = $row3->addCell ( null, $cellStyle2in, $noSpace );  // Add a cell for the assignee's name
            $commonData['time'] = date ( "g:i", strtotime ( $commonData['time'] ) + 3 * 60 ); // Add 3 mins
            
            /* CLOSING SONG */
            // Create a new row in the table
            $lastRow = $assignmentTable->addRow ( $desiredCellHeight, array ( "exactHeight" => true ) );  

            // Column 1: Display Assignment (4 inches wide)
            $cellClosingText = $isTagalog ? "{$commonData['time']} • {$commonData['song_close']} at Pansarang Panalangin":
                                            "{$commonData['time']} • {$commonData['song_close']} and Closing Prayer";
            $cellClosing = $lastRow->addCell ( null, $cellStyle4in, $noSpace );  // Add an empty cell with a specific width
            $cellClosing->addText ( $cellClosingText, $defaultFont );  // Add the opening text to the cell

            // Column 2: Optional (1.27 inch wide)
            // Just uncomment the next two lines and replace 'Your Optional Text' with whatever text you'd like to insert.
            $cellOptional = $lastRow->addCell ( null, $cellStyle1_27in, $noSpace );  // Add a cell with a specific width
            $cellOptional->addText ( 'Prayer:', $fontStyleItalic, $rightAlignedParagraph ); 
            //$row3->addCell ( null, $cellStyle1_27in, $noSpace );  // The 2nd column remains blank

            // Column 3: Display assignee's name (2 inches wide)
            $cellAssignee = $lastRow->addCell ( null, $cellStyle2in, $noSpace );  // Add a cell for the assignee's name
            $cellAssignee->addText ( $row['assignee'], $defaultFont );  // Add the assignee's name to the name cell

            $rowHR = $assignmentTable->addRow ( $desiredCellHeight, array ( "exactHeight" => true ) );;
            $cellHR = $rowHR->addCell ( null, $cellHRtag, $noSpace );

            mysqli_free_result ( $result );
            $partCounter = 0;
        } 
        
        // Increment the week counter
        $weekCounter++;
        
    }
    mysqli_free_result ( $song_result );

} else {
    echo "Error executing query for songs: " . mysqli_error ( $tmscon );
} 

// Close the database connection when you're done
mysqli_close ( $tmscon );

// This outputs to .docx
$objWriter = \PhpOffice\PhpWord\IOFactory::createWriter ( $phpWord, 'Word2007' );
header ( 'Content-Type: application/octet-stream' );
header ( 'Content-Disposition: attachment;filename="OCLM_Schedule.docx"' );
$objWriter->save ( 'php://output' ); 

?>
