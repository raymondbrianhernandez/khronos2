<?php

include('db.php');
include('debug.php');
session_start();

// if(!isset($_SESSION['login'])) {
//     header('LOCATION:index.php'); 
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

<?php

/* PREPARE THE SQL STATEMENTS */
$query_elders           = "SELECT * FROM `publishers` WHERE `privilege`= 'elder'";
$query_ms               = "SELECT * FROM `publishers` WHERE `privilege`= 'servant'";
$query_ms_and_elders    = "SELECT * FROM `publishers` WHERE `privilege`= 'elder' OR `privilege`= 'servant'";
$query_all_brothers     = "SELECT * FROM `publishers` WHERE `privilege`= 'elder' OR `privilege`= 'servant' OR `privilege`= 'brother'";
$query_all_sisters      = "SELECT * FROM `publishers` WHERE `privilege`= 'sister'";

/***********************************************************************************/
/***** OUTPUTS ALL ELDERS AND COUNT HOW MANY DID CHAIRMAN **************************/
/***********************************************************************************/
echo "<hr><center><b>CHAIRMAN FREQUENCY</b></center><br>";
$query = "SELECT publishers.first_name, publishers.last_name, COUNT(assignments.assignee) AS count
          FROM publishers
          LEFT JOIN assignments ON CONCAT(publishers.first_name, ' ', publishers.last_name) = assignments.assignee AND assignments.part = 'Pambungad na Komento (1 min.)'
          WHERE publishers.privilege = 'elder'
          GROUP BY publishers.first_name, publishers.last_name";
$result = $con->query ( $query );

if ( $result->num_rows > 0 ) { ?>
    <center>
    <table style="width:50%">
        <thead>
            <tr>
                <th>Name</th>
                <th>Chairman Frequency</th>
            </tr>
        </thead>
        <tbody>

            <?php

            while ( $row = $result->fetch_assoc() ) {
                echo "<tr>";
                echo "<td>" . $row["first_name"] . " " . $row["last_name"] . "</td>";
                echo "<td>" . ($row["count"] > 0 ? $row["count"] : '') . "</td>";
                echo "</tr>";
            }

            ?>

        </tbody>
    </table>
    </center> 

<?php
 
} else {
    echo "No data found.<br>";
}
/***********************************************************************************/
?>

<?php

/***********************************************************************************/
/***** OUTPUTS ALL ELDERS/MS AND COUNT  ********************************************/
/***********************************************************************************/
echo "<hr><center><b>ELDER'S & SERVANT'S ASSIGNMENTS FREQUENCY</b></center><br>";
$query = "SELECT publishers.first_name, publishers.last_name,
                 SUM(CASE WHEN assignments.part LIKE '%”: (10 min.)' THEN 1 ELSE 0 END) AS count_part1,
                 SUM(CASE WHEN assignments.part = 'Espirituwal na Hiyas: (10 min.)' THEN 1 ELSE 0 END) AS count_part2,
                 SUM(CASE WHEN assignments.part LIKE 'Pagbabasa ng Bibliya%' THEN 1 ELSE 0 END) AS count_part3,
                 SUM(CASE WHEN assignments.part LIKE 'Pag-aaral ng Kongregasyon%' THEN 1 ELSE 0 END) AS count_part4,
                 SUM(CASE WHEN assignments.part LIKE '%Prayer' THEN 1 ELSE 0 END) AS count_part5, 
                 SUM(CASE WHEN assignments.part LIKE 'Lokal na Pangangailangan%' THEN 1 ELSE 0 END) AS count_part6,
                 SUM(CASE WHEN assignments.part LIKE '%video%' THEN 1 ELSE 0 END) AS count_part7
          FROM publishers
          LEFT JOIN assignments ON CONCAT(publishers.first_name, ' ', publishers.last_name) = assignments.assignee
          WHERE publishers.privilege = 'elder' OR publishers.privilege = 'servant'
          GROUP BY publishers.first_name, publishers.last_name";

$result = $con->query ( $query );

if ( $result->num_rows > 0 ) { ?>
    <center>
    <table style="width:90%">
        <thead>
            <tr>
                <th>Name</th>
                <th>Opening/Closing Prayer</th>
                <th>Treasures</th>
                <th>Spiritual Gems</th>
                <th>Bible Reading</th>
                <th>CBS</th>
                <th>Local Needs</th>
                <th>Video Talks</th>
            </tr>
        </thead>
        <tbody>

            <?php

            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["first_name"] . " " . $row["last_name"] . "</td>";
                echo "<td>" . ($row["count_part5"] > 0 ? $row["count_part5"] : '') . "</td>";
                echo "<td>" . ($row["count_part1"] > 0 ? $row["count_part1"] : '') . "</td>";
                echo "<td>" . ($row["count_part2"] > 0 ? $row["count_part2"] : '') . "</td>";
                echo "<td>" . ($row["count_part3"] > 0 ? $row["count_part3"] : '') . "</td>";
                echo "<td>" . ($row["count_part4"] > 0 ? $row["count_part4"] : '') . "</td>";
                echo "<td>" . ($row["count_part6"] > 0 ? $row["count_part6"] : '') . "</td>";
                echo "<td>" . ($row["count_part7"] > 0 ? $row["count_part7"] : '') . "</td>";
                echo "</tr>";
            }

            ?>

        </tbody>
    </table> 
    </center>

<?php
 
} else {
    echo "No data found.<br>";
}
/***********************************************************************************/
?>

<?php

/***********************************************************************************/
/***** OUTPUTS ALL STUDENTS AND COUNT HOW MANY DID ASSIGNED PARTS ******************/
/***********************************************************************************/
echo "<hr><center><b>BROTHER'S ASSIGNMENTS FREQUENCY</b></center><br>";
$query = "SELECT publishers.first_name, publishers.last_name,
                 SUM(CASE WHEN assignments.part LIKE 'Pagbabasa%' THEN 1 ELSE 0 END) AS count_part1,
                 /* SUM(CASE WHEN assignments.part LIKE 'Pagdalaw-Muli%' THEN 1 ELSE 0 END) AS count_part2,
                 SUM(CASE WHEN assignments.part LIKE 'Pag-aaral sa Bibliya%' THEN 1 ELSE 0 END) AS count_part3, */
                 SUM(CASE WHEN assignments.part LIKE 'Pahayag%' THEN 1 ELSE 0 END) AS count_part2
          FROM publishers
          LEFT JOIN assignments ON CONCAT(publishers.first_name, ' ', publishers.last_name) = assignments.assignee
          WHERE publishers.privilege = 'elder' OR publishers.privilege = 'servant' OR publishers.privilege = 'brother' 
          GROUP BY publishers.first_name, publishers.last_name";

$result = $con->query ( $query );

if ( $result->num_rows > 0 ) { ?>
    <center>
    <table style="width:60%">
        <thead>
            <tr>
                <th>Name</th>
                <th>Bible Reading</th>
                <th>Talk</th>
            </tr>
        </thead>
        <tbody>

            <?php

            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["first_name"] . " " . $row["last_name"] . "</td>";
                echo "<td>" . ($row["count_part1"] > 0 ? $row["count_part1"] : '') . "</td>";
                echo "<td>" . ($row["count_part2"] > 0 ? $row["count_part2"] : '') . "</td>";
                echo "</tr>";
            }

            ?>

        </tbody>
    </table> 
    </center>

<?php
 
} else {
    echo "No data found.<br>";
}
/***********************************************************************************/
?>

<?php

/***********************************************************************************/
/***** OUTPUTS ALL STUDENTS AND COUNT HOW MANY DID ASSIGNED PARTS ******************/
/***********************************************************************************/
echo "<hr><center><b>SISTER'S ASSIGNMENTS FREQUENCY</b></center><br>";
$query = "SELECT publishers.first_name, publishers.last_name,
                 SUM(CASE WHEN assignments.part LIKE 'Unang Pag-uusap%' THEN 1 ELSE 0 END) AS count_part1,
                 SUM(CASE WHEN assignments.part LIKE 'Pagdalaw-Muli%' THEN 1 ELSE 0 END) AS count_part2,
                 SUM(CASE WHEN assignments.part LIKE 'Pag-aaral sa Bibliya%' THEN 1 ELSE 0 END) AS count_part3
          FROM publishers
          LEFT JOIN assignments ON CONCAT(publishers.first_name, ' ', publishers.last_name) = assignments.assignee
          WHERE publishers.privilege = 'sister' 
          GROUP BY publishers.first_name, publishers.last_name";

$result = $con->query ( $query );

if ( $result->num_rows > 0 ) { ?>
    <center>
    <table style="width:60%">
        <thead>
            <tr>
                <th>Name</th>
                <th>Initial Visit</th>
                <th>Return Visit</th>
                <th>Bible Study</th>
            </tr>
        </thead>
        <tbody>

            <?php

            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["first_name"] . " " . $row["last_name"] . "</td>";
                echo "<td>" . ($row["count_part1"] > 0 ? $row["count_part1"] : '') . "</td>";
                echo "<td>" . ($row["count_part2"] > 0 ? $row["count_part2"] : '') . "</td>";
                echo "<td>" . ($row["count_part3"] > 0 ? $row["count_part3"] : '') . "</td>";
                echo "</tr>";
            }

            ?>

        </tbody>
    </table> 
    </center>

<?php
 
} else {
echo "No data found.<br>";
}
/***********************************************************************************/

?>

</body>
</html>