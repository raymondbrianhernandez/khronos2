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
    <title>Registration - Service Records</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" media="all" href="./stylesheets/styles.min.css?v=12"/>
    <link rel="stylesheet" media="all" href="./stylesheets/animatedbackground.css"/>
</head>

<body>
    <!-- These divs are needed for animated backgroound -->
    <div class="bg"></div>
    <div class="bg bg2"></div>
    <div class="bg bg3"></div>
    <!-- Above divs are needed for animated backgroound -->
    
    <header>
        <!-- Start: Navbar Right Links (Dark) -->
        <nav class="navbar navbar-dark navbar-expand-md bg-dark py-3">
                <div class="container">
                    <img src="../img/khronos.gif" alt="logo" height="100px">
                    <a class="navbar-brand d-flex align-items-center" href="#">
                        <span> Khroʹnos 2 Service Records </span>
                    </a>
                        <button data-bs-toggle="collapse" class="navbar-toggler" data-bs-target="#navcol-5">
                            <span class="visually-hidden"> Toggle navigation </span>
                            <span class="navbar-toggler-icon"></span>
                        </button>
                    <div class="collapse navbar-collapse" id="navcol-5">
                        <ul class="navbar-nav ms-auto">
                            <li class="nav-item"><a class="nav-link active" href="index.php"> Home </a></li>
                            <li class="nav-item"><a class="nav-link active" href="registration.php"> Register </a></li>
                            <li class="nav-item"><a class="nav-link active" href="logout.php"> Sign out </a></li>
                        </ul>
                    </div>
                </div>
            </nav>
            <!-- End: Navbar Right Links (Dark) -->
        
        <main>
            <!-- Start: Login Form Basic -->
            <section class="position-relative py-4 py-xl-5">
                <div class="container">
                    <div class="row mb-5">
                        <div class="col-md-8 col-xl-6 text-center mx-auto">
                            <h2> Register a new account </h2>
                            <p class="w-lg-50">"Go, therefore, and make disciples of people of all the nations" <br>(<i>Matthew 28:19a, NWT</i>)</p>
                        </div>
                    </div>
                    <div class="row d-flex justify-content-center" id="login-screen">
                        <div class="col-md-6 col-xl-4">
                            <div class="card mb-5">
                                <div class="card-body d-flex flex-column align-items-center">
                                    <div class="bs-icon-xl bs-icon-circle bs-icon-primary bs-icon my-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" class="bi bi-house-door">
                                            <path d="M8.354 1.146a.5.5 0 0 0-.708 0l-6 6A.5.5 0 0 0 1.5 7.5v7a.5.5 0 0 0 .5.5h4.5a.5.5 0 0 0 .5-.5v-4h2v4a.5.5 0 0 0 .5.5H14a.5.5 0 0 0 .5-.5v-7a.5.5 0 0 0-.146-.354L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.354 1.146zM2.5 14V7.707l5.5-5.5 5.5 5.5V14H10v-4a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5v4H2.5z"></path>
                                        </svg>
                                    </div>

                                    <form name="form" class="text-center" action="../private/newaccount.php" onsubmit = "return validation()" method="POST">
                                        <div class="mb-3">
                                            <input type="text" class="form-control" name="name" required>
                                            <b><label for="name"> Full name: </label></b>
                                        </div>

                                        <div class="mb-3">
                                            <?php include( 'goals.php' ); ?>
                                            <b><label for="goal"> Current Task: </label></b>
                                        </div>

                                        <div class="mb-3">
                                            <input type="text" class="form-control" name="user" required>
                                            <b><label for="user"> Username: </label></b>
                                        </div>

                                        <div class="mb-3">
                                            <input type="text" class="form-control" name="email" required>
                                            <b><label for="email"> E-mail: </label></b>
                                        </div>

                                        <div class="mb-3">
                                            <input type="password" class="form-control" name="password1" required>
                                            <b><label for="password1"> Create New Password: </label></b>
                                        </div>

                                        <div class="mb-3">
                                            <input type="password" class="form-control" name="password2" required>
                                            <b><label for="password2"> Re-type Password: </label></b>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <button class="btn btn-primary d-block w-100" type="submit"> Register </button>
                                        </div>

                                        <p class="text-muted" style="text-align:center; color:white">
                                            Already have an account? <a href='index.php'>Login Here</a>
                                        </p>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
            </section>
            <!-- End: Login Form Basic -->
        </main>
    </header>
    
    <footer>
        <!-- Start: Footer Basic -->
        <footer class="text-center">
            <div class="container text-muted py-4 py-lg-5">
                <p class="mb-0">
                    &copy; <?php echo date('Y'); ?> Service Records | <a href="https://www.arbhie.com" target="_blank">arbhie.com</a> by Raymond Hernandez
                </p>
            </div>
        </footer>
        <!-- End: Footer Basic -->
    </footer>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>