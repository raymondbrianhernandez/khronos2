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
        
    require_once '../private/secure.php';
    require_once '../private/db_config.php';
    include_once 'hours-preload-ytd.php';
    include 'debug.php';

    $owner = $_SESSION['owner'];

    // Define an array of status values you want to count
    $statuses = ['new', 'valid', 'invalid', 'do not call'];

    // Initialize an array to store counts
    $countByStatus = [];

    // Use a loop to count each status
    foreach ( $statuses as $status ) {
        $query = "SELECT COUNT(status) FROM householders WHERE owner='$owner' AND status='$status'";
        $result = $con->query ( $query );
        $countByStatus[$status] = $result->fetch_row()[0];
    }

    $newAddr        = $countByStatus['new'];
    $validAddr      = $countByStatus['valid'];
    $invalidAddr    = $countByStatus['invalid'];
    $blockedAddr    = $countByStatus['do not call'];
    $accountOwner   = $countByStatus['new'];
    $currentCarrier = $_SESSION['carrier'];
    $currentGoal    = $_SESSION['goal'];
    $total          = $newAddr + $validAddr + $invalidAddr + $blockedAddr;

?>

<!DOCTYPE html>
<html lang="en">

<head>    
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title> Dashboard - Khronos Pro 2 </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" media="all" href="./stylesheets/charts.min.css" />
    <link rel="stylesheet" media="all" href="./stylesheets/phpvariables.php" />
    <link rel="stylesheet" media="all" href="./stylesheets/dashboard.css" />
    <link rel="stylesheet" media="all" href="./stylesheets/carlastyles.css" />
    <!-- Map Libre -->
    <script src='https://unpkg.com/maplibre-gl@2.4.0/dist/maplibre-gl.js'></script>
    <link href='https://unpkg.com/maplibre-gl@2.4.0/dist/maplibre-gl.css' rel='stylesheet' />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
<header>
    <?php include '../private/shared/navigation.php'; ?>

    <div class="mainbody">
        
        <div class="row d-flex justify-content-center"> 
            <p style="text-align:center;">
                <?php include 'greetings.php' ?>  
            </p>
            <br>
        </div>
        <?php include 'dashboard-widgets.php' ?>
    </div>
    <br>
    <div>
        <?php include '../private/shared/footer.php'; ?>
    </div>
</header>   

</body>
</html>

<script>
// Collapsible for the View/Edit Account Information
document.addEventListener ( "DOMContentLoaded", function() {
    var collapsibles = document.querySelectorAll ( ".collapsible" );

    collapsibles.forEach ( function ( collapsible ) {
        var content = collapsible.nextElementSibling;
        content.style.display = "none"; // Hide content by default

        collapsible.addEventListener ( "click", function() {
            if ( content.style.display === "block" ) {
                content.style.display = "none";
            } else {
                content.style.display = "block";
            }
        });
    });
});

function openContactUsWindow() {
    var url = "contact-us";
    var width = 600;
    var height = 400;
    
    // Open the new window with specified width and height
    var newWindow = window.open ( url, "_blank", "width=" + width + ",height=" + height );
    
    // Focus the new window (optional)
    if ( newWindow ) {
    newWindow.focus();
    }
}

function openChangePasswordWindow() {
    var url = "resetpassword_mini.php";
    var width = 600;
    var height = 400;
    
    // Open the new window with specified width and height
    var newWindow = window.open ( url, "_blank", "width=" + width + ",height=" + height );
    
    // Focus the new window (optional)
    if ( newWindow ) {
    newWindow.focus();
    }
}
</script>
