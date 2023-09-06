<?php 

include ( 'debug.php' );
include ( 'functions.php' );

session_start();
$start_time   = date ( "g:i", strtotime ( "7:00 PM " ) );
$total_arr    = count ( $_SESSION['assignment'] );
$cbs          = $total_arr - 3;
$chairman     = $_SESSION['assignment'][1]['assignee'];
$week_of      = $_SESSION['week_select'];
$midweek_date = date ( "F j, Y", strtotime ( $_SESSION['midweek_date'] ) );
$verse        = $_SESSION['verse'];
$song_open    = $_SESSION['song_open'];
$song_mid     = $_SESSION['song_mid'];
$song_close   = $_SESSION['song_close'];
$pray_open    = $_SESSION['assignment'][0]['assignee'];
$intro1       = $_SESSION['assignment'][1]['part'];
$intro2       = $_SESSION['assignment'][1]['assignee'];
$treasures1   = $_SESSION['assignment'][2]['part'];
$treasures2   = $_SESSION['assignment'][2]['assignee'];
$digging1     = $_SESSION['assignment'][3]['part'];
$digging2     = $_SESSION['assignment'][3]['assignee'];
$reading1     = $_SESSION['assignment'][4]['part'];
$reading2     = $_SESSION['assignment'][4]['assignee'];
$initial1     = $_SESSION['assignment'][5]['part'];
$initial2     = $_SESSION['assignment'][5]['assignee'];
$initial3     = $_SESSION['assignment'][5]['assistant'];
$rv1          = $_SESSION['assignment'][6]['part'];
$rv2          = $_SESSION['assignment'][6]['assignee'];
$rv3          = $_SESSION['assignment'][6]['assistant'];
$bs1          = $_SESSION['assignment'][7]['part'];
$bs2          = $_SESSION['assignment'][7]['assignee'];
$bs3          = $_SESSION['assignment'][7]['assistant'];
$service1A    = $_SESSION['assignment'][8]['part'];
$service2A    = $_SESSION['assignment'][8]['assignee'];
$service1B    = $_SESSION['assignment'][9]['part'];
$service2B    = $_SESSION['assignment'][9]['assignee'];
$outro1       = $_SESSION['assignment'][$total_arr - 2]['part'];
$outro2       = $_SESSION['assignment'][$total_arr - 2]['assignee']; 
$cbs1         = $_SESSION['assignment'][$cbs]['part'];
$cbs2         = $_SESSION['assignment'][$cbs]['assignee'];
$cbs3         = $_SESSION['assignment'][$cbs]['assistant'];
$pray_close   = $_SESSION['assignment'][$total_arr - 1]['assignee'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TMS Manager</title>
    <link rel="stylesheet" href="report_style.css">
</head>

<body>
    <div style="content-align:center">
        <table class="letterhead">
            <tr>
                <td style="width:50%"><h3>Topanga Canyon Tagalog Congregation</h3></td>
                <td style="width:50%"><h3>Iskedyul ng Pulong sa Gitnang Sanlinggo</h3></td>
            </tr>
            <tr>
                <td style="width:50%"><b><?= $midweek_date . " | " . $verse; ?></b></td>
                <td style="width:50%"></td>
            </tr>
        </table>
        <table class="report">
            <tr>    
                <td style="width:80%; text-align:right"><b>Chairman: </b></td>
                <td style="width:20%"><?= $chairman; ?></td>
            </tr>
            <tr>    <!-- OPENING SONG AND PRAYER -->
                <td style="width:80%"><?= "7:00 &nbsp;&nbsp;&bull;&nbsp;&nbsp;" . $song_open . " at Pambukas na Panalangin"; ?></td>
                <td style="width:20%"><?= $pray_open; ?></td>
            </tr>
            <tr>    <!-- CHAIRMAN INTRO -->
                <td style="width:80%"><?= "7:05 &nbsp;&nbsp;&bull;&nbsp;&nbsp;" . $intro1; ?></td>
                <td style="width:20%"><?= $intro2; ?></td>
            </tr>
            <tr>
                <td style="width:80%; background-color: blue; color: white;">&nbsp;&nbsp;KAYAMANAN MULA SA SALITA NG DIYOS</td>
                <td style="width:20%"></td>
            </tr>
            <tr>    <!-- TREASURES -->
                <td style="width:80%"><?= "7:06 &nbsp;&nbsp;&bull;&nbsp;&nbsp;" . $treasures1; ?></td>
                <td style="width:20%"><?= $treasures2; ?></td>
            </tr>
            <tr>    <!-- DIGGING -->
                <td style="width:80%"><?= "7:16 &nbsp;&nbsp;&bull;&nbsp;&nbsp;" . $digging1; ?></td>
                <td style="width:20%"><?= $digging2; ?></td>
            </tr>
            <tr>    <!-- BIBLE READING -->
                <td style="width:80%"><?= "7:26 &nbsp;&nbsp;&bull;&nbsp;&nbsp;" . $reading1; ?></td>
                <td style="width:20%"><?= $reading2; ?></td>
            </tr>
            <tr>
                <td style="width:80%; background-color: orange; color: white;">&nbsp;&nbsp;MAGING MAHUSAY SA MINISTERYO</td>
                <td style="width:20%"></td>
            </tr>
            <tr>    <!-- INITIAL VISIT -->
                <td style="width:80%"><?= "7:31 &nbsp;&nbsp;&bull;&nbsp;&nbsp;" . $initial1; ?></td>
                <td style="width:20%"><?= $initial2 . " / " . $initial3; ?></td>
            </tr>
            <tr>    <!-- RETURN VISIT -->
                <td style="width:80%"><?= "7:35 &nbsp;&nbsp;&bull;&nbsp;&nbsp;" . $rv1; ?></td>
                <td style="width:20%"><?= $rv2 . " / " . $rv3; ?></td>
            </tr>
            <tr>
                <td style="width:80%"><?= "7:40 &nbsp;&nbsp;&bull;&nbsp;&nbsp;" . $bs1; ?></td>
                <td style="width:20%"><?= $bs2 . " / " . $bs3; ?></td>
            </tr>
            <tr>
                <td style="width:80%; background-color: red; color: white;">&nbsp;&nbsp;PAMUMUHAY BILANG KRISTIYANO</td>
                <td style="width:20%"></td>
            </tr>
            <tr>
                <td style="width:80%"><?= "7:46 &nbsp;&nbsp;&bull;&nbsp;&nbsp;" . $song_mid; ?></td>
                <td style="width:20%"></td>
            </tr>
            <tr>
                <td style="width:80%"><?= "7:50 &nbsp;&nbsp;&bull;&nbsp;&nbsp;" . $service1A; ?></td>
                <td style="width:20%"><?= $service2A; ?></td>
            </tr>
            
            <?php if ( $total_arr == 13 ) { ?>
                <tr>
                    <td style="width:80%"><?= "7:55 &nbsp;&nbsp;&bull;&nbsp;&nbsp;" . $service1B; ?></td>
                    <td style="width:20%"><?= $service2B; ?></td>
                </tr>
            <?php } ?>

            <tr>
                <td style="width:80%"><?= "8:05 &nbsp;&nbsp;&bull;&nbsp;&nbsp;" . $cbs1; ?></td>
                <td style="width:20%"><?= $cbs2 . " / " . $cbs3; ?></td>
            </tr>

            <tr>
                <td style="width:80%"><?= "8:35 &nbsp;&nbsp;&bull;&nbsp;&nbsp;" . $outro1; ?></td>
                <td style="width:20%"><?= $outro2; ?></td>
            </tr>

            <tr>
                <td style="width:80%"><?= "8:38 &nbsp;&nbsp;&bull;&nbsp;&nbsp;" . $song_close . " at Pansarang Panalangin"; ?></td>
                <td style="width:20%"><?= $pray_close; ?></td>
            </tr>
            
        </table>
        <hr>
    </div>


</body>
</html>
