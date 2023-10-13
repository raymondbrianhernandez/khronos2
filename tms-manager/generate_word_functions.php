<?php

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

?>
