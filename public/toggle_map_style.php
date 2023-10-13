<?php
if ( session_status() !== PHP_SESSION_ACTIVE ) {
    session_start();
};

$regularMapStyle = 'https://api.maptiler.com/maps/streets/style.json?key=yIFC37lpVhEBM5HG2OUY';
$streetMapStyle = 'https://api.maptiler.com/maps/hybrid/style.json?key=yIFC37lpVhEBM5HG2OUY';

if ( $_SESSION['map_style'] == $streetMapStyle ) {
    $_SESSION['map_style'] = $regularMapStyle;
} else {
    $_SESSION['map_style'] = $streetMapStyle;
}

echo $_SESSION['map_style'];
