<?php
    
include ( '../public/debug.php' );
session_start();      
include ( 'db_config.php' ); 

function redirect ( $url, $message ) {
    echo "<script type='text/javascript'>
            alert( '".$message."' );
            window.location.href='".$url."';
            </script>";
}

$email = $_POST['email'];  

$stmt = $con->prepare ( "SELECT * FROM logins WHERE email = ?" );
$stmt->bind_param ( "s", $email) ;

$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if ( $row ) {
    $_SESSION['owner']       = $row['name'];
    $_SESSION['username']    = $row['username'];
    $_SESSION['email']       = $row['email'];
    $_SESSION['security1']   = $row['security_questions1'];
    $_SESSION['answer1']     = $row['security_answer1'];
    $_SESSION['security2']   = $row['security_questions2'];
    $_SESSION['answer2']     = $row['security_answer2'];

    header ( "Location: ../public/resetpassword2.php" );

} else { 
    redirect ( "../public/resetpassword.php", "This email is not registered." );
}

$stmt->close();

?>
