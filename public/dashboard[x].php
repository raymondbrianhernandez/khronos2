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

    require_once ( "../private/secure.php" );
    require_once ( "../private/db_config.php" );
    include ( "debug.php" );

    $owner = $_SESSION['owner'];

    // Define an array of status values you want to count
    $statuses = ['new', 'valid', 'invalid', 'do not call'];

    // Initialize an array to store counts
    $countByStatus = [];

    // Use a loop to count each status
    foreach ( $statuses as $status ) {
        $query = "SELECT COUNT(status) FROM householders WHERE owner='$owner' AND status='$status'";
        $result = $con->query ( $query );
        $countByStatus[$status] = $result->fetch_row()[0];
    }

    $newAddr        = $countByStatus['new'];
    $validAddr      = $countByStatus['valid'];
    $invalidAddr    = $countByStatus['invalid'];
    $blockedAddr    = $countByStatus['do not call'];
    $accountOwner   = $countByStatus['new'];
    $currentCarrier = $_SESSION['carrier'];
    $currentGoal    = $_SESSION['goal'];
    $total          = $newAddr + $validAddr + $invalidAddr + $blockedAddr;

?>


<!DOCTYPE html>
<html lang="en">

<head>    
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title> Dashboard - Khronos Pro 2 </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" media="all" href="./stylesheets/charts.min.css" />
    <link rel="stylesheet" media="all" href="./stylesheets/phpvariables.php" />
    <link rel="stylesheet" media="all" href="./stylesheets/dashboard.css?v=1" />
    <!-- Map Libre -->
    <script src='https://unpkg.com/maplibre-gl@2.4.0/dist/maplibre-gl.js'></script>
    <link href='https://unpkg.com/maplibre-gl@2.4.0/dist/maplibre-gl.css' rel='stylesheet' />

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        if ( navigator.geolocation ) {
            navigator.geolocation.getCurrentPosition ( showPosition );
        } else {
            console.log ( "Geolocation is not supported by this browser." );
        }

        function showPosition ( position ) {
            var lat = position.coords.latitude;
            var lon = position.coords.longitude;
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if ( this.readyState == 4 && this.status == 200 ) {
                    console.log ( this.responseText );
                }   
            };
            
            xhttp.open ( "POST", "user-location.php", true );
            xhttp.setRequestHeader ( "Content-type", "application/x-www-form-urlencoded" );
            xhttp.send ( "lat=" + lat + "&lon=" + lon );
        }
    </script>
</head>

<body>
<header>
    <?php include ( "../private/shared/navigation.php" ); ?>

    <div class="mainbody">
        
        <div class="row d-flex justify-content-center"> 
            <p style="text-align:center;">
                <i>
                <?php
                    date_default_timezone_set ( "America/Los_Angeles" );  
                    $h = date ('G');

                    if ( $h >= 5 && $h <= 11 ) {
                        echo "Good morning, " . $_SESSION['owner'];
                    } else if ( $h >= 12 && $h <= 18 ) {
                        echo "Good afternoon, " . $_SESSION['owner'];
                    } else {
                        echo "Good evening, " . $_SESSION['owner'];
                    }

                    echo ' from ' . $_SESSION['congregation'] . ' congregation.'
                ?>  
                </i>
            </p>
            <br>
        </div>

        <div class="row d-flex justify-content-center">
            <h4><b> House to House Records Summary </b></h4>
            <!-- PIE CHART -->
            <div class="piechart">
                <style>
                    .piechart {
                        margin-top: 0px;
                        display: block;
                        width: 200px;
                        height: 200px;
                        border-bottom: 10px;
                        border-radius: 50%;

                        <?php if ( $total == 0 ) { ?>
                            background-image: conic-gradient(
                                purple 0 90deg
                            );
                        <?php } else { ?>
                            background-image: conic-gradient(
                                lightblue   <?= ( $newAddr/$total ) * 100 ?>%, 
                                lightgreen  <?= ( $newAddr/$total ) * 100 ?>% <?= ( ( $newAddr + $validAddr ) / $total) * 100 ?>%, 
                                orange      <?= ( ( $newAddr + $validAddr ) / $total ) * 100 ?>% <?= ( ( $newAddr + $validAddr + $invalidAddr) / $total) * 100 ?>%,
                                red         <?= ( ( $newAddr + $validAddr + $invalidAddr ) / $total ) * 100 ?>% <?= ( ( $newAddr + $validAddr + $invalidAddr + $blockedAddr) / $total ) * 100 ?>%
                            );
                        <?php } ?>
                    }
                </style>    
            </div>
            <div style="text-align:center">
                <br>
                <p style="color:lightblue"><b> New: <?php echo $newAddr; ?></b><p>
                <p style="color:lightgreen"><b> Valid: <?php echo $validAddr; ?></b><p> 
                <p style="color:orange"><b> Invalid: <?php echo $invalidAddr; ?></b><p>
                <p style="color:red"><b> Do not call: <?php echo $blockedAddr; ?></b><p>
            </div>
        
            <br>

            <!-- ADD NEW RECORD -->
            <!-- <div style="text-align: center;">
                <button type="button" class="collapsible" style="width: 50%; margin: 0 auto 20px auto; display: block;">
                    <h5><b> Click to add a new householder </b></h5>
                </button>
                <div class="content collapsible" style="width: 50%; margin: 0 auto 20px auto; display: block;">
                    <br>
                    <form action="insert.php" method="post">
                        
                        <input type="hidden" name="id" value="< = $row['Address_ID']; ?>" >
                        <input type="hidden" name="dropdown" value="< ?= $row['Status']; ?>" >
                    
                        <div class="row">
                            <div class="col-25">
                                <label for="status"> Status: </label>
                            </div>
                            <div class="col-75">
                                <select name = "status">
                                    <option value = "New"> New </option>
                                    <option value = "Valid"> Valid </option>
                                    <option value = "Invalid"> Invalid </option>
                                    <option value = "Do not call"> Do not call </option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-25">
                                <label for="name"> Name: </label>
                            </div>
                            <div class="col-75">
                                <input type="text" name="name" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-25">
                                <label for="suite"> Suite: </label>
                            </div>
                            <div class="col-75">
                                <input type="text" name="suite" >
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-25">
                                <label for="address"> Address: </label>
                            </div>
                            <div class="col-75">
                                <input type="text" name="address" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-25">
                                <label for="city"> City: </label>
                            </div>
                            <div class="col-75">
                                <input type="text" name="city" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-25">
                                <label for="province"> State: </label>
                            </div>
                            <div class="col-75">
                                < ?php include ( 'states.php' ); ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-25">
                                <label for="postal_code"> Zip code: </label>
                            </div>
                            <div class="col-75">
                                <input type="text" name="postal_code" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-25">
                                <label for="telephone"> Telephone: </label>
                            </div>
                            <div class="col-75">
                                <input type="text" name="telephone" >
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-25">
                                <label for="notes"> Notes: </label>
                            </div>
                            <div class="col-75">
                                <textarea rows="4" cols="auto" name="notes" required></textarea>
                            </div>
                        </div>
                        <br>
                        <div class="row" style="justify-content:center;">
                            <br>
                            <button id="greenbutton" type="submit" style="width:50%"> Add </button>
                            <br>
                        </div>

                    </form>
                    <br>
                </div>
            </div> -->
            <!-- END ADD NEW RECORD -->
                        
            <br>

            <!-- ACCOUNT INFORMATION -->
            <div style="text-align: center;">
                <button type="button" class="collapsible" style="width: 50%; margin: 0 auto 20px auto; display: block;">
                    <h5><b> Click to view/edit your account information </b></h5>
                </button>
                <div class="content collapsible" style="width: 50%; margin: 0 auto 20px auto; display: block;">
                    <br>
                    <form action="account.php" method="post"> 
                        <br>
                        <p>
                            <span><b> Name: </b></span><?= $_SESSION['owner']; ?>
                        </p>
                        <p>
                            <span><b> Username: </b></span><?= $_SESSION['username']; ?>
                        </p>
                        <p>
                            <span><b> Current Task/Goal: </b></span><?= $_SESSION['goal']; ?>
                        </p>
                        <p>
                            <b> Update Task/Goal: </b><span style="font-size:medium; color:red;">
                        </p>
                        <p>
                            <?php include ( 'goals.php' ); ?>
                        </p>
                        <hr>
                        
                        <p style="text-align:center"><b> Overseer Contact Information </b></p>
                        <div class="row">
                            <div class="col-25">
                                <label for="elder-name"> Overseer's name: </label>
                            </div>
                            <div class="col-75">
                                <input type="text" name="elder_name" value="<?= $_SESSION['elder_name']; ?>" >
                            </div>
                            <div class="col-25">
                                <label for="elder-email"> Overseer's Email: </label>
                            </div>
                            <div class="col-75">
                                <input type="email" name="elder_email" value="<?= $_SESSION['elder_email']; ?>" >
                            </div>
                            <div class="col-25">
                                <label for="elder-phone"> Overseer's Phone: </label>
                            </div>
                            <div class="col-75">
                                <input type="tel" name="elder_phone" value="<?= $_SESSION['elder_phone']; ?>" >
                            </div>
                            <div class="col-25">
                                <label for="carrier"> Phone Carrier: </label>
                            </div>
                            <div class="col-75">
                            <select name="carrier">
                                <option value="" <?= $currentCarrier == '' ? 'selected' : ''; ?>></option>    
                                <option value="@msg.fi.google.com" <?= $currentCarrier == '@msg.fi.google.com' ? 'selected' : ''; ?>>Google Fi</option>
                                <option value="@vtext.com" <?= $currentCarrier == '@vtext.com' ? 'selected' : ''; ?>>Verizon</option>
                                <option value="@txt.att.net" <?= $currentCarrier == '@txt.att.net' ? 'selected' : ''; ?>>AT&T/Cingular</option>
                                <option value="@tmomail.net" <?= $currentCarrier == '@tmomail.net' ? 'selected' : ''; ?>>T-Mobile</option>
                                <option value="@messaging.sprintpcs.com" <?= $currentCarrier == '@messaging.sprintpcs.com' ? 'selected' : ''; ?>>Sprint</option>
                            </select>
                                <p style="color:red;font-size:14px;"><b>NOTE:</b><i> Verizon have delays. </i></p>
                            </div>
                            
                        </div>
                        <hr>
                        <p style="text-align:center"><b> Change Email </b></p>
                        <div class="row">
                            <div class="col-25">
                                <label for="email"> Type New Email: </label>
                            </div>
                            <div class="col-75">
                                <input type="text" name="email" value=<?= $_SESSION['email']; ?> >
                            </div>
                        </div>

                        <div class="row" style="justify-content:center;">
                            <br>
                                <button id="greenbutton" type="submit" style="width:50%"> Update </button>
                            <br>
                        </div>

                    </form>
                    <br>
                </div>
            </div>
            <!-- END ACCOUNT INFORMATION -->

        </div>
    </div>
    <br>
    <div>
        <?php include ( "../private/shared/footer.php" ); ?>
    </div>
</header>   

</body>
</html>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var collapsibles = document.querySelectorAll(".collapsible");

        collapsibles.forEach(function(collapsible) {
            var content = collapsible.nextElementSibling;
            content.style.display = "none"; // Hide content by default

            collapsible.addEventListener("click", function() {
                if (content.style.display === "block") {
                    content.style.display = "none";
                } else {
                    content.style.display = "block";
                }
            });
        });
    });
</script>

