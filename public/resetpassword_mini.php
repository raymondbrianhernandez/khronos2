 <?php 
    include ('debug.php');
    // Check if session hasn't been started and then start it
    if ( session_status() == PHP_SESSION_NONE ) {
        session_start();
    }

    // Check the session values for email and questions verification
    if ( isset ( $_SESSION['email_verified'] ) && $_SESSION['email_verified'] == true && 
         isset ( $_SESSION['questions_verified'] ) && $_SESSION['questions_verified'] == true ) {
    } else {
        // Close the current window using JavaScript
        echo '<script type="text/javascript">
                window.close();
              </script>';
        exit; // Stops further execution of the PHP script
    }
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
    <title>Reset Password - Khronos Pro 2</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" media="all" href="./stylesheets/styles.min.css"/>
</head>

<body>

<section class="position-relative py-4 py-xl-5"> 
    <div class="row d-flex justify-content-center">
        <div class="col-md-6 col-xl-4">
            <div class="card mb-5">
                <div class="d-flex flex-column align-items-center">
                    <form name="form" class="text-center" action="../private/authenticateNewPassword_mini.php" method="POST">
                        <div class="mb-3" style="padding:20px">
                            <h4>Reset your password</h4>
                            <input class="form-control" type="password" name="password1" required>
                            <b><label for="password1" style="text-align:left"> New Password: </label></b>
                            <p></p>
                            <input class="form-control" type="password" name="password2" required>
                            <b><label for="password2" style="text-align:left"> Re-type New Password: </label></b>
                            <p></p>
                            <button class="btn btn-primary d-block w-100" type="submit"> Update Password  </button>
                        </div>
                    </form>
                </div>
                <footer class="text-center">
                    <div class="container  py-4 py-lg-5">
                        <p class="mb-0">
                            &copy; <?php echo '2022 - ' . date('Y'); ?> Khronos Pro 2 by 
                            <a href="https://gudeprojects.be" target="_blank"> Raymond & Carla Hernandez </a>
                        </p>
                    </div>
                </footer>
            </div>
        </div>     
    </div>
</section>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>


</body>
</html>