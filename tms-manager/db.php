<?php
   // db.php
   
   $host     = "127.0.0.1";  
   $user     = $_SERVER['TMS_DATABASE_USER'];  
   $password = $_SERVER['TMS_DATABASE_PASS'];  
   $db_name  = $_SERVER['TMS_DATABASE_NAME'];
   $tmscon   = mysqli_connect ( $host, $user, $password, $db_name );
   
   if ( mysqli_connect_errno() ) {  
       die ( "Failed to connect with Online MySQL: ". mysqli_connect_error() );  
   } 
    
?>