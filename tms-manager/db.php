<?php
   // LOCAL DEVELOPMENT 
//    $host        = "localhost:3306";  
//    $user        = "root";  
//    $password    = "root";  
//    $db_name     = "service_record";
//    $con         = mysqli_connect ( $host, $user, $password, $db_name );
   
//    if ( mysqli_connect_errno() ) {  
//        die ( "Failed to connect with Local MySQL: ". mysqli_connect_error() );  
//    } 

   // LIVE SERVER
   
   $host     = "127.0.0.1:3306";  
   $user     = $_SERVER['TMS_DATABASE_USER'];  
   $password = $_SERVER['TMS_DATABASE_PASS'];  
   $db_name  = $_SERVER['TMS_DATABASE_NAME'];
   $con      = mysqli_connect ( $host, $user, $password, $db_name );
   
   if ( mysqli_connect_errno() ) {  
       die ( "Failed to connect with Online MySQL: ". mysqli_connect_error() );  
   }
    
?>