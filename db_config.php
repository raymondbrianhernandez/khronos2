<?php
   // LOCAL DEVELOPMENT 
   $host        = "localhost";  
   $user        = "root";  
   $password    = "root";  
   $db_name     = "service_record";
   $con         = mysqli_connect($host, $user, $password, $db_name);
   
   if(mysqli_connect_errno()) {  
       die("Failed to connect with Local MySQL: ". mysqli_connect_error());  
   }   

   // LIVE SERVER
   /*
   $host        = "127.0.0.1:3306";  
   $user        = "u803325201_root";  
   $password    = "P@ssword1";  
   $db_name     = "u803325201_service_record";
   $con         = mysqli_connect($host, $user, $password, $db_name);
   
   if(mysqli_connect_errno()) {  
       die("Failed to connect with Online MySQL: ". mysqli_connect_error());  
   }
   */  
?>