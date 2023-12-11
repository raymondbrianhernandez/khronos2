<?php

// Check if language is in Tagalog, default is in English
if ( $language != "Tagalog" ) { 
    $isTagalog = false; 
}

// Parts can be trimmed without study source to preserve spacing in Word documents
// e.g. (Original String) 5. Pagpapasimula ng Pakikipag-usap (4 min.) 
//                           DI-PORMAL NA PAGPAPATOTOO. Ipakita sa kausap mong may maliliit 
//                           pang anak kung paano maghahanap sa jw.org ng impormasyong 
//                           makakatulong sa mga magulang. (lmd aralin 1: #4)
//
//     (Shortened String) 5. Pagpapasimula ng Pakikipag-usap (4 min.)
if ( !isset ( $_SESSION['$isFullParts'] ) ) {
    $_SESSION['$isFullParts'] = false;
}

$isFullParts = $_SESSION['$isFullParts'];

if ( isset ( $_POST['view_full_parts'] ) ) {
    $_SESSION['$isFullParts'] = !$_SESSION['$isFullParts']; // Toggles 
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

?>