<?php 
// generate_word_assignments_styles.php

// Define table styles with white borders
$whiteBordersTable = array(
    'borderTopColor' => 'FFFFFF',
    'borderBottomColor' => 'FFFFFF',
    'borderLeftColor' => 'FFFFFF',
    'borderRightColor' => 'FFFFFF'
);

$assignmentTableStyle = array (
    'width' => $availableWidth
) + $whiteBordersTable;

// Cell styles
$noSpace = array ( 'spaceAfter' => 0 );

// Define cell border styles with white borders
$whiteBordersCell = array (
    'borderTopSize' => 0,
    'borderBottomSize' => 0,
    'borderLeftSize' => 0,
    'borderRightSize' => 0,
    'borderTopColor' => 'FFFFFF',
    'borderBottomColor' => 'FFFFFF',
    'borderLeftColor' => 'FFFFFF',
    'borderRightColor' => 'FFFFFF'
);

// Column equivalent as <hr>
$cellHRtag = array (
    'width' => $availableWidth,
    'cellRowSpan' => $desiredCellHeight, 
    'borderTopSize' => 6,
    'borderTopColor' => 'black',
    'gridSpan' => 3,
);

// Column 1
$cellStyle4in = array_merge ( $whiteBordersCell, array (
    'valign' => 'center',
    'width' => 0.56 * $availableWidth, // 4 inches in twips relative to availableWidth
    'textAlign' => 'left',
    'cellRowSpan' => $desiredCellHeight,
));

// Column 2
$cellStyle1_27in = array_merge ( $whiteBordersCell, array (
    'valign' => 'center',
    'width' => 0.17 * $availableWidth,  // 1.27 inches in twips relative to availableWidth
    'textAlign' => 'right',
    'fontSize' => 8,
    'italic' => true,
    'cellRowSpan' => $desiredCellHeight,
));

// Column 3
$cellStyle2in = array_merge ( $whiteBordersCell, array (
    'valign' => 'center',
    'width' => 0.27 * $availableWidth, // 2 inches in twips relative to availableWidth
    'textAlign' => 'left',
    'cellRowSpan' => $desiredCellHeight,
));

// Column 1 and 2 Spanned
$cellStyle1_2in = array_merge ( $whiteBordersCell, array (
    'valign' => 'center',
    'width' => 0.73 * $availableWidth,
    'textAlign' => 'left',
    'cellRowSpan' => $desiredCellHeight,
    'gridSpan' => 2,
));

// Font style for italic text
$fontStyleItalic = array (
    'name' => 'Cambria',
    'size' => 8,
    'italic' => true,
);

$rightAlignedParagraph = array (
    'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::RIGHT,
    'spaceAfter' => 200
);

$defaultFont = array (
    'name' => 'Cambria',
    'size' => 10
);

$cellTreasures = array (
    'bgColor' => 'silver',
    'gridSpan' => 2,
    'valign' => 'center'
);

$cellApplyYourself = array (
    'bgColor' => 'B8860B',
    'gridSpan' => 2,
    'valign' => 'center'
);

$cellLivingAsChristians = array (
    'bgColor' => 'FF0000',  // Red color
    'gridSpan' => 2,
    'valign' => 'center'
);

$fontStyleWhiteBold = array (
    'bold' => true, 
    'color' => 'white'
);

$phpWord->addTableStyle ( 'assignmentTable', $assignmentTableStyle );
$assignmentTable = $section->addTable ( 'assignmentTable' );

?>
