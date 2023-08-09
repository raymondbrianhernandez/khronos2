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
</head>

<body>

    <!-- These divs are needed for animated background -->
    <div class="bg"></div>
    <div class="bg bg2"></div>
    <div class="bg bg3"></div>
    <!-- Above divs are needed for animated background -->
    
    <div class="blog-title">
        <br>
        <h2> About Khronos Pro </h2>
        <p> ver. 2.0.1 </p>
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

        <form action="phpmailer-contactus.php" method="post">
            <!-- Sender's Name -->
            <label for="sender_name"> Your Name: </label><br>
            <input type="text" id="sender_name" name="sender_name" required><br>

            <!-- Sender's Email -->
            <label for="sender_email"> Your E-mail: </label><br>
            <input type="email" id="sender_email" name="sender_email" required><br>

            <!-- Admin's Email Dropdown -->
            <label for="elder_email"> Choose an Admin to contact: </label><br>
            <select id="elder_email" name="elder_email" required>
                <option value="raymondhernandez@khronos.pro">Raymond Hernandez</option>
                <option value="carlahernandez@khronos.pro">Carla Hernandez</option>
            </select><br>

            <!-- Subject -->
            <label for="subject"> Subject: </label><br>
            <input type="text" id="subject" name="subject" value="" ><br>

            <!-- Message -->
            <label for="message"> Message: </label><br>
            <textarea id="message" name="message" rows="12" cols="auto"><?= $text_msg ?></textarea><br>

            <!-- Submit Button -->
            <button id="goldbutton" type="submit"> Send Message </button>
        </form>


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
