<?php

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

require("../private/secure.php");
require_once("../private/db_config.php");

$currentMonth = date('m');
$currentYear = date('Y');

$serviceYearStartMonth = 9;  // September
$serviceYearEndMonth = 8;  // August

// Determine the service year based on the current month
if ($currentMonth >= $serviceYearStartMonth) {
    $serviceYearStart = $currentYear;
    $serviceYearEnd = $currentYear + 1;
} else {
    $serviceYearStart = $currentYear - 1;
    $serviceYearEnd = $currentYear;
}

// YTD SQL Query to get the sum of hours and ldc between September of the current year to August of the next year
$ytd_sql = "SELECT SUM(hours) + SUM(ldc) as ytd FROM report WHERE owner = ? AND date BETWEEN ? AND ?";
$stmt = $con->prepare($ytd_sql);
$start_date = "{$serviceYearStart}-{$serviceYearStartMonth}-01";
$end_date = "{$serviceYearEnd}-{$serviceYearEndMonth}-31";
$stmt->bind_param("sss", $_SESSION['owner'], $start_date, $end_date);

$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

$_SESSION['ytd'] = round ( $row['ytd'], 2 );

$stmt->close();

// SQL Query to get the sum of hours and ldc for the current month
$curr_sql = "SELECT SUM(hours) as curr_hrs, SUM(ldc) as curr_ldc FROM report WHERE owner = ? AND MONTH(date) = ? AND YEAR(date) = ?";
$stmt = $con->prepare($curr_sql);
$stmt->bind_param("sis", $_SESSION['owner'], $currentMonth, $currentYear);

$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

$_SESSION['curr_hrs'] = round ( $row['curr_hrs'] + $row['curr_ldc'], 2 );

$stmt->close();

?>
