<!--
██╗  ██╗██╗  ██╗██████╗  ██████╗ ███╗   ██╗ ██████╗ ███████╗    ██████╗     ██████╗ 
██║ ██╔╝██║  ██║██╔══██╗██╔═══██╗████╗  ██║██╔═══██╗██╔════╝    ╚════██╗   ██╔═████╗
█████╔╝ ███████║██████╔╝██║   ██║██╔██╗ ██║██║   ██║███████╗     █████╔╝   ██║██╔██║
██╔═██╗ ██╔══██║██╔══██╗██║   ██║██║╚██╗██║██║   ██║╚════██║    ██╔═══╝    ████╔╝██║
██║  ██╗██║  ██║██║  ██║╚██████╔╝██║ ╚████║╚██████╔╝███████║    ███████╗██╗╚██████╔╝
╚═╝  ╚═╝╚═╝  ╚═╝╚═╝  ╚═╝ ╚═════╝ ╚═╝  ╚═══╝ ╚═════╝ ╚══════╝    ╚══════╝╚═╝ ╚═════╝ 
June 7, 2023
Raymond Brian D. Hernandez 
Carla Regine R. Hernandez
-->

<?php

if ( session_status() !== PHP_SESSION_ACTIVE ) { 
    session_start(); 
}

//include ( "debug.php" );
require ( "../private/secure.php" );
require_once ( "../private/db_config.php" );
include ( "hours-preload.php" );

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title> My Service Reports - Khronos Pro 2 </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" media="all" href="./stylesheets/charts.min.css" />
    <link rel="stylesheet" media="all" href="./stylesheets/phpvariables.php" />
    <link rel="stylesheet" media="all" href="./stylesheets/dashboard.css?v=172023" />
    <link rel="stylesheet" media="all" href="./stylesheets/carlastyles.css?v=172023">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>

    <link rel="stylesheet" media="all" href="./stylesheets/bootstrap.min.css">
    <link rel="stylesheet" media="all" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i&amp;display=swap">
    <link rel="stylesheet" media="all" href="./stylesheets/fontawesome-all.min.css">
    <link rel="stylesheet" media="all" href="./stylesheets/font-awesome.min.css">
    <link rel="stylesheet" media="all" href="./stylesheets/ionicons.min.css">
    <link rel="stylesheet" media="all" href="./stylesheets/fontawesome5-overrides.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/charts.css/dist/charts.min.css">
</head>

<div>
    <body id="page-top">

    <?php include ( "../private/shared/navigation.php" ); ?>

    <div class="d-flex flex-column" id="content-wrapper" style="margin: 30px;">
        <div id="content">
            <!-- TITLE START -->
            <div class="container-fluid">
                <br>
                <h4><b> Summary Report for <?= date('F Y') ?></b></h4> 
                <h3><b><?= $_SESSION['service_year'] ?> Service Year </b></h3>
            </div>

            <br>

            <?php include ( "hours-widgets.php" ) ?>
            
            <!-- ROW CLOCK-IN -->
            <div class="row">    
                <div class="card shadow mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center" id="clock">
                        <h5 class="text-primary fw-bold m-0"> Clock-in </h5>
                    </div>
                </div>
                <div class="card-body">
                    <div id="analog-clock">
                        <div>
                            <br>
                            <?php include( 'analog-clock.php' ) ?>
                            <br>
                            <p class="w-lg-50">“For everything there is an appointed time.”​ <br>(<i>Ecclesiastes 3:1, NWT</i>)</p>
                        </div>
                    </div>
                </div> 
                <div style="text-align:center">
                    <?php include ( 'calculate-time-v2.php' ); ?>
                </div>
            </div> 

            <br>

            <!-- ROW INPUT REPORT -->
            <div class="card shadow mb-4">
                <?php include ( "manual-input.php" ); ?>   
            </div>
                
            <!-- Bar Chart -->
            <div class="card shadow mb-4">
                <?php include ( "bar-chart.php" ); ?>
            </div>

            <!-- Archives -->
            <div class="card shadow mb-4"> 
                <?php include ( 'service-year-data-table.php' ); ?>    
            </div>

        </div>
    </div>
        <!-- SEND REPORT -->
        <!-- <div class="card shadow mb-4">
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
                                                    <input type="text" name="elder_name" width="100px" value="< ?= $_SESSION['elder_name'] ?>" required><br>
                                                    <label for="elder_email"> Overseer's e-mail: </label><br>
                                                    <input type="email" name="elder_email" width="100px" value="< ?= $_SESSION['elder_email'] ?>" required><br>
                                                    <label for="subject"> Subject: </label><br>
                                                    <input type="text" id="subject" name="subject" value="Service Report for <?= $_SESSION['prev_mon'] . date (' Y') ?>" ><br>
                                                    <label for="message"> Message: (you can edit this message)</label><br>
                                                    <textarea id="message" name="message" rows="12" cols="auto">< ?= $_SESSION['text_msg'] ?></textarea><br>
                                                    // < !-- <input type="submit" value="Send"> -->
                                                    <!-- <button id="goldbutton" type="submit"> Send Report via Email </button> -->
                                                <!-- </form> 
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                <form action="phptexter.php" method="post">
                                                    <label for="elder_phone"> Overseer's phone number: </label><br>
                                                    <input type="tel" name="elder_phone" value="< ?= $_SESSION['elder_phone'] ?>" required><br>
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
    </div>-->
    
    <?php include("../private/shared/footer.php"); ?>
</div>

</body>
</html>
