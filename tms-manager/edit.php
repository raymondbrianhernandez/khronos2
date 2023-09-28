<?php

if ( session_status() !== PHP_SESSION_ACTIVE ) {
    session_start();
}

include('db.php');
include('debug.php');

if ( isset ( $_POST['update'] ) ) {
    $id           = $_POST['id'];
    $congregation = $_SESSION['congregation'];
    $first_name   = $_POST['first_name'];
    $last_name    = $_POST['last_name'];
    $privilege    = $_POST['privilege'];

    $query = "UPDATE publishers SET congregation='$congregation', first_name='$first_name', last_name='$last_name', privilege='$privilege' WHERE id=$id";
    mysqli_query ( $con, $query );
    header ( "Location: publishers.php" );
}

$id = $_GET['id'];
$query = "SELECT * FROM publishers WHERE id=$id";
$result = mysqli_query ( $con, $query );

while ($row = mysqli_fetch_array ( $result ) ) {
    $congregation = $row['congregation'];
    $first_name   = $row['first_name'];
    $last_name    = $row['last_name'];
    $privilege    = $row['privilege'];

}

mysqli_close ( $con );

?>



<form action="edit.php" method="post">
    <input type="hidden" name="id" value="<?php echo $id; ?>">
    <b><?php echo $congregation; ?> Congregation </b><br><br>
    <b>First Name:</b> <input type="text" name="first_name" value="<?php echo $first_name; ?>"><br><br>
    <b>Last Name:</b> <input type="text" name="last_name" value="<?php echo $last_name; ?>"><br><br>
    <b>Privilege:</b>
    <select name="privilege" required>
        <option value="" disabled>Select a privilege</option>
        <?php
        $privilegesList = ["elder", "servant", "sister", "brother"];

        foreach ( $privilegesList as $priv ) {
            $selected = ( $priv == strtolower ( $privilege ) ) ? "selected" : "";
            echo "<option value='$priv' $selected>" . ucfirst ( $priv ) . "</option>";
        }
        ?>
    </select>
    <br><br>

    <input type="submit" name="update" value="Update">
    <input type="button" value="Cancel" onclick="window.location.href='publishers';">

</form>
