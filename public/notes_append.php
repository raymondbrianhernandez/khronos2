<?php

require("../private/secure.php");
require_once("../private/db_config.php");
/* include("debug.php"); */
session_start();

date_default_timezone_set("America/Los_Angeles");

$update_query  = "UPDATE notebook SET ";
$update_query .= "id ='" . $_POST['id'] . "', "; 
$update_query .= "owner = '" . $_SESSION['owner'] . "', ";
$update_query .= "date = '" . $_POST['date'] . "', ";
$update_query .= "notes ='" . $_POST['notes'] . "'"; 
$update_query .= "WHERE id = " . $_POST['id'] . "";

$result = mysqli_query($con, $update_query);
echo $update_query;
if($result){
    header("Location: journal.php");
} else {
    echo mysqli_error($con);
    /* echo $update_query; */
} 

?>