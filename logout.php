<?php

include '.\private\db_config.php';
session_start();
//destroy the session
session_unset();
//redirect to login page
header("location: login.php");

?>