<?php

/* This script resets the time and submits total hours */

require("../private/secure.php");
require_once("../private/db_config.php");
/* include("debug.php"); */
session_start();

$owner = $_SESSION['owner'];
$date = date('Y-m-d');
$hours = $_SESSION['totalTime'];
$service_year = $_SESSION['service_year'];

$insert_sql  = "INSERT INTO `report`";
$insert_sql .= "(`owner`, `service_year`, `date`, `hours`) VALUES (";
$insert_sql .= "'" . $owner . "',";
$insert_sql .= "'" . $service_year . "',";
$insert_sql .= "'" . $date . "',";
$insert_sql .= "'" . $hours . "' ";
$insert_sql .= ")";
/* mysqli_query($con, $insert_sql); */

/* print_r($_SESSION); */

if ( mysqli_query($con, $insert_sql) ) { ?>
    <script type = "text/javascript">
        alert ("Your total time is being logged.");
        window.location = ("hours.php#clock");
    </script>
    <?php 
    } else { 
    ?>
    <script type = "text/javascript">
        alert ("ERROR: Your time can't be logged.");
        /* window.location = ("hours.php#clock"); */
    </script>
<?php }

/* if ( $_SESSION['startTime'] && $_SESSION['endTime'] ) {
    mysqli_query($con, $insert_sql); ?>
    <script type = "text/javascript">
        alert ("Your total time is being logged.");
        window.location = ("hours.php#clock");
    </script>
    <?php 
    } else { 
    ?>
    <script type = "text/javascript">
        alert ("ERROR: Your time can't be logged.");
        window.location = ("hours.php#clock");
    </script>
<?php } */

?>