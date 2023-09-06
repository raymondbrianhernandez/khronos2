<?php

include('db.php');
include('debug.php');

$id = $_GET['id'];
$query = "DELETE FROM publishers WHERE id=$id";
mysqli_query($con, $query);
mysqli_close($con);
header("Location: publishers.php");
?>
