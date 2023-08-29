<?php

session_start();

// include ( '../public/debug.php' );
include ( 'db_config.php' );      
include ( '../public/php/php_functions.php' );

$provided_answer1 = strtolower ( $_POST['security_answer1'] );
$provided_answer2 = strtolower ( $_POST['security_answer2'] );
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
        $_SESSION['questions_verified'] = true;
        header("Location: ../public/resetpassword3");
        exit;
    } else {
        // One or both answers are wrong
        // Redirect back to the form or show an error message
        redirect ( '../public/resetpassword2', 'One or both of the answers are incorrect. Please try again.' ); 
        exit;
    }
} else {
    // Email not found in the database
    header ( "Location: ../public/error.php?message=Email not found." );
    exit;
}

$stmt->close();
?>