<?php

session_start();

// Ensure email is set in the session and POST data exists
if ( !isset ( $_SESSION['email'] ) || !isset ( $_POST['security_answer1'] ) || !isset ( $_POST['security_answer2'] ) ) {
    header("Location: ../public/resetpassword.php?data missing");
    exit;
}

include ( '../public/debug.php' );     
include ( 'db_config.php' ); 

function redirect ( $url, $message ) {
    echo "<script type='text/javascript'>
            alert( '".$message."' );
            window.location.href='".$url."';
            </script>";
}

$provided_answer1 = strtolower($_POST['security_answer1']);
$provided_answer2 = strtolower($_POST['security_answer2']);
$email            = $_SESSION['email'];

$stmt = $con->prepare ( "SELECT security_answer1, security_answer2 FROM logins WHERE email = ?" );
$stmt->bind_param ( "s", $email ) ;

$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if ( $row ) {
    $stored_answer1 = strtolower ( $row['security_answer1'] );
    $stored_answer2 = strtolower ( $row['security_answer2'] );
    
    // Compare provided answers with stored answers
    if ( $provided_answer1 === $stored_answer1 && $provided_answer2 === $stored_answer2 ) {
        // Answers are correct
        // Redirect to the next step or action
        header("Location: resetpassword3.php");
        exit;
    } else {
        // One or both answers are wrong
        // Redirect back to the form or show an error message
        header("Location: ../public/error.php?message=Answers are incorrect.");
        exit;
    }
} else {
    // Email not found in the database
    header("Location: ../public/error.php?message=Email not found.");
    exit;
}

$stmt->close();
?>