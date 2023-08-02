<?php

require("../private/secure.php");
require_once("../private/db_config.php");
/* include("debug.php"); */ 
session_start();

$delete_query  = "DELETE FROM householders "; 
$delete_query .= "WHERE Address_ID = '" . $_POST['address_id'] . "'";

$result = mysqli_query($con, $delete_query);

if($result){
    header("Location: territories.php?page=".$_SESSION['page']);
} else {
    echo mysqli_error($con);
}

?>