<?php

if ( session_status() !== PHP_SESSION_ACTIVE ) {
    session_start();
}

require ( "../private/secure.php" );
require_once ( "../private/db_config.php" );

// if one of the reports are loaded (like 'curr_mon') was fetched already, skip the rest of the code
if ( $_SESSION['curr_mon'] ) {
    return;
} else { // otherwise fetch all data needed
    $_SESSION['curr_mon'] = date('m');
    $_SESSION['prev_mon_temp'] = ( int ) date ( 'm', strtotime ( 'last month' ) );
    $monthNames = array(1 => 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
    $_SESSION['prev_mon'] = $monthNames[$_SESSION['prev_mon_temp']];

    $_SESSION['curr_year'] = date('Y');
    $_SESSION['prev_year'] = ( string )( ( int ) date ( 'Y' ) - 1 );

    $serviceYearStartMonth = 9;  // September

    // SQL Queries 
    $sql = "SELECT ";
    $sql .= "sum(hours) as hours, ";
    $sql .= "sum(placements) as placements, ";
    $sql .= "sum(video) as video, ";
    $sql .= "sum(rv) as rv, ";
    $sql .= "sum(bs) as bs, ";
    $sql .= "sum(ldc) as ldc, ";
    $sql .= "MONTH(date) as month ";
    $sql .= "FROM  report ";
    $sql .= "WHERE owner = '" . $_SESSION['owner'] . "' AND date BETWEEN '";
    $base_sql = $sql;

    $_SESSION['sql'] = array();
    for ( $m = 9; $m <= 12; $m++ ) {
        $_SESSION['sql'][$m] = $base_sql . $_SESSION['curr_year'] . "-$m-01' AND '" . $_SESSION['curr_year'] . "-$m-31' GROUP BY month";
    }

    $next_year = $_SESSION['curr_year'] + 1;
    for ( $m = 1; $m <= 8; $m++ ) {
        $_SESSION['sql'][$m] = $base_sql . $next_year . "-$m-01' AND '" . $next_year . "-$m-31' GROUP BY month";
    }

    // Monthly Reports
    foreach ( $_SESSION['sql'] as $month => $query ) { 
        $result = $con->query ( $query )->fetch_row();
        $_SESSION["{$month}_hrs"] = round ( $result[0], 2 );
        $_SESSION["{$month}_plc"] = $result[1];
        $_SESSION["{$month}_vid"] = $result[2];
        $_SESSION["{$month}_rvs"] = $result[3];
        $_SESSION["{$month}_bss"] = $result[4];
        $_SESSION["{$month}_ldc"] = $result[5];
    }

    // CURRENT MONTH'S REPORT
    $curr = "SELECT ";
    $curr .= "SUM(hours) hours, ";
    $curr .= "SUM(placements) placements , ";
    $curr .= "SUM(video) video, SUM(rv) rv, ";
    $curr .= "SUM(bs) bs, ";
    $curr .= "SUM(ldc) ldc ";
    $curr .= "FROM report WHERE ";
    $curr .= "owner='" . $_SESSION['owner'] . "' ";
    $curr .= "AND date BETWEEN CURDATE() - INTERVAL (DAY(CURDATE())-1) DAY ";
    $curr .= "AND LAST_DAY(CURDATE())";

    $result = $con->query($curr)->fetch_row();
    $_SESSION['curr_hrs'] = round($result[0], 2);
    $_SESSION['curr_plc'] = round($result[1], 2);
    $_SESSION['curr_vid'] = round($result[2], 2);
    $_SESSION['curr_rvs'] = round($result[3], 2);
    $_SESSION['curr_bss'] = round($result[4], 2);
    $_SESSION['curr_ldc'] = round($result[5], 2);

    // LAST MONTHS REPORT
    $prev = "SELECT ";
    $prev .= "SUM(hours) hours, ";
    $prev .= "SUM(placements) placements , ";
    $prev .= "SUM(video) video, SUM(rv) rv, ";
    $prev .= "SUM(bs) bs, ";
    $prev .= "SUM(ldc) ldc ";
    $prev .= "FROM report WHERE ";
    $prev .= "owner='" . $_SESSION['owner'] . "' ";
    $prev .= "AND date BETWEEN DATE_SUB(CURDATE(), INTERVAL 1 MONTH) ";
    $prev .= "AND LAST_DAY(DATE_SUB(CURDATE(), INTERVAL 1 MONTH))";

    $result = $con->query($prev)->fetch_row();
    $_SESSION['prev_hrs'] = round($result[0], 2);
    $_SESSION['prev_plc'] = round($result[1], 2);
    $_SESSION['prev_vid'] = round($result[2], 2);
    $_SESSION['prev_rvs'] = round($result[3], 2);
    $_SESSION['prev_bss'] = round($result[4], 2);
    $_SESSION['prev_ldc'] = round($result[5], 2);

    $_SESSION['text_msg'] = "Dear Bro. " . $_SESSION['elder_name'] . ",\n\n";
    $_SESSION['text_msg'] .= "Here's my monthly report: \n";
    $_SESSION['text_msg'] .= "Hours: " . ($_SESSION['prev_hrs'] + $_SESSION['prev_ldc']) . "\n";
    $_SESSION['text_msg'] .= "Placements: " . $_SESSION['prev_plc'] . "\n";
    $_SESSION['text_msg'] .= "Videos shown: " . $_SESSION['prev_vid'] . "\n";
    $_SESSION['text_msg'] .= "Return Visits: " . $_SESSION['prev_rvs'] . "\n";
    $_SESSION['text_msg'] .= "Bible Studies: " . $_SESSION['prev_bss'] . "\n\n";
    $_SESSION['text_msg'] .= "YTD Hours: " . $_SESSION['ytd'] . "\n";
    $_SESSION['text_msg'] .= "Thanks for all your hard work.\n";
    $_SESSION['text_msg'] .= $_SESSION['firstname'];
}