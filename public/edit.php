<?php

require("../private/secure.php");
require_once("../private/db_config.php");
/* include("debug.php");  */
session_start();

$update_query  = "UPDATE householders SET ";
$update_query .= "status ='" . $_POST['dropdown'] . "', ";
$update_query .= "name ='" . $_POST['name'] . "', ";
$update_query .= "suite ='" . $_POST['suite'] . "', ";
$update_query .= "address ='" . $_POST['address'] . "', ";
$update_query .= "city ='" . $_POST['city'] . "', ";
$update_query .= "province ='" . $_POST['province'] . "', ";
$update_query .= "postal_code ='" . $_POST['postal_code'] . "', ";
$update_query .= "telephone ='" . $_POST['telephone'] . "', ";
$update_query .= "notes ='" . $_POST['notes'] . "' ";
$update_query .= "WHERE Address_ID = " . $_POST['address_id'] . "";

$result = mysqli_query($con, $update_query);

if($result){
    header("Location: territories.php");
} else {
    echo mysqli_error($con);
}

?>