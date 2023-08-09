<?php
    // This PHP script creates a new account and sends it to MySQL database
    // Passwords are hashed for security
    // 8/4/2023 - Raymond Hernandez

    include ( '../public/debug.php' ); 
    session_start();      
    include ( 'db_config.php' ); 

    function redirect ( $url, $message ) {
        echo "<script type='text/javascript'>
                alert('".$message."');
                window.location.href='".$url."';
              </script>";
    }

    $username       = $_POST['user'];
    $fullname       = $_POST['name'];
    $admin          = '';
    $congregation   = $_POST['congregation'];  
    $email          = $_POST['email'];  
    $password1      = $_POST['password1'];
    $password2      = $_POST['password2'];
    $goal           = $_POST['goal'];
    $sec_question1  = $_POST['security_questions1'];
    $sec_answer1    = $_POST['security_answer1'];
    $sec_answer2    = $_POST['security_answer2'];
    $sec_question2  = $_POST['security_questions2'];
    $elder_name     = ''; 
    $elder_email    = '';
    $elder_phone    = '';
    $carrier        = '';

    if ( $password1 == $password2 ) {
        $password = password_hash ( $password1, PASSWORD_DEFAULT );

        $sql = "INSERT INTO logins (username, password, name, admin, congregation, email, goal, security_questions1, security_answer1, security_questions2, security_answer2, elder_name, elder_email, elder_phone, carrier ) VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ? )";
        $stmt = $con->prepare ( $sql );
        $stmt->bind_param ( "sssssssssssssss", $username, $password, $fullname, $admin, $congregation, $email, $goal, $sec_question1, $sec_answer1, $sec_question2, $sec_answer2, $elder_name, $elder_email, $elder_phone, $carrier );
        
        // DEBUGGING SQL ONLY DO NOT EXECUTE!!!
        // $sqlDebug = "INSERT INTO logins (username, password, name, admin, congregation, email, goal, security_questions1, security_answer1, security_questions2, security_answer2, elder_name, elder_email, elder_phone) 
        // VALUES ('" . $username . "', '" . $password . "', '" . $fullname . "', '" . $admin . "', '" . $congregation . "', '" . $email . "', '" . $goal . "', '" . $sec_question1 . "', '" . $sec_answer1 . "', '" . $sec_question2 . "', '" . $sec_answer2 . "', '" . $elder_name . "', '" . $elder_email . "', '" . $elder_phone . "')";
        // echo $sqlDebug;
        
        if ( $stmt->execute() ) {
            redirect ( "../public/login.php", "Account created. Thank you for registering." );
        } else {
            echo "Account creation failed at database: ( " . $stmt->errno . " ) " . $stmt->error;
        }      
        $stmt->close();
        
    } else { 
        redirect ( "../public/registration.php", "Password doesn't match." );
    } 
?>