<?php

include('db.php');
include('debug.php');

$congregation = mysqli_real_escape_string($con, $_POST['congregation']);
$first_name = mysqli_real_escape_string($con, $_POST['first_name']);
$last_name = mysqli_real_escape_string($con, $_POST['last_name']);
$privilege = mysqli_real_escape_string($con, $_POST['privilege']);

$query = "INSERT INTO publishers (congregation, first_name, last_name, privilege)
        VALUES ('$congregation', '$first_name', '$last_name', '$privilege')";
mysqli_query($con, $query);
mysqli_close($con);
header("Location: publishers.php");

?>

