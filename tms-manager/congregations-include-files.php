<?php

if ( session_status() !== PHP_SESSION_ACTIVE ) {
    session_start();
}

if ($_SESSION['congregation'] == "Topanga Cyn Tagalog") {
    include('all_names_topanga.php');
} elseif ($_SESSION['congregation'] == "Antelope Valley Tagalog") {
    include('all_names_antelope_valley.php');
} elseif ($_SESSION['congregation'] == "Bambang") {
    include('all_names_bambang.php');
} elseif ($_SESSION['congregation'] == "Bard Tagalog") {
    include('all_names_bard.php');
} elseif ($_SESSION['congregation'] == "Burbank Blvd Tagalog") {
    include('all_names_burbank_blvd.php');
} elseif ($_SESSION['congregation'] == "Central Guagua") {
    include('all_names_central_guagua.php');
} elseif ($_SESSION['congregation'] == "Hollywood Tagalog") {
    include('all_names_hollywood.php');
} elseif ($_SESSION['congregation'] == "Jose Abad Santos") {
    include('all_names_jose_abad_santos.php');
} elseif ($_SESSION['congregation'] == "Pacific Coast Tagalog") {
    include('all_names_pacific_coast.php');
} elseif ($_SESSION['congregation'] == "Queen Anne Tagalog") {
    include('all_names_queen_anne.php');
} elseif ($_SESSION['congregation'] == "Sand Cyn Tagalog") {
    include('all_names_sand_cyn.php');
} else {
    // Handle the case where the congregation is not in the list or not set
    echo "Congregation not found or not set in session.";
}
?>
