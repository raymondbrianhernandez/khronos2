<?php

/* include( "debug.php" ); */
require( "../private/secure.php" );
require_once( "../private/db_config.php" );
session_start();

$curr_mon = date( 'm' );
$prev_mon = ( string )( ( int ) date( 'F' ) - 1 );
$monthNames = array( 1 => 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December' );
$prev_mon_temp = date( 'm', strtotime( 'last month' ) );
$prev_mon = $monthNames[$prev_mon_temp];

$curr_year = date( 'Y' );
$prev_year = ( string )( ( int ) date( 'Y' ) - 1);

// Let's query all sums per month
$sql  = "SELECT "; 
$sql .= "sum(hours) as hours, "; 
$sql .= "sum(placements) as placements, ";
$sql .= "sum(video) as video, ";
$sql .= "sum(rv) as rv, ";
$sql .= "sum(bs) as bs, ";
$sql .= "sum(ldc) as ldc, ";
$sql .= "MONTH(date) as month ";
$sql .= "FROM  report ";
$sql .= "WHERE owner = '" . $_SESSION['owner']. "' AND date BETWEEN '";

// Service year is from September 1st to August 31st
/* $all = $sql .  $prev_year . "-09-01' AND '" . $curr_year . "-08-31' GROUP BY year"; */
$sep = $sql .  $prev_year . "-09-01' AND '" . $prev_year . "-09-31' GROUP BY month";
$oct = $sql .  $prev_year . "-10-01' AND '" . $prev_year . "-10-31' GROUP BY month"; 
$nov = $sql .  $prev_year . "-11-01' AND '" . $prev_year . "-11-31' GROUP BY month"; 
$dec = $sql .  $prev_year . "-12-01' AND '" . $prev_year . "-12-31' GROUP BY month";
$jan = $sql .  $curr_year . "-01-01' AND '" . $curr_year . "-01-31' GROUP BY month";
$feb = $sql .  $curr_year . "-02-01' AND '" . $curr_year . "-02-31' GROUP BY month";
$mar = $sql .  $curr_year . "-03-01' AND '" . $curr_year . "-03-31' GROUP BY month";
$apr = $sql .  $curr_year . "-04-01' AND '" . $curr_year . "-04-31' GROUP BY month";
$may = $sql .  $curr_year . "-05-01' AND '" . $curr_year . "-05-31' GROUP BY month";
$jun = $sql .  $curr_year . "-06-01' AND '" . $curr_year . "-06-31' GROUP BY month";
$jul = $sql .  $curr_year . "-07-01' AND '" . $curr_year . "-07-31' GROUP BY month";
$aug = $sql .  $curr_year . "-08-01' AND '" . $curr_year . "-08-31' GROUP BY month"; 

// Monthly Reports
$sep_hrs = round($con->query($sep)->fetch_row()[0], 2);
$oct_hrs = round($con->query($oct)->fetch_row()[0], 2); 
$nov_hrs = round($con->query($nov)->fetch_row()[0], 2);
$dec_hrs = round($con->query($dec)->fetch_row()[0], 2);
$jan_hrs = round($con->query($jan)->fetch_row()[0], 2);
$feb_hrs = round($con->query($feb)->fetch_row()[0], 2);
$mar_hrs = round($con->query($mar)->fetch_row()[0], 2);
$apr_hrs = round($con->query($apr)->fetch_row()[0], 2);
$may_hrs = round($con->query($may)->fetch_row()[0], 2);
$jun_hrs = round($con->query($jun)->fetch_row()[0], 2);
$jul_hrs = round($con->query($jul)->fetch_row()[0], 2);
$aug_hrs = round($con->query($aug)->fetch_row()[0], 2);

$sep_plc = $con->query($sep)->fetch_row()[1];
$sep_vid = $con->query($sep)->fetch_row()[2];
$sep_rvs = $con->query($sep)->fetch_row()[3];
$sep_bss = $con->query($sep)->fetch_row()[4];
$sep_ldc = $con->query($sep)->fetch_row()[5];

$oct_plc = $con->query($oct)->fetch_row()[1];
$oct_vid = $con->query($oct)->fetch_row()[2];
$oct_rvs = $con->query($oct)->fetch_row()[3];
$oct_bss = $con->query($oct)->fetch_row()[4];
$oct_ldc = $con->query($oct)->fetch_row()[5];

$nov_plc = $con->query($nov)->fetch_row()[1];
$nov_vid = $con->query($nov)->fetch_row()[2];
$nov_rvs = $con->query($nov)->fetch_row()[3];
$nov_bss = $con->query($nov)->fetch_row()[4];
$nov_ldc = $con->query($nov)->fetch_row()[5];

$dec_plc = $con->query($dec)->fetch_row()[1];
$dec_vid = $con->query($dec)->fetch_row()[2];
$dec_rvs = $con->query($dec)->fetch_row()[3];
$dec_bss = $con->query($dec)->fetch_row()[4];
$dec_ldc = $con->query($dec)->fetch_row()[5];

$jan_plc = $con->query($jan)->fetch_row()[1];
$jan_vid = $con->query($jan)->fetch_row()[2];
$jan_rvs = $con->query($jan)->fetch_row()[3];
$jan_bss = $con->query($jan)->fetch_row()[4];
$jan_ldc = $con->query($jan)->fetch_row()[5];

$feb_plc = $con->query($feb)->fetch_row()[1];
$feb_vid = $con->query($feb)->fetch_row()[2];
$feb_rvs = $con->query($feb)->fetch_row()[3];
$feb_bss = $con->query($feb)->fetch_row()[4];
$feb_ldc = $con->query($feb)->fetch_row()[5];

$mar_plc = $con->query($mar)->fetch_row()[1];
$mar_vid = $con->query($mar)->fetch_row()[2];
$mar_rvs = $con->query($mar)->fetch_row()[3];
$mar_bss = $con->query($mar)->fetch_row()[4];
$mar_ldc = $con->query($mar)->fetch_row()[5];

$apr_plc = $con->query($apr)->fetch_row()[1];
$apr_vid = $con->query($apr)->fetch_row()[2];
$apr_rvs = $con->query($apr)->fetch_row()[3];
$apr_bss = $con->query($apr)->fetch_row()[4];
$apr_ldc = $con->query($apr)->fetch_row()[5];

$may_plc = $con->query($may)->fetch_row()[1];
$may_vid = $con->query($may)->fetch_row()[2];
$may_rvs = $con->query($may)->fetch_row()[3];
$may_bss = $con->query($may)->fetch_row()[4];
$may_ldc = $con->query($may)->fetch_row()[5];

$jun_plc = $con->query($jun)->fetch_row()[1];
$jun_vid = $con->query($jun)->fetch_row()[2];
$jun_rvs = $con->query($jun)->fetch_row()[3];
$jun_bss = $con->query($jun)->fetch_row()[4];
$jun_ldc = $con->query($jun)->fetch_row()[5];

$jul_plc = $con->query($jul)->fetch_row()[1];
$jul_vid = $con->query($jul)->fetch_row()[2];
$jul_rvs = $con->query($jul)->fetch_row()[3];
$jul_bss = $con->query($jul)->fetch_row()[4];
$jul_ldc = $con->query($jul)->fetch_row()[5];

$aug_plc = $con->query($aug)->fetch_row()[1];
$aug_vid = $con->query($aug)->fetch_row()[2];
$aug_rvs = $con->query($aug)->fetch_row()[3];
$aug_bss = $con->query($aug)->fetch_row()[4];
$aug_ldc = $con->query($aug)->fetch_row()[5];

// Year to date hours
$ytd = round($sep_hrs+$oct_hrs+$nov_hrs+$dec_hrs+$jan_hrs+$feb_hrs+$mar_hrs+$apr_hrs+$may_hrs+$jun_hrs+$jul_hrs+$aug_hrs, 2);

/************************************ CURRENT MONTHS REPORT ************************************/
/***********************************************************************************************/
// Prepare the SQL Query
$curr  = "SELECT ";
$curr .= "SUM(hours) hours, "; 
$curr .= "SUM(placements) placements , "; 
$curr .= "SUM(video) video, SUM(rv) rv, ";  
$curr .= "SUM(bs) bs, ";
$curr .= "SUM(ldc) ldc ";
$curr .= "FROM report WHERE ";
$curr .= "owner='" . $_SESSION['owner'] . "' ";
$curr .= "AND date BETWEEN CURDATE() - INTERVAL (DAY(CURDATE())-1) DAY "; 
$curr .= "AND LAST_DAY(CURDATE())";
// Fetch the results
$curr_hrs = round($con->query($curr)->fetch_row()[0], 2);
$curr_plc = round($con->query($curr)->fetch_row()[1], 2);
$curr_vid = round($con->query($curr)->fetch_row()[2], 2);
$curr_rvs = round($con->query($curr)->fetch_row()[3], 2);
$curr_bss = round($con->query($curr)->fetch_row()[4], 2);
$curr_ldc = round($con->query($curr)->fetch_row()[5], 2);
/***********************************************************************************************/

/************************************** LAST MONTHS REPORT *************************************/
/*** We need to save last month's report since let's be honest you are always late to report ***/
/***********************************************************************************************/
// Prepare the SQL Query
$prev  = "SELECT ";
$prev .= "SUM(hours) hours, "; 
$prev .= "SUM(placements) placements , "; 
$prev .= "SUM(video) video, SUM(rv) rv, ";  
$prev .= "SUM(bs) bs, ";
$prev .= "SUM(ldc) ldc ";
$prev .= "FROM report WHERE ";
$prev .= "owner='" . $_SESSION['owner'] . "' ";
$prev .= "AND date BETWEEN DATE_SUB(CURDATE(), INTERVAL 1 MONTH) "; 
$prev .= "AND LAST_DAY(DATE_SUB(CURDATE(), INTERVAL 1 MONTH))";
// Fetch the results
$prev_hrs = round($con->query($prev)->fetch_row()[0], 2);
$prev_plc = round($con->query($prev)->fetch_row()[1], 2);
$prev_vid = round($con->query($prev)->fetch_row()[2], 2);
$prev_rvs = round($con->query($prev)->fetch_row()[3], 2);
$prev_bss = round($con->query($prev)->fetch_row()[4], 2);
$prev_ldc = round($con->query($prev)->fetch_row()[5], 2);
// Compose e-mail message
$text_msg  = "Dear Bro. " . $_SESSION['elder_name'] . ",\n\n";
$text_msg .= "Here's my monthly report: \n";
$text_msg .= "Hours: " .            $prev_hrs + $prev_ldc . "\n";
$text_msg .= "Placements: " .       $prev_plc            . "\n"; 
$text_msg .= "Return Visits: " .    $prev_rvs            . "\n";   
$text_msg .= "Bible Study: " .      $prev_bss            . "\n";
$text_msg .= "Videos Shown: " .     $prev_vid            . "\n\n"; 
$text_msg .= "Thank you,\n";
$text_msg .= $_SESSION['owner']; 
/**********************************************************************************************/

?>
 
<!DOCTYPE html>
<html lang="en">
<!-- 
________________________________________________________
__|____|____|______|___|____|____|_____|___|_______|____
___|__|______|____|___|___/\__|____|__|___|__/\__|___|__
____|__|___|__|__\  |____|  |____|__|___|____)/_|___|___
_\__  \__\    _ \_| __ \_|  |  \_|  |_/  _ \____/  ___/_
__/ __ \__|  |_\/_| \_\ \|      \|  |\   __/____\__  \__
_(____  /_|__|____|___  /|___|  /|__|_\___  /|_/____  \_
___|__\/___|__________\/______\/__|_______\/_____|__\/__
_____|______|______|_______|___|___|___|___________|____
________________________________________________________
______|_____|___|____|_____|___|_|_____|__|____|___|____
____|___|__|___|______|______|_____|__|____|__|___|_____
__|___|_____|______|__|___|___|_|__|___|_______|________
___/  ___/_/  _ \_\    _ \\  \/ /|  |_/ ___\__/  _ \____
___\__  \_\   __/__|  |_\/_\   /_|  |\  \____\   __/____
__/____  \_\___  /_|__|___|_\_/__|__|_\___  /_\___  /___
____|__\/______\/___|_______|_____|_______\/______\/____
______|_____|________|________|____|____|______|________
________________________________________________________
___|______|___|___|__|_______|_____|______|___|_____|___
____|____|___|___|____|___|_________|____|___|____|___|_
__|__|_____|_______|_______|______|__|______|  /_|___|__
\    _ \_/  _ \__/ ___\__/ __ \_\    _ \_/ __ |__/  ___/
_|  |_\/\   __/_\  \____(  \_\ )_|  |_\// /_/ |__\__  \_
_|__|____\___  /_\___  /_\____/__|__|___\____ |_/____  \
__|__________\/______\/___|_______|__________\/___|__\/_
___|______|________|________|______|______|_________|___
 -->
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title> My Reports - Service Records </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" media="all" href="./stylesheets/charts.min.css" />
    <link rel="stylesheet" media="all" href="./stylesheets/phpvariables.php" />
    <link rel="stylesheet" media="all" href="./stylesheets/dashboard.css?v=172023" />
    <link rel="stylesheet" media="all" href="./stylesheets/carlastyles.css?v=172023">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="./src/javascript.js"></script>

    <!-- CSS Files From Carla -->
    <link rel="stylesheet" media="all" href="./stylesheets/bootstrap.min.css">
    <link rel="stylesheet" media="all" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i&amp;display=swap">
    <link rel="stylesheet" media="all" href="./stylesheets/fontawesome-all.min.css">
    <link rel="stylesheet" media="all" href="./stylesheets/font-awesome.min.css">
    <link rel="stylesheet" media="all" href="./stylesheets/ionicons.min.css">
    <link rel="stylesheet" media="all" href="./stylesheets/fontawesome5-overrides.min.css">
    
    <!-- Chart.css -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/charts.css/dist/charts.min.css">

    <!-- Date Picker -->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script> $( function() { $( "#datepicker" ).datepicker(); } ); </script>
</head>

<body id="page-top">
    <header>
    <?php include("../private/shared/navigation.php"); ?>

    <div class="d-flex flex-column" id="content-wrapper">
        <div id="content">
            <div class="container-fluid">
                <div class="welcome">
                    <p>
                        <h4><b>
                    
                        <?php
                        date_default_timezone_set("America/Los_Angeles");  
                        $h = date('G');

                        if ( $h >= 5 && $h <= 11 ) { echo "Good morning, " . $_SESSION['owner']; } 
                        else if ( $h >= 12 && $h <= 15 ) { echo "Good afternoon, " . $_SESSION['owner']; } 
                        else { echo "Good evening, " . $_SESSION['owner']; }
                        ?>

                        </b></h4>
                    </p>
                    <h5 class="text-dark mb-0"> Summary Report for <?= date('F Y') ?> </h5>
                    <br>
                </div> 

                <!-- ROW WIDGETS -->
                <div class="row">
                    <!-- MY GOAL -->
                    <div class="col-md-6 col-xl-3 mb-4">
                        <div class="card shadow border-start-primary py-2">
                            <div class="card-body">
                                <div class="row align-items-center no-gutters">
                                    <div class="col me-2">
                                        <div class="text-uppercase text-primary fw-bold text-xs mb-1">
                                            <span> My Goal </span>
                                        </div>
                                        <div class="text-dark fw-bold h5 mb-0">
                                            <span> <?= $_SESSION['goal'] ?> </span>
                                        </div>
                                        <div>
                                            <span> Change goal from the <a href="dashboard.php#update-info"> dashboard </a> page </span>
                                        </div>
                                        
                                    </div>
                                    <div class="col-auto"><img src="../img/goal.png" width="30px"></img></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- CURRENT HOURS -->
                    <div class="col-md-6 col-xl-3 mb-4">
                        <div class="card shadow border-start-primary py-2">
                            <div class="card-body">
                                <div class="row align-items-center no-gutters">
                                    <div class="col me-2">
                                        <div class="text-uppercase text-primary fw-bold text-xs mb-1"><span> Year-to-date </span></div>
                                        <div class="text-dark fw-bold h5 mb-0"><span> <?= $ytd ?> </span>hours</div>
                                        <div class="text-uppercase text-primary fw-bold text-xs mb-1"><span> Current Hours This Month </span></div>
                                        <div class="text-dark fw-bold h5 mb-0"><span> <?= $curr_hrs ?> </span></div>
                                    </div>
                                    <div class="col-auto"><img src="../img/clock.png" width="30px"></img></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- RVS -->
                    <div class="col-md-6 col-xl-3 mb-4">
                        <div class="card shadow border-start-success py-2">
                            <div class="card-body">
                                <div class="row align-items-center no-gutters">
                                    <div class="col me-2">
                                        <div class="text-uppercase text-primary fw-bold text-xs mb-1"><span> Return Visits </span></div>
                                        <div class="text-dark fw-bold h5 mb-0"><span> <?= $curr_rvs ?> </span></div>
                                    </div>
                                    <div class="col-auto"><img src="../img/house.png" width="30px"></img></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- BS -->
                    <div class="col-md-6 col-xl-3 mb-4">
                        <div class="card shadow border-start-info py-2">
                            <div class="card-body">
                                <div class="row align-items-center no-gutters">
                                    <div class="col me-2">
                                        <div class="text-uppercase text-info fw-bold text-xs mb-1"><span> Bible Studies </span></div>
                                        <div class="text-dark fw-bold h5 mb-0"><span> <?= $curr_bss ?> </span></div>
                                    </div>
                                    <div class="col-auto"><img src="../img/book.png" width="30px"></img></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- PLACEMENTS -->
                    <div class="col-md-6 col-xl-3 mb-4">
                        <div class="card shadow border-start-warning py-2">
                            <div class="card-body">
                                <div class="row align-items-center no-gutters">
                                    <div class="col me-2">
                                        <div class="text-uppercase text-warning fw-bold text-xs mb-1"><span> Placements </span></div>
                                        <div class="text-dark fw-bold h5 mb-0"><span> <?= $curr_plc ?> </span></div>
                                    </div>
                                    <div class="col-auto"><img src="../img/documents.png" width="30px"></img></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- VIDEOS SHOWN -->
                    <div class="col-md-6 col-xl-3 mb-4">
                        <div class="card shadow border-start-warning py-2">
                            <div class="card-body">
                                <div class="row align-items-center no-gutters">
                                    <div class="col me-2">
                                        <div class="text-uppercase text-warning fw-bold text-xs mb-1"><span> Videos Shown </span></div>
                                        <div class="text-dark fw-bold h5 mb-0"><span> <?= $curr_vid ?> </span></div>
                                    </div>
                                    <div class="col-auto"><img src="../img/multimedia.png" width="30px"></img></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- LDC HOURS -->
                    <div class="col-md-6 col-xl-3 mb-4">
                        <div class="card shadow border-start-warning py-2">
                            <div class="card-body">
                                <div class="row align-items-center no-gutters">
                                    <div class="col me-2">
                                        <div class="text-uppercase text-warning fw-bold text-xs mb-1"><span> LDC Credit </span></div>
                                        <div class="text-dark fw-bold h5 mb-0"><span> <?= $curr_ldc ?> </span></div>
                                    </div>
                                    <div class="col-auto"><img src="../img/helmet.png" width="30px"></img></div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div> <!-- END ROW WIDGETS -->

                <!-- ROW CLOCK-IN -->
                <div class="col-lg-7 col-xl-8">
                    <div class="row" id="Row_Manual">
                        <div class="col">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center" id="clock">
                                    <h5 class="text-primary fw-bold m-0"> Clock-in </h5>
                                </div>

                                <div class="card-body">
                                    <div id="analog-clock">
                                        <div>
                                            <h4 id="title_currentTime"> Time </h4>
                                            <p class="w-lg-50">“For everything there is an appointed time.”​ <br>(<i>Ecclesiastes 3:1, NWT</i>)</p>
                                            <?php include( 'analog-clock.php' ) ?>
                                        </div>
                                    </div>

                                    <?php include ( 'calculate-timeOLD.php' ); ?>
                                    <!-- <div class="text-center small mt-4"> 
                                        <form method="post" action="hours.php">
                                            <input type="hidden" id="start_time" name="start_time">
                                            <input type="hidden" id="end_time" name="end_time">
                                            <button id="startTimeBtn" type="button" onclick="clockIn()">Clock In</button>
                                            <button id="endTimeBtn" type="submit" onclick="clockOut()">Clock Out</button>
                                        </form>
                                        <form action="submit-time.php" method="POST">
                                            <button id="submitTimeBtn" type="submit"> Submit Time </button>
                                        </form>
                                        <div id="output">
                                        < ?php
                                            // Clock in
                                            $start_time = $_POST['start_time'];
                                            $end_time = $_POST['end_time'];
                                            $total_time = strtotime($end_time) - strtotime($start_time);
                                            $_SESSION['totalTime'] = gmdate("H:i:s", $total_time);
                                            echo "<br>Total time worked: " . gmdate("H:i:s", $total_time);
                                        ?>
                                        </div>
                                    </div> -->

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END ROW CLOCK-IN -->

                <!-- ROW INPUT REPORT -->
                <div class="col-lg-7 col-xl-8">
                    <div class="row" id="Row_Manual">
                        <div class="col">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5 class="text-primary fw-bold m-0"> Manual Input </h5>
                                </div>
                                <div class="card-body">
                                    <form action="reports.php" method="post">
                                        <h4> Enter your records for: </h4>
                                        <div style="text-align:center">
                                            <input type="date" name="date" required>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table">
                                                <tbody>
                                                    <tr>
                                                        <td> Hours </td>
                                                        <td><input type="number" name="hours" value="0"></td>
                                                    </tr>
                                                    <tr>
                                                        <td> Return Visits </td>
                                                        <td><input type="number" name="rv" value="0"></td>
                                                    </tr>
                                                    <tr>
                                                        <td> Placements </td>
                                                        <td><input type="number" name="placements" value="0"></td>
                                                    </tr>
                                                    <tr>
                                                        <td> Bible Studies </td>
                                                        <td><input type="number" name="bs" value="0"></td>
                                                    </tr>
                                                    <tr>
                                                        <td> Video Showings </td>
                                                        <td><input type="number" name="video" value="0"></td>
                                                    </tr>
                                                    <tr>
                                                        <td> LDC Hours </td>
                                                        <td><input type="number" name="ldc" value="0"></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <div style="text-align:center">
                                                <label for="notes"> Notes: </label>
                                                <textarea rows="4" cols="auto" name="notes"></textarea>
                                                <input type="hidden" name="service_year" value="
                                                    <?php
                                                    
                                                    $currentDate = new DateTime();
                                                    $startDate = DateTimeImmutable::createFromFormat('Y-m-d', $prev_year.'-09-01');
                                                    $endDate = DateTimeImmutable::createFromFormat('Y-m-d', $curr_year.'-08-31');

                                                    echo $currentDate >= $startDate && $currentDate <= $endDate ? $curr_year : $prev_year;
                                                    
                                                    ?>">
                                                
                                                <button id="greenbutton" type="submit"> Update Records </button>
                                            </div>
                                            
                                        </div>
                                    </form> 
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Bar Chart -->
                    <?php include ( "bar-chart.php" ); ?>

                </div>
            </div>

            <!-- Archives -->
            <div class="card shadow mb-4"> 
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="text-primary fw-bold m-0"> <?= date("Y ") ?> Service Year Data</h5>
                        </div>
                        <div class="card-body"> 
                            <table>
                                
                                <tr style="width:303px">
                                    <th> Mon    </th> 
                                    <th> Hrs    </th>
                                    <th> Plc    </th> 
                                    <th> Vids   </th>
                                    <th> RVs    </th> 
                                    <th> BS     </th>
                                    <th> LDC    </th>
                                </tr>
                                <tr><td><hr></td></tr>
                                <tr>
                                    <td><b>Sep<b></td>
                                    <td><?= $sep_hrs ?></td>
                                    <td><?= $sep_plc ?></td>
                                    <td><?= $sep_vid ?></td>
                                    <td><?= $sep_rvs ?></td>
                                    <td><?= $sep_bss ?></td>
                                    <td><?= $sep_ldc ?></td>    
                                </tr> 
                                <tr>
                                    <td><b>Oct<b></td>
                                    <td><?= $oct_hrs ?></td>
                                    <td><?= $oct_plc ?></td>
                                    <td><?= $oct_vid ?></td>
                                    <td><?= $oct_rvs ?></td>
                                    <td><?= $oct_bss ?></td>
                                    <td><?= $oct_ldc ?></td>    
                                </tr> 
                                <tr>
                                    <td><b>Nov<b></td>
                                    <td><?= $nov_hrs ?></td>
                                    <td><?= $nov_plc ?></td>
                                    <td><?= $nov_vid ?></td>
                                    <td><?= $nov_rvs ?></td>
                                    <td><?= $nov_bss ?></td>
                                    <td><?= $nov_ldc ?></td>    
                                </tr> 
                                <tr>
                                    <td><b>Dec<b></td>
                                    <td><?= $dec_hrs ?></td>
                                    <td><?= $dec_plc ?></td>
                                    <td><?= $dec_vid ?></td>
                                    <td><?= $dec_rvs ?></td>
                                    <td><?= $dec_bss ?></td>
                                    <td><?= $dec_ldc ?></td>    
                                </tr> 
                                <tr>
                                    <td><b>Jan<b></td>
                                    <td><?= $jan_hrs ?></td>
                                    <td><?= $jan_plc ?></td>
                                    <td><?= $jan_vid ?></td>
                                    <td><?= $jan_rvs ?></td>
                                    <td><?= $jan_bss ?></td>
                                    <td><?= $jan_ldc ?></td>    
                                </tr> 
                                <tr>
                                    <td><b>Feb<b></td>
                                    <td><?= $feb_hrs ?></td>
                                    <td><?= $feb_plc ?></td>
                                    <td><?= $feb_vid ?></td>
                                    <td><?= $feb_rvs ?></td>
                                    <td><?= $feb_bss ?></td>
                                    <td><?= $feb_ldc ?></td>    
                                </tr> 
                                <tr>
                                    <td><b>Mar<b></td>
                                    <td><?= $mar_hrs ?></td>
                                    <td><?= $mar_plc ?></td>
                                    <td><?= $mar_vid ?></td>
                                    <td><?= $mar_rvs ?></td>
                                    <td><?= $mar_bss ?></td>
                                    <td><?= $mar_ldc ?></td>    
                                </tr> 
                                <tr>
                                    <td><b>Apr<b></td>
                                    <td><?= $apr_hrs ?></td>
                                    <td><?= $apr_plc ?></td>
                                    <td><?= $apr_vid ?></td>
                                    <td><?= $apr_rvs ?></td>
                                    <td><?= $apr_bss ?></td>
                                    <td><?= $apr_ldc ?></td>    
                                </tr> 
                                <tr>
                                    <td><b>May<b></td>
                                    <td><?= $may_hrs ?></td>
                                    <td><?= $may_plc ?></td>
                                    <td><?= $may_vid ?></td>
                                    <td><?= $may_rvs ?></td>
                                    <td><?= $may_bss ?></td>
                                    <td><?= $may_ldc ?></td>    
                                </tr> 
                                <tr>
                                    <td><b>Jun<b></td>
                                    <td><?= $jun_hrs ?></td>
                                    <td><?= $jun_plc ?></td>
                                    <td><?= $jun_vid ?></td>
                                    <td><?= $jun_rvs ?></td>
                                    <td><?= $jun_bss ?></td>
                                    <td><?= $jun_ldc ?></td>    
                                </tr> 
                                <tr>
                                    <td><b>Jul<b></td>
                                    <td><?= $jul_hrs ?></td>
                                    <td><?= $jul_plc ?></td>
                                    <td><?= $jul_vid ?></td>
                                    <td><?= $jul_rvs ?></td>
                                    <td><?= $jul_bss ?></td>
                                    <td><?= $jul_ldc ?></td>    
                                </tr> 
                                <tr>
                                    <td><b>Aug<b></td>
                                    <td><?= $aug_hrs ?></td>
                                    <td><?= $aug_plc ?></td>
                                    <td><?= $aug_vid ?></td>
                                    <td><?= $aug_rvs ?></td>
                                    <td><?= $aug_bss ?></td>
                                    <td><?= $aug_ldc ?></td>    
                                </tr> 
                                <tr style="background-color:gold">
                                    <td><b>TOTAL<b></td>
                                    <td><b><?= $ytd ?>    </b></td>
                                    <td><b><?= $aug_plc ?></b></td>
                                    <td><b><?= $aug_vid ?></b></td>
                                    <td><b><?= $aug_rvs ?></b></td>
                                    <td><b><?= $aug_bss ?></b></td>
                                    <td><b><?= $aug_ldc ?></b></td>    
                                </tr> 
                                
                            </table>
                        <div>
                    </div>
                </div>
            </div>

            <!-- SEND REPORT -->
            <div class="col-lg-7 col-xl-8">
                <div class="row" id="Row_Manual">
                    <div class="col">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="text-primary fw-bold m-0"> Send Report to your Overseer </h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr></tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                <form action="phpmailer.php" method="post">
                                                    <label for="elder_name"> Overseer's name: </label><br>
                                                    <input type="text" name="elder_name" width="100px" value="<?= $_SESSION['elder_name'] ?>" required><br>
                                                    <label for="elder_email"> Overseer's e-mail: </label><br>
                                                    <input type="email" name="elder_email" width="100px" value="<?= $_SESSION['elder_email'] ?>" required><br>
                                                    <label for="subject"> Subject: </label><br>
                                                    <input type="text" id="subject" name="subject" value="Service Report for <?= $prev_mon ?>" ><br>
                                                    <label for="message"> Message: (you can edit this message)</label><br>
                                                    <textarea id="message" name="message" rows="12" cols="auto"><?= $text_msg ?></textarea><br>
                                                    <!-- <input type="submit" value="Send"> -->
                                                    <button id="goldbutton" type="submit"> Send Report via Email </button>
                                                </form> 
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                <form action="phptexter.php" method="post">
                                                    <label for="elder_phone"> Overseer's phone number: </label><br>
                                                    <input type="tel" name="elder_phone" value="<?= $_SESSION['elder_phone'] ?>" required><br>
                                                    <label for="message">Message:</label><br>
                                                    <textarea id="message" name="message" rows="5" cols="auto">Service Report for <?= $prev_mon ?> . Hours(<?= $prev_hrs + $prev_ldc; ?>), Placements:(<?= $prev_plc; ?>), Return Visits:(<?= $prev_rvs; ?>), Bible Study:(<?= $prev_bss; ?>), Videos Shown:(<?= $prev_vid; ?>). Thank you. ** This is an automated message, please do not reply. **</textarea><br>
                                                    <button id="purplebutton" type="submit"> Send report via Text </button>
                                                </form> 
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <?php include("../private/shared/footer.php"); ?>

    </header>

<script src="/public/src/bootstrap.min.js"></script>
<script src="/public/src/chart.min.js"></script>
<script src="/public/src/bs-init.js"></script>
<script src="/public/src/countdown-timer.js"></script>
<script src="/public/src/theme.js"></script>

</body>
</html>

