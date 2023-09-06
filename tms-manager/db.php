<?php
   // LOCAL DEVELOPMENT 
   $host        = "localhost:3306";  
   $user        = "root";  
   $password    = "root";  
   $db_name     = "service_record";
   $con         = mysqli_connect ( $host, $user, $password, $db_name );
   
   if ( mysqli_connect_errno() ) {  
       die ( "Failed to connect with Local MySQL: ". mysqli_connect_error() );  
   } 

   // LIVE SERVER
   
  /*  $host        = "127.0.0.1:3306";  
   $user        = "u803325201_gudetama720";  
   $password    = "Gudetama720!?";  
   $db_name     = "u803325201_TMS_MANAGER";
   $con         = mysqli_connect($host, $user, $password, $db_name);
   
   if(mysqli_connect_errno()) {  
       die("Failed to connect with Online MySQL: ". mysqli_connect_error());  
   } */
    
?>