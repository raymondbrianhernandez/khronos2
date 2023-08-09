<?php
    include('../public/debug.php');
    session_start();      
    include('db_config.php'); 
    
    $username = $_POST['user'];  
    $password = $_POST['pass'];
        
    /* to prevent from mysqli injection */  
    $username = stripcslashes($username);  
    $password = stripcslashes($password);  
    $username = mysqli_real_escape_string($con, $username);  
    $password = mysqli_real_escape_string($con, $password);  
    
    $sql = "SELECT * 
            FROM logins 
            WHERE username = '$username' and password = '$password'";  
    $result = mysqli_query($con, $sql);  
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);  
    $count = mysqli_num_rows($result);  
    $_SESSION['owner']       = $row['name'];
    $_SESSION['username']    = $row['username'];
    $_SESSION['email']       = $row['email'];
    $_SESSION['password']    = $row['password'];
    $_SESSION['goal']        = $row['goal'];
    $_SESSION['security1']   = $row['security_questions1'];
    $_SESSION['answer1']     = $row['security_answer1'];
    $_SESSION['security2']   = $row['security_answer2'];
    $_SESSION['answer2']     = $row['security_questions2'];
    $_SESSION['elder_name']  = $row['elder_name'];
    $_SESSION['elder_email'] = $row['elder_email'];
    $_SESSION['elder_phone'] = $row['elder_phone'];
    $_SESSION['clockedIn']   = FALSE;
    $_SESSION['clockedOut']  = FALSE;
    $_SESSION['reported']    = FALSE;

    $curr_year = date('Y');
    $prev_year = (string)((int)date('Y') - 1);
    $currentDate = new DateTime();
    $startDate = DateTimeImmutable::createFromFormat('Y-m-d', $prev_year.'-09-01');
    $endDate = DateTimeImmutable::createFromFormat('Y-m-d', $curr_year.'-08-31');

     
    $_SESSION['service_year'] = $currentDate >= $startDate && $currentDate <= $endDate ? $curr_year : $_SESSION['service_year'] = $prev_year;
        
    if ( $count == 1 ) {  
        $_SESSION['logged_in'] = TRUE; /* print_r($_SESSION); */
        ?> 
        <script type = "text/javascript">
            alert("Welcome back <?= $_SESSION['owner']; ?>!");
            window.location = "../public/dashboard.php";
        </script>
        
        <?php
    } else { 
        ?> 
        <script type = "text/javascript">
            alert("Incorrect username or password.");
            window.location = "../public/index.php";
        </script>
        <?php 
    }

?>