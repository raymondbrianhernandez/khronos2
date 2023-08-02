<?php

require("../private/secure.php");
/* require_once("./php/simple_html_dom.php"); */
require_once("../private/db_config.php");
include("debug.php");
session_start();
date_default_timezone_set("America/Los_Angeles");

$url = $_POST['links'];
$desc = "website";

function format_to_href($url, $desc) {
    return '<a href=' . $url . ' target=_"blank">' . $desc . '</a>'; 
}

$owner      = $_SESSION['owner'];
$date       = date("m/d/Y") ." at ". date("h:ia");
$notes      = format_to_href($url, $desc);

echo format_to_href($url, $desc);
$add_query  = "INSERT INTO notebook ";
$add_query .= "(Owner, Date, Notes) ";
$add_query .= "VALUES (";
$add_query .= "'" . $owner . "',"; 
$add_query .= "'" . $date . "',";
$add_query .= "'" . $notes . "'";
$add_query .= ")";
echo $notes;
/* $result = mysqli_query($con, $add_query);

if($result){
    header("Location: journal.php");
} else {
    echo mysqli_error($con);
} */

?>