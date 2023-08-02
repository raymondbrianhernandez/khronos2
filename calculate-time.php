<?php
    // Clock in
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];
    $total_time = strtotime($end_time) - strtotime($start_time);
    echo "Total time worked: " . gmdate("H:i:s", $total_time);
?>