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
    <title>Contact Us - Khronos Pro 2</title>
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
    
    <div class="blog-title">
        <br>
        <h3> Contact the Developers / Admins </h3>
        <button onclick="closeWindow()">Close Window</button>
    </div>

    <div class="about-us" style="text-align:center;">
        <p>
            <b>Raymond Hernandez</b><br> 
            <i>Full-Stack, iOS, and Android Developer</i><br> 
            <b>E-mail:&nbsp;</b><a href="mailto:raymondhernandez@khronos.pro?subject=Inquiry about Service Records" style="color:blue"><i> raymondhernandez@khronos.pro </i></a><br>
            <b>Website:&nbsp;</b><a href="https://arbhie.com" target="_blank" style="color:blue"> arbhie.com </a>
        </p>
        <hr>
        <p>
            <b>Carla Hernandez</b><br> 
            <i>Full-Stack, iOS, and Android Developer</i><br> 
            <b>E-mail:&nbsp;</b><a href="mailto:carlahernandez@khronos.pro?subject=Inquiry about Service Records" style="color:blue"><i> carlahernandez@khronos.pro </i></a><br>
            <b>Website:&nbsp;</b><a href="https://appsbycarla.com" target="_blank" style="color:blue"> appsbycarla.com </a>
        </p>
        <hr>

        <form action="phpmailer-contactus.php" method="post">
            <h5>...or send us a message with this form</h5>
            <br>
            <label for="sender_name">Your Name:</label>
            <input type="text" id="sender_name" name="sender_name" required>
            <label for="sender_email">Your E-mail:</label>
            <input type="email" id="sender_email" name="sender_email" required>
            <label for="admin_email">Choose an Admin to contact:</label>
            <select id="admin_email" name="admin_email" required>
                <option value="" disabled selected>Select an Admin</option>
                <option value="raymondhernandez@khronos.pro">Raymond Hernandez</option>
                <option value="carlahernandez@khronos.pro">Carla Hernandez</option>
            </select>
            <label for="subject">Subject:</label>
            <input type="text" id="subject" name="subject" value="" required>
            <label for="message">Message:</label>
            <textarea id="message" name="message" rows="6" cols="40"></textarea>
            <button id="goldbutton" type="submit">Send Message</button>
        </form>
    </div>
        
    <footer>
    <!-- Start: Footer Basic -->
    <footer class="text-center">
        <div class="container  py-4 py-lg-5">
            <p class="mb-0" style="color:white;">
                &copy; <?php echo '2022 - ' . date('Y'); ?> Khronos Pro 2 by 
                <a href="https://arbhie.com" target="_blank" style="color:white;"> arbhie.com </a>
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
