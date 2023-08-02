<?php

require("../private/secure.php");
require_once("../private/db_config.php");
/* include("debug.php"); */
session_start();

date_default_timezone_set("America/Los_Angeles");

$add_query  = "INSERT INTO report ";
$add_query .= "(owner, service_year, date, hours, placements, video, rv, bs, ldc) ";
$add_query .= "VALUES (";
$add_query .= "'" . $_SESSION['owner'] . "',"; 
$add_query .= "'" . $_POST['service_year'] . "',";
$add_query .= "'" . $_POST['date'] . "',";
$add_query .= "'" . $_POST['hours'] . "',";
$add_query .= "'" . $_POST['placements'] . "',";
$add_query .= "'" . $_POST['video'] . "',";
$add_query .= "'" . $_POST['rv'] . "',";
$add_query .= "'" . $_POST['bs'] . "',";
$add_query .= "'" . $_POST['ldc'] . "'";
$add_query .= ")";

$result = mysqli_query($con, $add_query);
/* echo $add_query; */
if( $result ){
    header("Location: hours.php");
} else {
    echo mysqli_error($con);
}

?>