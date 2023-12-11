<?php

if ( session_status() == PHP_SESSION_NONE ) {
    session_start();
}

// echo $_SESSION['owner'] . ', ' . $_SESSION['congregation'] . ' ';
echo $_SESSION['owner'];
echo ' [' . $_SESSION['admin'] . ']';

if ( $_SESSION['demo_mode'] == TRUE ) { echo "<span style='color:red'> - DEMO MODE</span>"; }

?>
