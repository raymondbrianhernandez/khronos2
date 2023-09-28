<?php

include('db.php');
include('debug.php');
session_start();
/* session_destroy(); */
// It's a one user admin page.  No need to save users to DB
$_SESSION['username'] = 'admin';
$_SESSION['password'] = 'password';

if ( isset ( $_SESSION['login'])) {
    header('LOCATION:admin.php'); 
    die();
}

if(isset($_POST['submit'])){
    $username = $_POST['username']; $password = $_POST['password'];
    if($username === 'admin' && $password === 'password'){
        $_SESSION['login'] = true; 
        header('LOCATION:admin.php'); die();
    } {
        echo "<div class='alert alert-danger'>Username and Password do not match.</div>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JW TMS Manager</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link rel="stylesheet" href="raymondstyles.css">
</head>
<body>
    <div>
        <center>
            <h2> JW TMS Manager </h2>
            <h6> <?= date('F Y'); ?> version </h6>
        </center>
        <hr>
    </div> 
    
    <div style="width: fit-content; margin: 0 auto;">
        <form action="" method="post">
            <div class="mb-3">
                <input type="text" class="form-control" id="username" name="username" placeholder="Administrator" required>
            </div>
            <div class="mb-3">
                <input type="password" class="form-control" id="pwd" name="password" placeholder="Password" required>
            </div>
            <div class="mb-3">
                <button name="submit" class="btn btn-primary shadow d-block w-100" type="submit"> Log in </button>
            </div>
        </form>

        <?php include ( 'footer.php' ); ?>
    </div>
    
</body>
</html>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
