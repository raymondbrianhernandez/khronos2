<!--
██╗  ██╗██╗  ██╗██████╗  ██████╗ ███╗   ██╗ ██████╗ ███████╗    ██████╗     ██████╗ 
██║ ██╔╝██║  ██║██╔══██╗██╔═══██╗████╗  ██║██╔═══██╗██╔════╝    ╚════██╗   ██╔═████╗
█████╔╝ ███████║██████╔╝██║   ██║██╔██╗ ██║██║   ██║███████╗     █████╔╝   ██║██╔██║
██╔═██╗ ██╔══██║██╔══██╗██║   ██║██║╚██╗██║██║   ██║╚════██║    ██╔═══╝    ████╔╝██║
██║  ██╗██║  ██║██║  ██║╚██████╔╝██║ ╚████║╚██████╔╝███████║    ███████╗██╗╚██████╔╝
╚═╝  ╚═╝╚═╝  ╚═╝╚═╝  ╚═╝ ╚═════╝ ╚═╝  ╚═══╝ ╚═════╝ ╚══════╝    ╚══════╝╚═╝ ╚═════╝ 
June 7, 2023
Raymond Brian D. Hernandez 
Carla Regine R. Hernandez
-->

<?php

if ( session_status() !== PHP_SESSION_ACTIVE ) {
    session_start();
}

include ( 'db.php' );
include ( '../public/debug.php' );
require ( '../private/secure.php' );

if ( $_SESSION['admin'] == 'Super Admin' || $_SESSION['admin'] == 'OCLM Admin' ) {
    $authorized = TRUE;
} else {
    $authorized = FALSE;
}

$congregation = $_SESSION['congregation'];

?>

<!DOCTYPE html>
<html lang="en">
<head>    
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title> OCLM Manager - Khronos Pro 2 </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" media="all" href="../public/stylesheets/charts.min.css" />
    <link rel="stylesheet" media="all" href="../public/stylesheets/phpvariables.php" />
    <link rel="stylesheet" media="all" href="../public/stylesheets/dashboard.css" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <style>
        .centered-table {
            margin-left: auto;
            margin-right: auto;
            width: 50%;
            border-collapse: collapse; /* Ensures borders don't double up */
        }

        .centered-table th, 
        .centered-table td, 
        th, 
        td {
            border: 1px solid #ddd; /* This provides a border around each cell */
            padding: 8px; /* This provides some space between the cell content and its border */
            text-align: left;
        }

        .centered-table th, 
        th {
            background-color: #f2f2f2; /* This provides a light grey background to the header cells */
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        th:not(:first-child), 
        td:not(:first-child) {
            width: 12%; /* Equal width for other columns, you can adjust this percentage */
        }
    </style>
</head>

<body>

<header>
    <?php include ( "../private/shared/navigation.php" ); ?>

    <div style="margin: 0 auto; text-align: center;">
        <?php include ( 'tms-navigation.php' ) ?>
    </div>

    <div style="text-align:center">
        <h5><?php echo $congregation ?> Congregation </h5>
        <h5>Statistics</h5>
    </div>

<?php if ( $authorized ) { 

    /***********************************************************************************/
    /***** OUTPUTS ALL ELDERS AND COUNT HOW MANY DID CHAIRMAN **************************/
    /***********************************************************************************/
    echo "<hr><center><b>OUR CHRISTIAN LIFE & MINISTRY CHAIRMAN</b></center><br>";
    $stmt = $tmscon->prepare("SELECT publishers.first_name, publishers.last_name, COUNT(assignments.assignee) AS count
                        FROM publishers
                        LEFT JOIN assignments ON CONCAT(publishers.first_name, ' ', publishers.last_name) = assignments.assignee AND assignments.part = 'Pambungad na Komento (1 min.)'
                        WHERE publishers.privilege = 'elder' AND publishers.congregation = ?
                        GROUP BY publishers.first_name, publishers.last_name");

    $stmt->bind_param('s', $congregation);
    $stmt->execute();
    $result = $stmt->get_result(); 
    ?>

    <?php if ( $result->num_rows > 0 ) { ?>
        <table class="centered-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Count</th>
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

    <?php } else {
        echo "No data found.<br>";
    } ?>

    <?php

    /***********************************************************************************/
    /***** OUTPUTS ALL ELDERS/MS AND COUNT  ********************************************/
    /***********************************************************************************/
    echo "<hr><center><b>ELDER'S & SERVANT'S ASSIGNMENTS</b></center><br>";
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
            WHERE publishers.congregation = ? AND (publishers.privilege = 'elder' OR publishers.privilege = 'servant')
            GROUP BY publishers.first_name, publishers.last_name";

    $stmt = $tmscon->prepare($query);
    $stmt->bind_param("s", $congregation);  
    $stmt->execute();
    $result = $stmt->get_result();

    ?>

    <?php if ( $result->num_rows > 0 ): ?>
        <table class="centered-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Prayer</th>
                    <th>Treasures</th>
                    <th>Spiritual Gems</th>
                    <th>Bible Reading</th>
                    <th>CBS</th>
                    <th>Local Needs</th>
                    <th>Video Talks</th>
                </tr>
            </thead>
            <tbody>
                <?php while ( $row = $result->fetch_assoc() ): ?>
                    <tr>
                        <td><?= $row["first_name"] . " " . $row["last_name"] ?></td>
                        <td><?= $row["count_part5"] > 0 ? $row["count_part5"] : '' ?></td>
                        <td><?= $row["count_part1"] > 0 ? $row["count_part1"] : '' ?></td>
                        <td><?= $row["count_part2"] > 0 ? $row["count_part2"] : '' ?></td>
                        <td><?= $row["count_part3"] > 0 ? $row["count_part3"] : '' ?></td>
                        <td><?= $row["count_part4"] > 0 ? $row["count_part4"] : '' ?></td>
                        <td><?= $row["count_part6"] > 0 ? $row["count_part6"] : '' ?></td>
                        <td><?= $row["count_part7"] > 0 ? $row["count_part7"] : '' ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table> 
    <?php else: ?>
        <p style="text-align: center;">No data found.</p>
    <?php endif; ?>


    <?php

    /***********************************************************************************/
    /***** OUTPUTS ALL STUDENTS AND COUNT HOW MANY DID ASSIGNED PARTS ******************/
    /***********************************************************************************/
    echo "<hr><center><b>BROTHER'S ASSIGNMENTS</b></center><br>";
    $query = "SELECT publishers.first_name, publishers.last_name,
                    SUM(CASE WHEN assignments.part LIKE 'Pagbabasa%' THEN 1 ELSE 0 END) AS count_part1,
                    SUM(CASE WHEN assignments.part LIKE 'Pahayag%' THEN 1 ELSE 0 END) AS count_part2
            FROM publishers
            LEFT JOIN assignments ON CONCAT(publishers.first_name, ' ', publishers.last_name) = assignments.assignee
            WHERE (publishers.privilege = 'elder' OR publishers.privilege = 'servant' OR publishers.privilege = 'brother') AND publishers.congregation = '$congregation'
            GROUP BY publishers.first_name, publishers.last_name";

    $result = $tmscon->query ( $query );

    if ( $result->num_rows > 0 ) { ?>

        <table class="centered-table">
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

    <?php
    } else {
        echo "<center>No data found.</center><br>";
    } 

    /***********************************************************************************/
    /***** OUTPUTS ALL STUDENTS AND COUNT HOW MANY DID ASSIGNED PARTS ******************/
    /***********************************************************************************/
    echo "<hr><center><b>SISTER'S ASSIGNMENTS</b></center><br>";
    $query = "SELECT publishers.first_name, publishers.last_name,
                    SUM(CASE WHEN assignments.part LIKE 'Unang Pag-uusap%' THEN 1 ELSE 0 END) AS count_part1,
                    SUM(CASE WHEN assignments.part LIKE 'Pagdalaw-Muli%' THEN 1 ELSE 0 END) AS count_part2,
                    SUM(CASE WHEN assignments.part LIKE 'Pag-aaral sa Bibliya%' THEN 1 ELSE 0 END) AS count_part3
            FROM publishers
            LEFT JOIN assignments ON CONCAT(publishers.first_name, ' ', publishers.last_name) = assignments.assignee
            WHERE publishers.privilege = 'sister' AND publishers.congregation = '$congregation' 
            GROUP BY publishers.first_name, publishers.last_name";

    $result = $tmscon->query ( $query );

    if ($result->num_rows > 0) { ?>

        <table class="centered-table" style="width:60%;">
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

    <?php
    } else {
        echo "<div style='text-align:center;'>No data found.</div><br>";
    }
    /***********************************************************************************/
} else { 
    include ( 'public-view.php' ); } 
?>

<div>
    <?php include ( "../private/shared/footer.php" ); ?>
</div>

</body>
</html>