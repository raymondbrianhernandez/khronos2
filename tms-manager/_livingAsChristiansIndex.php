<?php

$partsArray = [];
foreach ( $rows as $row ) {
    $partsArray[] = $row['part'];
}

// Define the array of phrases to look for
$phrasesToFind = ["th study", 
                  "lmd lesson", 
                  "lmd aralin", 
                  "th aralin",
                  "Pagpapasimula ng Pakikipag-usap",
                  "Starting a Conversation",
                  "Ipaliwanag ang Paniniwala Mo",
                  "Explaining Your Beliefs"
                ];

// Initialize $indexToKeep to null
$indexToKeep = null;

// Iterate starting from index 3
for ( $i = 2; $i < count ( $partsArray ); $i++ ) {
    $phraseFound = false;
    foreach ( $phrasesToFind as $phrase ) {
        if ( stripos ( $partsArray[$i], $phrase ) !== false ) {
            $phraseFound = true;
            break; // A phrase is found in this part
        }
    }

    if ( !$phraseFound ) {
        // If no phrase is found, save the index and stop searching
        $indexToKeep = $i;
        break;
    }
}

// $indexToKeep now holds the index of the first part where none of the specified phrases are found
// Debug: Check if indexToKeep is set
// echo "Index to Keep: " . $indexToKeep;

?>