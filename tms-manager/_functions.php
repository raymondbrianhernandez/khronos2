<?php
/**
 * 
 * All PHP functions for khronos.pro
 * by Raymond Hernandez
 * Last update: November 26, 2023
 * 
 */


 // Define a function to convert a date string to a standard format
function stringToDate ( $dateString ) {
    return date ( 'Y-m-d', strtotime ( $dateString ) );
}


// Function to convert time string to an integer for comparison
function timeToInt ( $time ) {
    $parts = explode ( ':', $time );
    return ( int ) $parts[0] * 60 + ( int ) $parts[1];
}


/**
 * convertToEnglishMonths Function
 * 
 * Converts Tagalog month names to English.
 *
 * @param string $month The month name in Tagalog.
 * 
 * @return string       The month name in English.
 */
function convertToEnglishMonths ( $buwan ) {
    $tagalogToEnglish = [
        'Enero' => 'January', 'Pebrero' => 'February', 'Marso' => 'March',
        'Abril' => 'April', 'Mayo' => 'May', 'Hunyo' => 'June',
        'Hulyo' => 'July', 'Agosto' => 'August', 'Setyembre' => 'September',
        'Oktubre' => 'October', 'Nobyembre' => 'November', 'Disyembre' => 'December'
    ];
    return $tagalogToEnglish[$buwan] ?? $buwan;
}


function convertToTagalogMonths ( $month ) {
    $englishToTagalog = [
        'January' => 'Enero', 'February' => 'Pebrero', 'March' => 'Marso',
        'April' => 'Abril', 'May' => 'Mayo', 'June' => 'Hunyo',
        'July' => 'Hulyo', 'August' => 'Agosto', 'September' => 'Setyembre',
        'October' => 'Oktubre', 'November' => 'Nobyembre', 'December' => 'Disyembre'
    ];
    return $englishToTagalog[$month] ?? $month;
}


/**
 * parseWeekToDate Function
 * 
 * Parses a week string and converts it to a date, with support for Tagalog month names.
 *
 * @param string $week The week string.
 * @param bool $isTagalog Indicates if the month name is in Tagalog.
 * @return string The date in 'Y-m-d' format.
 */
function parseWeekToDate ( $week, $isTagalog ) {
    $parts = explode ( "-", $week );
    $startDate = trim ( $parts[0] );

    if ( $isTagalog ) {
        // Assuming the format is "Nobyembre 6"
        preg_match ( '/(\w+) (\d+)/', $startDate, $matches );
        if ( count ( $matches ) == 3 ) {
            $month = convertToEnglishMonths ( $matches[1] );
            $day = $matches[2];
            $startDate = "$month $day";
        }
    }

    return date ( "Y-m-d", strtotime ( $startDate ) );
}


/**
 * checkOverlaps Function
 * 
 * Checks for overlapping or recent assignments.
 *
 * @param mysqli $tmscon Database connection object.
 * @param string $assignee The name of the assignee.
 * @param string $week The week string.
 * @param string $year The year.
 * @param bool $isTagalog Indicates if the month name is in Tagalog.
 * @return string Returns "overlap", "recent", or "none".
 */
function checkRecent ( $tmscon, $assignee, $week, $year, $isTagalog, $congregation) {
    if ( empty ( $assignee ) ) {
        return "none";
    }

    $referenceDate = parseWeekToDate ( $week, $isTagalog );
    $weekStart = date ( "Y-m-d", strtotime ( $referenceDate ) ); // Start of the current week

    // Fetch all assignments within the last month
    $recentQuery = "SELECT week FROM assignments 
                    WHERE (? IN (assignee, assistant)) 
                    AND year = ? AND congregation = ?";
    $stmt = $tmscon->prepare ( $recentQuery );
    $stmt->bind_param ( "sss", $assignee, $year, $congregation );
    $stmt->execute();
    $recentResult = $stmt->get_result();

    $messages = [];
    while ( $row = $recentResult->fetch_assoc() ) {
        $assignmentDate = parseWeekToDate ( $row['week'], $isTagalog );
        $weeksAgo = ( strtotime ( $weekStart ) - strtotime ( $assignmentDate ) ) / ( 60 * 60 * 24 * 7 );

        if ( $weeksAgo > 0 && $weeksAgo <= 1 ) {
            $messages[] = "a week ago";
        } elseif ( $weeksAgo > 1 && $weeksAgo <= 2 ) {
            $messages[] = "two weeks ago";
        } elseif ( $weeksAgo > 2 && $weeksAgo <= 3 ) {
            $messages[] = "three weeks ago";
        } elseif ( $weeksAgo > 3 && $weeksAgo <= 4 ) {
            $messages[] = "a month ago"; 
        }
    }

    if ( !empty ( $messages ) ) {
        $uniqueMessages = array_unique ( $messages );
        $messageCount = count ( $uniqueMessages );

        if ( $messageCount == 1 ) {
            $messageStr = "had an assignment " . $uniqueMessages[0];
        } elseif ( $messageCount == 2 ) {
            $messageStr = "had assignments " . implode ( " and ", $uniqueMessages );
        } else {
            $lastMessage = array_pop ( $uniqueMessages ); // Remove and save the last message
            $messageStr = "had assignments " . implode ( ", ", $uniqueMessages ) . ", and " . $lastMessage;
        }

        return $assignee . " " . $messageStr;
    }
    
    return "none";
}


/**
 * Checks for overlaps in assignments within the same submission batch.
 * 
 * This function iterates through arrays of publishers (assignees) and assistants
 * to determine if the person in the current index has been assigned more than 
 * once in the same submission batch, either as an assignee or as an assistant.
 * It can check for overlaps specifically for assignees or assistants based on 
 * the flag provided.
 *
 * @param array $publishers Array of publishers where each element represents an assignee for a part.
 * @param array $assistants Array of assistants where each element represents an assistant for a part.
 * @param int $currentIndex The current index in the loop to check for overlaps against other elements.
 * @param bool $checkAssignee Flag to indicate whether to check for overlaps in assignee (true) 
 *                            or assistant (false) roles.
 * 
 * @return string Returns "overlap" if an overlap is found for the current person, "none" otherwise.
 */
function checkArrayOverlaps ( $publishers, $assistants, $currentIndex, $checkAssignee = true ) {
    $currentPerson = $checkAssignee ? $publishers[$currentIndex] : $assistants[$currentIndex];

    for ( $i = 0; $i < count ( $publishers ); $i++ ) {
        if ( $i != $currentIndex ) {
            if ( $checkAssignee && ( $publishers[$i] == $currentPerson || $assistants[$i] == $currentPerson ) ) {
                return "overlap";
            }
            if ( !$checkAssignee && ( $assistants[$i] == $currentPerson ) ) {
                return "overlap";
            }
        }
    }
    return "none";
}


/**
 * fetchContent Function
 * 
 * Handles cURL requests to fetch content from a given URL.
 *
 * This function simplifies making cURL requests by encapsulating the common setup and execution steps.
 * It returns the response from the URL or false if the request fails.
 *
 * @param string $url The URL from which to fetch content.
 * @param resource $curl A cURL handle on success, false on errors.
 * @return string|bool The response as a string if successful, or false on failure.
 */
function fetchContent ( $url, $curl ) {
    curl_setopt ( $curl, CURLOPT_URL, $url );
    curl_setopt ( $curl, CURLOPT_RETURNTRANSFER, true );
    $response = curl_exec ( $curl );

    if ( $response === FALSE ) {
        return false;  // handle error as needed
    }

    return $response;
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
 * @param string $year         The desired year for which songs need to be retrieved.
 * @param string $congregation The desired congregation for which songs need to be retrieved.
 * 
 * @return mysqli_result       Result set containing songs for the specified month.
 */
function getSongsForMonth ( $con, $month, $year, $congregation ) {
    $stmt = $con->prepare ( "SELECT * FROM songs WHERE year = ? AND congregation = ? AND select_week LIKE ?" );
    $like_value = $month . "%";
    $stmt->bind_param ( "sss", $year, $congregation, $like_value );
    $stmt->execute();
    // echo "SELECT * FROM songs WHERE year = $year AND select_week LIKE $like_value <br>"; // For Debug

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
function getAssignmentsForWeek ( $con, $congregation, $week, $year ) {
    $stmt = $con->prepare ( "SELECT * FROM assignments WHERE congregation = ? AND year = ? AND week = ?" );
    $stmt->bind_param ( "sss", $congregation, $year, $week );
    $stmt->execute();
    return $stmt->get_result();
}

?>
