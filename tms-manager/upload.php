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

include 'db.php';
include 'debug.php';
include 'all_names.php';
require '../private/secure.php';

if ( $_SESSION['admin'] == 'Super Admin' || $_SESSION['admin'] == 'OCLM Admin' ) {
    $authorized = TRUE;
} else {
    $authorized = FALSE;
}

$congregation = $_SESSION['congregation'];

?>

<!DOCTYPE html>
<html lang="en">

<head>    
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title> Upload JW Workbook - Khronos Pro 2 </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" media="all" href="../public/stylesheets/charts.min.css" />
    <link rel="stylesheet" media="all" href="../public/stylesheets/phpvariables.php" />
    <link rel="stylesheet" media="all" href="../public/stylesheets/dashboard.css" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>

<body>
<header>
    <?php include '../private/shared/navigation.php'; ?>
    
    <div style="margin: 0 auto; text-align: center;">
        <?php include 'tms-navigation.php' ?>
    </div>

    <div style="text-align:center">
        <h5><?php echo $congregation ?> Congregation </h5>
        <h5>Upload JW Workbooks (2024 or newer)</h5>
    </div>

    <!-- THIS PART IS ONLY SHOWN ON SUPER ADMINS AND ADMINS -->
    <?php if ( $authorized ) { ?>
        <div style="text-align: center;">
            <form method="post" action="array.php" onsubmit="showLoader()">
                <input type="text" style="width:40%;" name="url" placeholder="Paste the JW Workbook Link here..."/> &nbsp;
                <button type="submit" style="background-color: red;">Fetch and Parse Data</button>&nbsp;
            </form>
            <hr>
            <b>NOTE:</b>
            <i>Parsing and crawling JW Workbooks is slow so please wait till everything loads.</i></p>
            <p><i>Only parse data if the most current workbook is not posted yet.  Please check the weeks below to verify to avoid re-parsing JW website.</p>

            <?php 

                $query = "SELECT DISTINCT week, year FROM assignments WHERE congregation='$congregation' ORDER BY id ASC";
                $result = mysqli_query ( $tmscon, $query );

                echo "<b>Weeks available to edit for " . $congregation . " Congregation:</b><br><br>";
                // echo "<select name='week_select' style='width:20%;'>";
                // echo "<option value=''>Select a week</option>";

                while ( $row = mysqli_fetch_assoc ( $result ) ) {
                    // echo "<option value='" . $row['week'] . "'>" . $row['week'] . ", " . $row['year'] . "</option>";
                    echo "{$row['week']}, {$row['year']}<br>";
                }

                echo "</select><br>";

            ?>

        </div>
    
        <!-- ELSE SHOW THIS PART ONLY -->
        <?php 
    
    } else { 
        include ( 'public-view.php' );    
    } 
    
    ?>
    
    <div style="text-align: center;">
        <small><br>*Currently only works on English and Tagalog Workbooks. For example, click <a href="https://www.jw.org/en/library/jw-meeting-workbook/" target="_blank">JW Workbook Schedule</a> to grab all assignments.</i></small>
    </div>
    <div>
        <?php include '../private/shared/footer.php'; ?>
    </div>
    
</header>   

</body>
</html>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
