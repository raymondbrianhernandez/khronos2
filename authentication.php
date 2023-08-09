<?php
    // 8/4/2023 - added password hashing (Raymond Hernandez)
    
    include ( '../public/debug.php' );
    session_start();      
    include ( 'db_config.php' ); 

    function redirect ( $url, $message ) {
        echo "<script type='text/javascript'>
                alert( '".$message."' );
                window.location.href='".$url."';
              </script>";
    }
    
    $username = $_POST['user'];  
    $_SESSION['password'] = $password = $_POST['pass'];

    $stmt = $con->prepare ( "SELECT * FROM logins WHERE username = ?" );
    $stmt->bind_param ( "s", $username) ;

    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ( $row && password_verify ( $password, $row['password'] ) ) {
        $_SESSION['owner']       = $row['name'];
        $_SESSION['username']    = $row['username'];
        $_SESSION['email']       = $row['email'];
        $_SESSION['goal']        = $row['goal'];
        $_SESSION['security1']   = $row['security_questions1'];
        $_SESSION['answer1']     = $row['security_answer1'];
        $_SESSION['security2']   = $row['security_questions2'];
        $_SESSION['answer2']     = $row['security_answer2'];
        $_SESSION['elder_name']  = $row['elder_name'];
        $_SESSION['elder_email'] = $row['elder_email'];
        $_SESSION['elder_phone'] = $row['elder_phone'];
        $_SESSION['carrier']     = $row['carrier'];
        $_SESSION['clockedIn']   = FALSE;
        $_SESSION['clockedOut']  = FALSE;
        $_SESSION['reported']    = FALSE;
        $_SESSION['logged_in']   = TRUE;

        $curr_year = date ( 'Y' );
        $prev_year = ( string )( ( int ) date( 'Y' ) - 1 );
        $currentDate = new DateTime();
        $startDate = DateTimeImmutable::createFromFormat( 'Y-m-d', $prev_year.'-09-01' );
        $endDate = DateTimeImmutable::createFromFormat( 'Y-m-d', $curr_year.'-08-31' );

        $_SESSION['service_year'] = $currentDate >= $startDate && $currentDate <= $endDate ? $curr_year : $prev_year;

        redirect ( "../public/dashboard.php", "Welcome back ".$_SESSION['owner']."!" );

    } else { 
        redirect ( "../public/login.php", "Incorrect username or password." );
    }
    $stmt->close();
?>
