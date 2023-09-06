<?php

include ( 'db.php' );
include ( 'debug.php' );
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $midweek_date = $_POST["input-date"];
    $_SESSION['midweek_date'] = $midweek_date;
    
    $week_select = $_SESSION['week_select'];
    $query = "UPDATE songs SET select_week = '".$week_select."' WHERE select_week = '".$midweek_date."'";
    echo $query;
    if (mysqli_query($con, $query)) {
        // successfully updated the database
    }
    
    mysqli_close($con);
}

/* header("Location: admin.php");
exit(); */
?>
