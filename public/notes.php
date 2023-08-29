<?php

require("../private/secure.php");
require_once("../private/db_config.php");
/* include("debug.php"); */
session_start();

date_default_timezone_set("America/Los_Angeles");

$owner      = $_SESSION['owner'];
$date       = date("m/d/y") ." at ". date("h:ia");
$notes      = $_POST['notebook'];

$add_query  = "INSERT INTO notebook ";
$add_query .= "(Owner, Date, Notes) ";
$add_query .= "VALUES (";
$add_query .= "'" . $owner . "',"; 
$add_query .= "'" . $date . "',";
$add_query .= "'" . $notes . "'";
$add_query .= ")"; 

$result = mysqli_query($con, $add_query);

if($result){
    header("Location: journal.php");
} else {
    echo mysqli_error($con);
    /* echo $add_query; */
}

?>