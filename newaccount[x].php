<!-- 
    This PHP script creates new account and sends it to MySQL database
    8/4/2023 - Raymond Hernandez
-->

<?php
    include('../public/debug.php'); 
    session_start();      
    include('db_config.php'); 
    
    $username        = $_POST['user'];
    $fullname        = $_POST['name'];  
    $email           = $_POST['email'];  
    $password1       = $_POST['password1'];
    $password2       = $_POST['password2'];
    $goal            = $_POST['goal'];
    $sec_question1   = $_POST['security_questions1'];
    $sec_answer1     = $_POST['security_answer1'];
    $sec_answer2     = $_POST['security_answer2'];
    $sec_question2   = $_POST['security_questions2'];
    $elder_name      = ''; 
    $elder_email     = '';
    $elder_phone     = '';

    if ( $password1 == $password2 ) {
        /* to prevent from mysqli injection */  
        $username = stripcslashes( $username );  
        $password = stripcslashes( $password );  
        $username = mysqli_real_escape_string( $con, $username );  
        $password = mysqli_real_escape_string( $con, $password );

        $sql  = "INSERT INTO logins ";
        $sql .= "(`username`, `password`, `name`, `email`, `goal`, `security_questions1`, `security_answer1`, `security_questions2`, `security_answer2`, `elder_name`, `elder_email`, `elder_phone`) "; 
        $sql .= "VALUES ";
        $sql .= "('$username', '$password1', '$fullname', '$email', '$goal', '$sec_question1', '$sec_answer1', '$sec_question2', '$sec_answer2', '$elder_name', '$elder_email', '$elder_phone')";
        mysqli_query ( $con, $sql );
        
?>

        <script type = "text/javascript">
            alert("Account created. Thank you for registering.");
            window.location = "../public/login.php";
        </script>
<?php 
    } else { 
?>
        <script type = "text/javascript">
            alert("Password doesn't match.");
            window.location = "../public/registration.php";
        </script>
<?php
    } 
?>