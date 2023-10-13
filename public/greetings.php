<?php

date_default_timezone_set ( "America/Los_Angeles" );  
$h = date ('G');

if ( $h >= 5 && $h <= 11 ) {
    echo "Good morning, " . $_SESSION['owner'];
} else if ( $h >= 12 && $h <= 18 ) {
    echo "Good afternoon, " . $_SESSION['owner'];
} else {
    echo "Good evening, " . $_SESSION['owner'];
}

echo ' from ' . $_SESSION['congregation'] . ' congregation.'

?>