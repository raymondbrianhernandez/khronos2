<?php 

$temp_row = mysqli_fetch_assoc ( $result );
            
// Row for Chairman
$row1 = $assignmentTable->addRow ( $desiredCellHeight, array ( "exactHeight" => true ) );
$row1->addCell ( null, $cellStyle4in );
$cellChairmanTitle = $row1->addCell ( null, $cellStyle1_27in );
$cellChairmanTitle->addText ( 'Chairman: ', $fontStyleItalic, $rightAlignedParagraph );
$cellChairmanTitle->addSpacing(50);
$cellChairmanName = $row1->addCell ( null, $cellStyle2in );
$cellChairmanName->addText ( $temp_row['chairman'], $defaultFont );

// Row for Auxiliary Classroom Counselor
$row2 = $assignmentTable->addRow ( $desiredCellHeight, array ( "exactHeight" => true ) ); 
$row2->addCell ( null, $cellStyle4in );  
$cellAdvisorTitle = $row2->addCell ( null, $cellStyle1_27in );  
$advisorText = $isTagalog ? 'Tagapayo sa Karagdagang Klase: ' : 'Auxiliary Classroom Counselor: ';
$cellAdvisorTitle->addText ( $advisorText, $fontStyleItalic, $rightAlignedParagraph, $noSpace );  
$cellAdvisorName = $row2->addCell ( null, $cellStyle2in );  
$cellAdvisorName->addText ( $temp_row['advisor'], $defaultFont );  

/****************************************************************************/
/** Row for Opening Song & Prayer (Remaining Rows will follow this format) **/
/****************************************************************************/
// Create a new row in the table
$row3 = $assignmentTable->addRow ( $desiredCellHeight, array ( "exactHeight" => true ) ); 

// Column 1: Display Assignment (4 inches wide)
$cellOpeningText = "{$meetingStartTime} • {$commonData['song_open']} and Opening Prayer";
$cellOpening = $row3->addCell ( null, $cellStyle4in, $noSpace );  // Add an empty cell with a specific width
$cellOpening->addText ( $cellOpeningText, $defaultFont );  // Add the opening text to the cell

// Column 2: Optional (1.27 inch wide)
// Just uncomment the next two lines and replace 'Your Optional Text' with whatever text you'd like to insert.
$cellOptional = $row3->addCell ( null, $cellStyle1_27in, $noSpace );  
$cellOptional->addText ( 'Prayer: ', $fontStyleItalic, $rightAlignedParagraph ); 
//$row3->addCell(null, $cellStyle1_27in);  // The 2nd column remains blank

// Column 3: Display assignee's name (2 inches wide)
$cellAssignee = $row3->addCell ( null, $cellStyle2in, $noSpace );  // Add a cell for the assignee's name
$cellAssignee->addText ( $temp_row['assignee'], $defaultFont );  // Add the assignee's name to the name cell
/****************************************************************************/

?>