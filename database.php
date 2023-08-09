<?php

require_once('db_config.php');

function db_disconnect($con){
    if(isset($con)){
        mysqli_close($con);
    }
}
?>