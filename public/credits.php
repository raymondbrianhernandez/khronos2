<?php 
    include "../private/db_config.php";
    include "debug.php";
    $phpVersion = phpversion();
    $mysqlVersion = $con->get_server_info();
    $apacheVersion = ( isset ( $_SERVER['SERVER_SOFTWARE'])) ? $_SERVER['SERVER_SOFTWARE'] : 'Apache version not found'; 
?>

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

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
    <title>About Us - Khronos Pro 2</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" media="all" href="./stylesheets/styles.min.css"/>
    <link rel="stylesheet" media="all" href="./stylesheets/animatedbackground.css"/>

    <style>
        body {
            font-family: Arial, sans-serif;
        }

        form {
            width: 80%;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            background-color: #f9f9f9;
        }

        label {
            /* font-weight: bold; */
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="email"],
        select,
        textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        textarea { 
            resize: vertical;
        }

        button {
            background-color: #4D4DFF;
            color: #fff;
            border: none;
            border-radius: 4px;
            padding: 10px 20px;
            cursor: pointer;
            font-size: 12px;
        }

        button:hover {
            background-color: #8080FF;
        }

        a {
            color: white;
            text-decoration: none; /* Removes the underline */
        }

        a:hover {
            text-decoration: underline; /* Adds an underline when hovering over the link */
            color: gold;
        }
    </style>

</head>

<body>

    <!-- These divs are needed for animated background -->
    <div class="bg"></div>
    <div class="bg bg2"></div>
    <div class="bg bg3"></div>
    <!-- Above divs are needed for animated background -->
    
    <div class="technical">
        <h4><b>Technology Stack</b></h4>
        <a href="https://laravel.com/" target="_blank">
            PHP <?= $phpVersion ?></a><br>
        <a href="https://www.php.net/" target="_blank">
            Laravel 10</a><br>
        <a href="https://www.mysql.com/" target="_blank">
            MySQL <?= $mysqlVersion ?></a><br>
        <a href="https://httpd.apache.org/" target="_blank">
            Apache <?= $apacheVersion ?></a><br>
        <a href="https://www.w3.org/TR/html52/" target="_blank">
            HTML5</a> / 
        <a href="https://getbootstrap.com/" target="_blank">
            Bootstrap 5.2.2</a><br>
        <a href="https://cloud.google.com/" target="_blank">
            Google Cloud API</a><br>
        <a href="https://developer.apple.com/swift/" target="_blank">
            Apple Developer Account / Swift 5.0</a><br>
        <a href="https://developer.android.com/studio" target="_blank">
            Android Studio</a> / 
        <a href="https://kotlinlang.org/" target="_blank">
            Kotlin</a><br>
        <a href="https://dotnet.microsoft.com/" target="_blank">
            .NET Standard Library 2.0.3</a><br>
        <a href="https://dotnet.microsoft.com/" target="_blank">
            .NET Core SDK 7.0.307</a><br>
        <a href="https://dotnet.microsoft.com/" target="_blank">
            .NET Core Runtime 7.0.10</a><br>
        <a href="https://www.mysql.com/products/connector/" target="_blank">
            MySQL Connector 2.2.7</a><br>
        <a href="https://www.newtonsoft.com/json" target="_blank"
        >NewtonSoft JSON 13.0.3</a><br>
        <a href="https://docs.microsoft.com/en-us/xamarin/essentials/" target="_blank">
            Xamarin Essentials 1.8.0</a><br>
        <a href="https://docs.microsoft.com/en-us/xamarin/xamarin-forms/" target="_blank">
            Xamarin Forms 5.0.0.2612</a><br>
        <a href="https://maplibre.org/" target="_blank">
            MapLibre GL JS v2</a><br>
        <a href="https://www.chartjs.org/" target="_blank">
            Chart.js 2.8.0</a><br>
    </div>
        
    <hr>

    <div class="technical">
    <h4><b>Image Files</b></h4>
        <a target="_blank" href="https://www.flaticon.com/free-icons/homework" title="homework icons">Homework icons created by Freepik - Flaticon</a>
        <a target="_blank" href="https://www.flaticon.com/free-icons/stop-watch" title="stop watch icons">Stop watch icons created by manshagraphics - Flaticon</a><br>
        <a target="_blank" href="https://www.flaticon.com/free-icons/clock" title="clock icons">Clock icons created by Freepik - Flaticon</a><br>
        <a target="_blank" href="https://www.flaticon.com/free-icons/goal" title="goal icons">Goal icons created by Freepik - Flaticon</a><br>
        <a target="_blank" href="https://www.flaticon.com/free-icons/home" title="home icons">Home icons created by Vectors Market - Flaticon</a><br>
        <a target="_blank" href="https://www.flaticon.com/free-icons/book" title="book icons">Book icons created by Smashicons - Flaticon</a><br>
        <a target="_blank" href="https://www.flaticon.com/free-icons/magazine" title="magazine icons">Magazine icons created by Freepik - Flaticon</a><br>
        <a target="_blank" href="https://www.flaticon.com/free-icons/video-player" title="video player icons">Video player icons created by Freepik - Flaticon</a><br>
        <a target="_blank" href="https://www.flaticon.com/free-icons/engineer" title="engineer icons">Engineer icons created by Freepik - Flaticon</a><br>
        <a target="_blank" href="https://www.flaticon.com/free-icons/home" title="home icons">Home icons created by Freepik - Flaticon</a>
        <a target="_blank" href="https://www.pexels.com/photo/white-blue-and-gray-concrete-building-164338/">Photo by Pixabay from Pexels</a><br>
    </div>
        
    <footer>
    <!-- Start: Footer Basic -->
    <footer class="text-center">
    <button onclick="closeWindow()">Close Window</button>
        <div class="container  py-4 py-lg-5">
            <p class="mb-0" style="color:white;">
                &copy; <?php echo '2022 - ' . date('Y'); ?> Khronos Pro 2 by 
                <a href="https://gudeprojects.be" target="_blank" style="color:white;"> GudeProjects </a>
            </p>
        </div>
    </footer>
    <!-- End: Footer Basic -->
</footer>

</body>

<script>
    function closeWindow() {
        window.close();
    }
</script>
