<?php

if ( session_status() !== PHP_SESSION_ACTIVE ) {
        session_start();
    }

include ( 'db.php' );
// include ( 'debug.php' );

$congregation = $_SESSION['congregation'];
$first_name   = mysqli_real_escape_string ( $con, $_POST['first_name'] );
$last_name    = mysqli_real_escape_string ( $con, $_POST['last_name'] );
$privilege    = mysqli_real_escape_string ( $con, $_POST['privilege'] );

// Check if the name already exists
$checkQuery = "SELECT * FROM publishers WHERE first_name='$first_name' AND last_name='$last_name' AND congregation='$congregation'";
$checkResult = mysqli_query ( $con, $checkQuery );

if ( mysqli_num_rows ( $checkResult ) > 0 ) {
    // Name already exists
    echo "<script>alert('$first_name $last_name is already registered in the congregation!'); window.location.href='publishers';</script>";
} else {
    // Name doesn't exist, proceed with the insert
    $query = "INSERT INTO publishers (congregation, first_name, last_name, privilege)
            VALUES ('$congregation', '$first_name', '$last_name', '$privilege')";
    mysqli_query ( $con, $query );
    echo "<script>alert('$first_name $last_name is added in the congregation!'); window.location.href='publishers';</script>";
}

mysqli_close ( $con );

?>
