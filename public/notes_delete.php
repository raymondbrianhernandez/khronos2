<?php

require("../private/secure.php");
require_once("../private/db_config.php");
/* include("debug.php"); */
session_start();

$delete_query  = "DELETE FROM notebook "; 
$delete_query .= "WHERE id = '" . $_POST['id'] . "'";

$result = mysqli_query($con, $delete_query);

if($result){
    header("Location: journal.php");
} else {
    echo mysqli_error($con);
}

?>