<?php

session_start();
$_SESSION['centerY'] = $_POST['lat'];
$_SESSION['centerX'] = $_POST['lon'];

?>