<?php

session_start();

// include ( '../public/debug.php' );
include ( 'db_config.php' );
include ( '../public/php/php_functions.php' );

// Check if the form was submitted via POST
if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {

    // Check if necessary data is set
    if ( isset ( $_POST['password1'], $_POST['password2'], $_SESSION['email'] ) ) {
        
        $password1 = $_POST['password1'];
        $password2 = $_POST['password2'];

        // Check if the passwords match
        if ( $password1 === $password2 ) {
            
            // Check for a successful connection
            if ( $con->connect_error ) {
                die ( "Connection failed: " . $con->connect_error );
            }

            // Hash the password
            $hashedPassword = password_hash ( $password1, PASSWORD_DEFAULT );

            // Update the user's password in the database
            $email = $_SESSION['email'];
            $sql = "UPDATE logins SET password = ? WHERE email = ?";
            $stmt = $con->prepare($sql);
            
            if ( $stmt ) {
                $stmt->bind_param ( "ss", $hashedPassword, $email );

                if ( $stmt->execute() ) {
                    redirect ( '../public/login', 'Password updated successfully!' );
                } else {
                    redirect ( '../public/logout', 'Error updating password. ' . $stmt->error );
                }
                $stmt->close();
            } else {
                redirect ( '../public/logout', 'Error preparing the SQL statement.' );
                echo "Error preparing the SQL statement.";
            }
            
            $con->close();
        } else {
            redirect ( '../public/resetpassword3', 'Passwords do not match' );
            exit;
        }
    } else {
        redirect ( '../public/logout', 'Invalid data provided.' );
        exit;
    }
} else {
    redirect ( '../public/logout', 'Invalid request.' );
    exit;
}

?>
