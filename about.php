<?php 
    include "../private/db_config.php";
    include "debug.php";
    $phpVersion = phpversion();
    $mysqlVersion = $con->get_server_info();
    $apacheVersion = (isset($_SERVER['SERVER_SOFTWARE'])) ? $_SERVER['SERVER_SOFTWARE'] : 'Apache version not found'; 
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
    <title>Login - Khronos Pro 2</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" media="all" href="./stylesheets/styles.min.css"/>
    <link rel="stylesheet" media="all" href="./stylesheets/animatedbackground.css"/>

    <style>
        body {
            font-family: Arial, sans-serif;
        }

        form {
            width: 100%;
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
            background-color: blue;
            color: #fff;
            border: none;
            border-radius: 4px;
            padding: 10px 20px;
            cursor: pointer;
            font-size: 12px;
        }

        button:hover {
            background-color: #ffc200;
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
        <h3> Support Khronos PRO 2 by Donations/Volunteering </h3>
    </div>

    <div class="about-us">
        <p>
            This web application is designed for pioneers by pioneers. It's a tool for organizing
            house-to-house records, logging hours, jotting down essential notes, and seamlessly managing JW.org 
            research links that can be accessed securely online.  If you have experience in 
            <i><u> Mobile Apps Development (Android & IOS), HTML5, CSS, PHP, JQuery, Node.JS, Google APIs, and/or MySQL </u></i> 
            and want to collaborate with us to make this app better and more user-friendly please contact 
            any of the admins at:
        </p>
        <ul>
            <li> [Full-Stack] Raymond Hernandez: <a href="mailto:raymond@arbhie.com?subject=Inquiry about Service Records">
                <i> raymondhernandez@khronos.pro </i></a>
            </li>
            <li> [Full Stack] Carla Hernandez: <a href="mailto:carla@appsbycarla.com?subject=Inquiry about Service Records">
                <i> carlahernandez@khronos.pro </i></a>
            </li>
        </ul>

        <p>
            While we're proud to offer Khronos PRO 2 and its resources entirely for free, 
            it's worth noting that the hosting services, database maintenance, and domain parking are not without cost.
            These expenses are generously covered by dedicated admins/volunteers and want to keep this 
            web application running smoothly for everyone.
        </p>
        <p>
            If you've found value in what we offer and wish to contribute, your support would make 
            a significant difference. A donation, no matter how small, can help ensure the continued 
            availability and improvement of Khronos Pro 2.
        </p>
        <p>
            If you're interested in contributing, you can donate via:
        </p>

        <div style="text-align:center;">
            <a href="https://www.paypal.com/donate/?hosted_button_id=SJ5XC4AQQFKFU"><img src="../img/paypal.png" alt="PayPal" height="100px" /></a>
            <a href="https://www.venmo.com/u/doraemon23"><img src="../img/venmo.png" alt="Venmo" height="100px" /></a><br><hr>
            <!-- <h3>Send us a message</h3>  -->
        </div>

        <!-- <form action="phpmailer-contactus.php" method="post">
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
        </form> -->
    </div>
    
    <div class="technical">
        <h4>Technical Specs:</h4>
        <p>PHP <?= $phpVersion ?> </p>
        <p>MySQL <?= $mysqlVersion ?></p>
        <p>Apache <?= $apacheVersion ?></p>
        <p>HTML5 | Bootstrap v5.2.2</p>
        <p>Chart.js v2.8.0</p>
    </div>
        
    <footer>
    <!-- Start: Footer Basic -->
    <footer class="text-center">
        <div class="container  py-4 py-lg-5">
            <p class="mb-0" style="color:white;">
                &copy; <?php echo '2022 - ' . date('Y'); ?> Khronos Pro 2 by 
                <a href="https://gudeprojects.be" target="_blank" style="color:white;"> Raymond & Carla Hernandez </a>
            </p>
        </div>
    </footer>
    <!-- End: Footer Basic -->
</footer>

</body>
