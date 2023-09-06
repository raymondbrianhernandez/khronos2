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

include ( 'db.php' );
include ( '../public/debug.php' );
include ( 'all_names.php' );
require ( '../private/secure.php' );

?>

<!DOCTYPE html>
<html lang="en">

<head>    
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title> OCLM Manager - Khronos Pro 2 </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" media="all" href="../public/stylesheets/charts.min.css" />
    <link rel="stylesheet" media="all" href="../public/stylesheets/phpvariables.php" />
    <link rel="stylesheet" media="all" href="../public/stylesheets/dashboard.css" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>

<body>
    <header>
        <?php include ( "../private/shared/navigation.php" ); ?>
        <p></p>
        <h4><b>Our Christian Life and Ministry​ Manager</b></h4>
        <div style="margin: 0 auto; text-align: center;">
            <?php 
                if ( $_SESSION['admin'] == 'Super Admin' || $_SESSION['admin'] == 'Admin' ) {
                    include ( 'tms-navigation.php' );
                }
            ?>
        </div>
        
        <div style="text-align:center;">
            This tool is only for the COBE, TMS Overseer, and/or their assistants to assign midweek meeting assignments.<br>
            For publishers, this page will only display the weekly assignments and not the edit options.<br>
            For OCLM Administrator access, please send a request to one of the <a href="javascript:void(0);" onclick="openAboutUsWindow()">admins</a></p>
        </div>
        
        <div style="width: 25%; margin: 0 auto; text-align: center;">
            <?php 
                if ( $_SESSION['admin'] == 'Super Admin' || $_SESSION['admin'] == 'Admin' ) {
                    include ( 'query-week.php' );
                } else {
                    include ( 'query-week-publishers.php' );
                }
            ?>
        </div>

        <div style="width: 75%; margin: 0 auto; text-align: center;">
            <?php include ( 'query-week-result.php' ); ?>
            <br>    
        </div>
        
        <div>
            <?php include ( "../private/shared/footer.php" ); ?>
        </div>
        
    </header>   

</body>
</html>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
<script>
    function openAboutUsWindow() {
      var url = "../public/about";
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