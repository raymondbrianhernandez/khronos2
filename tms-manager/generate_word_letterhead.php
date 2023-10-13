<?php 

// Border color set to white
$whiteBorders = array(
    'borderTopColor' => 'FFFFFF',
    'borderBottomColor' => 'FFFFFF',
    'borderLeftColor' => 'FFFFFF',
    'borderRightColor' => 'FFFFFF'
);

// Define table style with white borders
$tableStyle = array(
    'cellMargin' => [
        'top' => 0,
        'bottom' => 0,
      ],
    'width' => $availableWidth,
) + $whiteBorders;

// Adjusted cell style (set borderColor to white)
$cellStyle = array(
    'valign' => 'center',
    'width' => $availableWidth / 2,  // Half of the available width
    'cellMargin' => 80,
    'bgColor' => 'FFFFFF',
    'borderColor' => 'FFFFFF',
    'cellRowSpan' => $desiredCellHeight,
);

// Font styles
$fontStyleH3 = array(
    'name' => 'Cambria',
    'size' => 12,  
    'bold' => true
);

$fontStyleDateVerse = array(
    'name' => 'Cambria',
    'size' => 10,
    'bold' => true
);

$phpWord->addTableStyle('whiteBorderTable', $tableStyle);

// Create the table using the white-border style
$letterheadTable = $section->addTable('whiteBorderTable');

// First Row
$letterheadTableRow1 = $letterheadTable->addRow();

// First cell of the first row
$letterheadTableCell1 = $letterheadTableRow1->addCell ( null, $cellStyle );
$letterheadTableCell1->addText ( strtoupper ( $congregation ) . ' CONGREGATION', $fontStyleH3 );

// Second cell of the first row
$letterheadTableCell2 = $letterheadTableRow1->addCell ( null, $cellStyle );
if ( $isTagalog ) {
    $letterheadTableCell2->addText ( 'Iskedyul ng Pulong sa Gitnang Sanlinggo', $fontStyleH3 );
} else {
    $letterheadTableCell2->addText ( 'Midweek Meeting Schedule', $fontStyleH3 );
}

// Second Row
$letterheadTableRow2 = $letterheadTable->addRow();

// First cell of the second row
$letterheadTableCell3 = $letterheadTableRow2->addCell ( null, $cellStyle );
$letterheadTableCell3->addText ( $commonData['date'] . " | " . $commonData['verse'], $fontStyleDateVerse );

// Second cell of the second row
$letterheadTableCell4 = $letterheadTableRow2->addCell ( null, $cellStyle ); 

?>
