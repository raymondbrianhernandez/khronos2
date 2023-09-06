<?php

include('db.php');
include('debug.php');
session_start();

// if ( ! isset ( $_SESSION['login'] ) ) {
//     header ( 'LOCATION:index.php' ); 
//     die();
// }

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
    
<?php include ( 'navigation.php' ) ?>

<center>
    <form method="post" action="array.php"> <!-- array.php -->
        <input type="text" style="width:50%" name="url" placeholder="Paste the JW Workbook Link here..."/> &nbsp;
        <button type="submit">Parse Data</button>&nbsp;
    </form>
</center>

<hr>
<h6>NOTE:</h6>
<p><i>Parsing and crawling JW Workbooks is slow so please wait till everything loads.</i></p>
<p><i>Only parse data if the most current workbook is not posted yet.  Please check the weeks below to verify to avoid re-parsing JW website.</p>
<?php 

$query = "SELECT DISTINCT week FROM assignments ORDER BY id ASC";
$result = mysqli_query ( $con, $query );
echo "Weeks available to edit ";
echo "<select name='week_select'></h6></center>";
echo "<option></option>";
while ( $row = mysqli_fetch_assoc ( $result ) ) {
    echo "<option value='" . $row['week'] . "'>" . $row['week'] . "</option>";
}
echo "</select>";

?>

<p><br>*Currently only works on English and Tagalog Workbooks. For example, click <a href="https://www.jw.org/tl/library/jw-workbook-para-sa-pulong/" target="_blank">JW Workbook Schedule</a> to grab all assignments.</i></p>

<?php include ( 'footer.php' ); ?>
</body>
</html>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
