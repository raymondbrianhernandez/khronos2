<?php
require 'vendor/autoload.php';
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\SimpleType\Jc;
use PhpOffice\PhpWord\Style\Cell;

// Initialize PHPWord
$phpWord = new PhpWord();

// Set Default Font and Font Size
$phpWord->setDefaultFontName('Calibri');
$phpWord->setDefaultFontSize(10);

// Add a Section
$section = $phpWord->addSection();

// Define the Style for the Title
$section->addText(
    'OCLM Report by Khronos Pro 2',
    array('name' => 'Arial', 'size' => 14, 'bold' => true),
    array('alignment' => Jc::CENTER)
);

// Connect to the Database and Fetch Data
// Replace with your database connection and fetching logic
require ('db.php');

// Check Session and Set Default Values
session_start();
$monthPart = explode(" ", $_SESSION['week_select'] ?? 'January');
$congregation = $_SESSION['congregation'] ?? 'Some Congregation';
$month = $monthPart[0];
$language = $_SESSION['language'] ?? 'English';
$isTagalog = $language === "Tagalog";

// Fetch and Iterate over the Data
$song_query = "SELECT * FROM songs WHERE year = YEAR(CURDATE()) AND select_week LIKE '$month%'";
$song_result = mysqli_query($con, $song_query);
if($song_result) {
    while ($week_row = mysqli_fetch_assoc($song_result)) {
        // Process Each Row Here
        $date = date("F j, Y", strtotime($week_row['date']));
        $section->addText($date, ['bold' => true]);
        
        // Fetch assignment data for the current week
        $week = $week_row['select_week'];
        $query = "SELECT * FROM assignments WHERE congregation = '$congregation' AND year = YEAR(CURDATE()) AND week = '$week'";
        $result = mysqli_query($con, $query);
        
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $table = $section->addTable();
                $table->addRow();
                $cell1 = $table->addCell(5000, ['valign' => 'center', 'bgColor' => 'F2F2F2']);
                $cell1->addText($row['part'], ['name' => 'Arial', 'size' => 8]);
                
                $cell2 = $table->addCell(5000, ['valign' => 'center', 'bgColor' => 'F2F2F2']);
                $assistant = $row['assistant'] == " " ? "" : " / {$row['assistant']}";
                $cell2->addText("{$row['assignee']}$assistant", ['name' => 'Arial', 'size' => 8]);
            }
            mysqli_free_result($result);
        }
    }
    mysqli_free_result($song_result);
}
mysqli_close($con);

// Save File
$writer = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
$filename = 'OCLM_Report_by_Khronos_Pro_2.docx';

header('Content-Type: application/octet-stream');
header("Content-Disposition: attachment; filename=$filename");

$writer->save('php://output');
