<?php

if ( session_status() == PHP_SESSION_NONE ) {
    session_start();
}

echo $_SESSION['owner'] . ', ' . $_SESSION['congregation'] . ' ';

if ( $_SESSION['admin'] == 'Super Admin' ) {
    echo '[Super Admin]';
} elseif ( $_SESSION['admin'] == 'Admin' ) {
    echo '[Admin]';
} else {
    echo '';
}
?>
