<?php

include('db.php');
include('debug.php');

if ( isset ( $_POST['update'] ) ) {
    $id           = $_POST['id'];
    $congregation = $_POST['congregation'];
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
    Congregation: <input type="text" name="congregation" value="<?php echo $congregation; ?>"><br><br>
    First Name: <input type="text" name="first_name" value="<?php echo $first_name; ?>"><br><br>
    Last Name: <input type="text" name="last_name" value="<?php echo $last_name; ?>"><br><br>
    Privilege: <input type="text" name="privilege" value="<?php echo $privilege; ?>"><br><br>
    <input type="submit" name="update" value="Update">
</form>
