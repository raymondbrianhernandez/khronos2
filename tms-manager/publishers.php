<?php

include('db.php');
include('debug.php');
session_start();

if ( !isset ( $_SESSION['login'] ) ) {
    header ( 'LOCATION: index.php' ); 
    die();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JW TMS Manager</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link rel="stylesheet" href="raymondstyles.css">
</head>
<body>

<?php include ( 'navigation.php' ); ?> 

<div style="text-align:center">
    <strong>Publishers Manager</strong>
</div>

<div>
    <center>
    <br>
    <form action="add_record.php" method="post">
        <input type="hidden" name="congregation" value="Topanga Canyon Tagalog">
        First Name: <input type="text" name="first_name">
        Last Name: <input type="text" name="last_name">
        Privilege: <input type="text" name="privilege">
        <input type="submit" name="submit" value="Add Record">
    </form>
    <br>
    </center>
</div>

<div>
    <center>
    <table border="1" style="width:80%">
        <tr>
            <th>Congregation</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Privilege</th>
            <th>Action</th>
        </tr>

        <?php

        $query = "SELECT id, congregation, first_name, last_name, privilege FROM publishers ORDER BY first_name, last_name ASC";
        $result = mysqli_query($con, $query);
        while ($row = mysqli_fetch_array($result)) {
            echo "<tr>";
            echo "<td>" . $row['congregation'] . "</td>";
            echo "<td>" . $row['first_name'] . "</td>";
            echo "<td>" . $row['last_name'] . "</td>";
            echo "<td>" . $row['privilege'] . "</td>";
            echo "<td><a href='edit.php?id=" . $row['id'] . "'>Edit</a> | <a href='delete.php?id=" . $row['id'] . "'>Delete</a></td>";
            echo "</tr>";
        }
        mysqli_close ( $con );

        ?>

    </table>
    <br>

    <form action="delete.php" method="post">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        Are you sure you want to delete this record?
        <input type="submit" name="yes" value="Yes">
        <input type="submit" name="no" value="No">
    </form>

<?php

  if ( isset ( $_POST['yes'] ) ) {
    $query = "DELETE FROM publishers WHERE id=$id";
    mysqli_query ( $con, $query ) ;
    mysqli_close ( $con );
    header ( "Location: publishers.php" );
  }
  if ( isset ( $_POST['no'] ) ) {
    header ( "Location: publishers.php" );
  }

?>

</center>

</div>

</body>
</html>