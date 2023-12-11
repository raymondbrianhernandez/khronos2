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

include 'db.php';
include '../public/debug.php';
require '../private/secure.php';

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
</head>

<body>

<header>
    <?php include '../private/shared/navigation.php'; ?>

    <div style="margin: 0 auto; text-align: center;">
        <?php include 'tms-navigation.php' ?>
    </div>

    <div style="text-align:center">
        <h5><?php echo $congregation ?> Congregation </h5>
        <h5>Publishers Master List</h5>
    </div>

    <!-- THIS PART IS ONLY SHOWN ON SUPER ADMINS AND ADMINS -->
    <?php if ( $authorized ) { ?>

        <div style="text-align: center; padding: 10px;">
            <form action="add_record.php" method="post" style="display: inline-block; text-align: left;">
                First Name: <input type="text" name="first_name" required><br>
                Last Name: <input type="text" name="last_name" required><br>
                Privilege: 
                <select name="privilege" required>
                    <option value="">Assign Privilege</option>
                    <option value="elder">Elder</option>
                    <option value="servant">Servant</option>
                    <option value="brother">Brother</option>
                    <option value="sister">Sister</option>
                </select>
                <br>
                <input type="submit" name="submit" value="Add Record" style="margin-top: 10px;">
            </form>
        </div>

        <div style="text-align: center; padding: 10px;">
            <table style="width:50%; margin: 0 auto;">
                <tr style="background: black; color: white;"><b>
                    <!-- <th>Congregation</th> -->
                    <th>FIRST NAME</th>
                    <th>LAST NAME</th>
                    <th>PRIVILEGE</th>
                    <th>ACTION</th>
                </tr></b>

                <style>
                    /* Background color to every odd row */
                    tr:nth-child(odd) {
                        background-color: #89CFF0; /* Baby blue color */
                    }
                </style>

                <?php

                $query = "SELECT id, first_name, last_name, privilege FROM publishers WHERE congregation = '$congregation' ORDER BY first_name, last_name ASC";
                // echo $query;
                $result = mysqli_query ( $tmscon, $query );
                while ( $row = mysqli_fetch_array ( $result ) ) {
                    echo "<tr>";
                    echo "  <td>" . $row['first_name'] . "</td>";
                    echo "  <td>" . $row['last_name'] . "</td>";
                    echo "  <td>" . ucfirst ( $row['privilege'] ) . "</td>";
                    echo "  <td><a href='edit.php?id=" . $row['id'] . "'>Edit</a> | ";
                ?>
                    <a href="javascript:void(0);" onclick="confirmDelete(<?php echo $row['id']; ?>)">Delete</a>
                <?php
                    echo "</td>";
                    echo "</tr>";
                }
                mysqli_close ( $tmscon );

                ?>

            </table>
        </div>

    <!-- ELSE SHOW THIS PART ONLY -->
    <?php } else { include ( 'public-view.php' ); } ?> 

    <div>
        <?php include ( "../private/shared/footer.php" ); ?>
    </div>

</header>

<script>
    function confirmDelete ( id ) {
        var r = confirm ( "Are you sure you want to delete this publisher?" );
        if ( r == true ) {
            window.location.href = "delete.php?id=" + id;
        }
    }
</script>

</body>
</html>