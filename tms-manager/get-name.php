<?php

include('db.php');

if ( isset ( $_GET['id'] ) ) {
    $id = intval ( $_GET['id'] );
    $query = "SELECT first_name, last_name FROM publishers WHERE id = $id";
    $result = mysqli_query ( $con, $query );
    $row = mysqli_fetch_assoc ( $result );
    echo json_encode ( $row );
}

?>
