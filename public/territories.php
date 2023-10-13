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

    require ( "../private/secure.php" );
    require_once ( "../private/db_config.php" );
    include ( "./php/php_functions.php" );
    //include ( "debug.php" );

    $query = 'SELECT @i:=@i+1 AS num, householders.* FROM householders, (SELECT @i:=0) i WHERE owner="'.$_SESSION['owner']. '" ORDER BY Address_ID DESC LIMIT ?,?';

    // Google Maps API
    // $googlemap = "https://www.google.com/maps/search/?api=1&query=";
    $googlemap = "https://www.google.com/maps/dir//";

    // PAGINATION
    // Check if the form was submitted and update the session offset
    if ( isset ( $_POST['offset'] ) ) {
        $_SESSION['offset'] = $_POST['offset'];
    }
    $num_results_on_page = 1000; // Default

    // Update num_results_on_page if session offset is set
    if ( isset ( $_SESSION['offset'] ) ) {
        $num_results_on_page = $_SESSION['offset'];
    }
    $total_pages = $con->query('SELECT COUNT(status) FROM householders WHERE owner='.'"'.$_SESSION['owner'].'"')->fetch_row()[0];
    $page = isset ( $_GET['page'] ) && is_numeric ( $_GET['page'] ) ? $_GET['page'] : 1;
    $_SESSION['page'] = $page;
    
    // Magic table happens...
    if ( $stmt = $con->prepare( $query ) ) { // closing brackets at the bottom of HTML
        // Calculate the page to get the results we need from our table.
        $calc_page = ( $page - 1 ) * $num_results_on_page;
        $stmt->bind_param( 'ii', $calc_page, $num_results_on_page );
        $stmt->execute();
        
        // Get the results...
        $result = $stmt->get_result();
    
    // Prepare the Map Markers
    $gps_query = "SELECT latitude, longitude FROM householders WHERE owner='".$_SESSION['owner']."'";
    $gps_result = mysqli_query( $con, $gps_query );
    $markers = array();
    while ( $row = mysqli_fetch_assoc( $gps_result ) ) {
        $markers[] = $row;
    }

    // Users GPS Location
    $lon = $_SESSION['centerY'];
    $lat = $_SESSION['centerX'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Master Territories - Service Records</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous"> 
    <link rel="stylesheet" media="all" href="./stylesheets/webapp_styles.css"/>
    <link rel="stylesheet" media="all" href="./stylesheets/dashboard.css"/>
    <link rel="stylesheet" media="all" href="./stylesheets/territories.css"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- <script src="../public/src/javascript.js"></script> -->
    <!-- Map Libre -->
    <script src='https://unpkg.com/maplibre-gl@2.4.0/dist/maplibre-gl.js'></script>
    <link href='https://unpkg.com/maplibre-gl@2.4.0/dist/maplibre-gl.css' rel='stylesheet' />
</head>
    
<body>
<header>
    <?php include("../private/shared/navigation.php"); ?>

    <main>
        <!-- Start: Login Form Basic -->
        <section class="position-relative py-4 py-xl-5">
            <div class="container">
                <div class="row mb-5">
                    <div class="col-md-8 col-xl-6 text-center mx-auto">
                        <h2 style="color:black"> House-to-house Records </h2>
                    </div>
                </div>
                
                <!-------------------------------- MAP AREA -------------------------------->
                <?php include ( "../public/map.php" ); ?>
                <!------------------------------ END MAP AREA ------------------------------>
                
                <hr>

                <div class="row d-flex justify-content-center" id="search">
                    <div class="col-md-9"> <!-- Adjust the column width as needed (75%) -->
                        <div class="search-bar">
                            <input type="text" id="search-input" style="width: 100%" placeholder="Search for names, addresses, phones, notes, etc...">
                            <button class="btn btn-primary" onclick="location.reload()">Reset/Reload</button>
                        </div>
                    </div>
                    <div class="col-md-3"> <!-- Adjust the column width as needed (25%) -->
                        <div class="offset">
                            <form method="POST" action="offset.php">
                                <div class="form-group d-flex align-items-center">
                                    <label for="results-per-page" style="margin-right: 10px;">Records per page:</label>
                                    <select id="results-per-page" name="offset" class="form-select" style="width: 100%;"> <!-- Set width to 100% to fill the entire column -->
                                        <option value="5"   <?php if ($_SESSION['offset'] == 5)   echo 'selected'; ?>>5  </option>
                                        <option value="10"  <?php if ($_SESSION['offset'] == 10)  echo 'selected'; ?>>10 </option>
                                        <option value="15"  <?php if ($_SESSION['offset'] == 15)  echo 'selected'; ?>>15 </option>
                                        <option value="25"  <?php if ($_SESSION['offset'] == 25)  echo 'selected'; ?>>25 </option>
                                        <option value="50"  <?php if ($_SESSION['offset'] == 50)  echo 'selected'; ?>>50 </option>
                                        <option value="100" <?php if ($_SESSION['offset'] == 100) echo 'selected'; ?>>100</option>
                                        <option value="1000" <?php if ($_SESSION['offset'] == 1000) echo 'selected'; ?>>Show All</option>
                                    </select>
                                    <button type="submit" class="btn btn-primary">Apply</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <hr>

                <!-------------------------------- RECORDS --------------------------------->
                <div class="table-responsive">
                    <table id="address-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Status</th>
                                <th>Name</th>
                                <th>Address</th>
                                <th>Map</th>
                                <th>Telephone</th>
                                <th>Notes</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        
                        <tbody>

                        <?php

                            $markers = [];
                            while ( $row = $result->fetch_assoc() ):
                                $tempAddr = $row['Address'].', '.$row['Suite'].' '.$row['City'].' '.$row['Province'].' '.$row['Postal_code'];
                                $markers[] = ['lon' => $row['Longitude'], 'lat' => $row['Latitude']];
                        
                        ?>
                            <!-- Regular Row -->
                            <tr>
                                <td class="center"><?= $row['num'] + ($page-1) * $num_results_on_page; ?></td>
                                <td class="center status-<?= strtolower(str_replace(' ', '-', $row['Status'])); ?>"><b><?= $row['Status']; ?></b></td>
                                <td>&nbsp;<?= $row['Name']; ?></td>
                                <td>&nbsp;<?= $tempAddr; ?></td>
                                <td class="center"><a href="<?= $googlemap.$tempAddr?>" target="_blank">Directions</a></td>
                                <td class="center"><a href="tel:<?= $row['Telephone']; ?>"><?= $row['Telephone']; ?></a></td>
                                <td><?= $row['Notes']; ?></td>
                                <td class="center action-buttons">
                                    <button class="btn btn-primary" data-toggle="toggle">Edit</button>
                                </td>   
                            </tr>
                            
                            <!-- Edit Row -->
                            <tr class="hideTr">
                                <form action="edit.php" method="post">
                                    <td colspan="8">
                                        <div style="display: flex; justify-content: space-between;">
                                            <!-- Column 1 -->
                                            <div style="flex: 1; padding: 10px;">

                                                <!-- Name -->
                                                <div class="input-group" style="display: flex; align-items: center;">
                                                    <label for="name" class="input-label" style="flex: 0.5; font-weight: bold;">Name:</label>
                                                    <input type="text" name="name" value="<?= $row['Name']; ?>" style="flex: 2;">
                                                </div>

                                                <!-- Suite -->
                                                <div class="input-group" style="display: flex; align-items: center;">
                                                    <label for="suite" class="input-label" style="flex: 0.5; font-weight: bold;">Suite:</label>
                                                    <input type="text" name="suite" value="<?= $row['Suite']; ?>" style="flex: 2;">
                                                </div>

                                                <!-- Address -->
                                                <div class="input-group" style="display: flex; align-items: center;">
                                                    <label for="address" class="input-label" style="flex: 0.5; font-weight: bold;">Address:</label>
                                                    <input type="text" name="address" value="<?= $row['Address']; ?>" style="flex: 2;">
                                                </div>

                                                <!-- City -->
                                                <div class="input-group" style="display: flex; align-items: center;">
                                                    <label for="city" class="input-label" style="flex: 0.5; font-weight: bold;">City:</label>
                                                    <input type="text" name="city" value="<?= $row['City']; ?>" style="flex: 2;">
                                                </div>

                                                <!-- State/Province -->
                                                <div class="input-group" style="display: flex; align-items: center;">
                                                    <label for="province" class="input-label" style="flex: 0.5; font-weight: bold;">State:</label>
                                                    <input type="text" name="province" value="<?= $row['Province']; ?>" style="flex: 2;">
                                                </div>

                                                <!-- Zipcode/Postal Code -->
                                                <div class="input-group" style="display: flex; align-items: center;">
                                                    <label for="postal_code" class="input-label" style="flex: 0.5; font-weight: bold;">Zipcode:</label>
                                                    <input type="text" name="postal_code" value="<?= $row['Postal_code']; ?>" style="flex: 2;">
                                                </div>

                                            </div>

                                            <!-- Column 2 -->
                                            <div style="flex: 1; padding: 10px;">

                                                <!-- Telephone -->
                                                <div class="input-group" style="display: flex; align-items: center;">
                                                    <label for="telephone" class="input-label" style="flex: 0.5; font-weight: bold;">Telephone:</label>
                                                    <input type="text" name="telephone" value="<?= $row['Telephone']; ?>" style="flex: 2;">
                                                </div>

                                                <!-- Status Dropdown -->
                                                <div class="input-group" style="display: flex; align-items: center;">
                                                    <label for="dropdown" class="input-label" style="flex: 0.5; font-weight: bold;">Status:</label>
                                                    <select name="dropdown" style="flex: 2;">

                                                        <!-- Dynamically generated selected option -->
                                                        <option value="<?= $row['Status']; ?>"><?= $row['Status']; ?></option>
                                                        
                                                        <?php 
                                                        // List of all status options
                                                        $statuses = ["Valid", "New", "Invalid", "Do not call"];

                                                        // Remove the current status from the list to prevent duplicates
                                                        $statuses = array_diff($statuses, [$row['Status']]);

                                                        // Render the rest of the options
                                                        foreach ($statuses as $status) {
                                                            echo "<option value=\"$status\">$status</option>";
                                                        }
                                                        ?>
                                                        
                                                    </select>
                                                </div>

                                                <!-- Notes -->
                                                <div class="input-group" style="display: flex; align-items: flex-start;">
                                                    <label for="notes" class="input-label" style="flex: 0.5; font-weight: bold;">Notes:</label>
                                                    <textarea rows="7" cols="40" name="notes" style="flex: 2;"><?= $row['Notes']; ?></textarea>
                                                </div>

                                                <!-- Geotag -->
                                                <div class="input-group" style="display: flex; align-items: center;">
                                                    <label for="gps" class="input-label" style="flex: 0.5; font-weight: bold;">Geotag:</label>
                                                    <input type="text" name="gps" value="<?= $row['Latitude'] . ' ' . $row['Longitude']; ?>" style="flex: 2;">
                                                </div>
                                                
                                                <!-- Hidden fields -->
                                                <input type="hidden" name="address_id" value="<?= $row['Address_ID']; ?>">
                                                <!-- <input type="hidden" name="dropdown" value="< ?= $row['Status']; ?>"> -->
                                                
                                            </div>
                                        </div>
                                        
                                        <div class="input-group center button-area">
                                            <button class="btn btn-primary save-button" type="submit">Save</button>
                                            <button class="btn btn-primary delete-button" type="submit" formaction="delete.php" onclick="return confirm('Are you sure you want to delete this entry?');">Delete</button>
                                        </div>
                                    </td>
                                </form>
                            </tr>
                        <?php endwhile; ?>
                        </tbody>
                    </table>  
                </div> <!-- table-responsive -->

                <hr>
                
                <!-- ADD NEW RECORD -->
                <button type="button" class="collapsible add-record">
                    <h5><b> Click to add new householder </b></h5>
                </button>
                <div class="content">
                    <br>
                    <form action="insert.php" method="post">
                        <!-- Get the hidden values -->
                        <input type="hidden" name="id" value="<?= $row['Address_ID']; ?>" >
                        <input type="hidden" name="dropdown" value="<?= $row['Status']; ?>" >
                    
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
                                <?php include ( 'states.php' ); ?>
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
                <!-- END ADD NEW RECORD -->

                <form action="export-csv.php" method="POST"><br>
                    <button type="submit" id="greenbutton"> Download Your Address Book (.CSV) </button>
                </form>

                <footer>
                    <?php 
                        include('../private/shared/pagination.php');
                        include("../private/shared/footer.php"); 
                    ?>
                <!-- End: Footer Basic -->
                </footer>
                            
            </div> <!-- Container -->
        </section>
    <!-- End: Login Form Basic -->
    </main>
</header>

<?php } ?>
<?php $stmt->close(); ?>

</body>
</html>

<script>
    // TOGGLES 'EDIT' BUTTON IN TERRITORIES.PHP
jQuery (document).ready(function($) {
    $(document).ready(function () {  
        debugger;  
        $('.hideTr').slideUp(600);  
        $('[data-toggle="toggle"]').click(function () {  
        if ($(this).parents().next(".hideTr").is(':visible')) {  
            $(this).parents().next('.hideTr').slideUp(600);  
            $(".plusminus" + $(this).children().children().attr("id")).text('+');  
            // $(this).css('background-color', 'black');  
            }  
        else {  
            $(this).parents().next('.hideTr').slideDown(600);  
            $(".plusminus" + $(this).children().children().attr("id")).text('- ');  
            // $(this).css('background-color', 'black ');    
        }  
        });  
    });
});

// TOGGLES 'ADD NEW HOUSEHOLDER' IN TERRITORIES.PHP
var coll = document.getElementsByClassName( "collapsible" );
var i;

for ( i = 0; i < coll.length; i++ ) {
    coll[i].addEventListener ( "click", function() {
        this.classList.toggle ( "active" );
        var content = this.nextElementSibling;
        if ( content.style.display === "block" ) {
            content.style.display = "none";
        } else {
            content.style.display = "block";
        }
    } );
}

    // SEARCH BAR
    const searchInput = document.getElementById ( "search-input" );
    const addressTable = document.getElementById ( "address-table" );

    searchInput.addEventListener ( "keyup", function() {
        // Get the search term
        const searchTerm = this.value.toLowerCase();

        // Get all of the rows in the table
        const tableRows = addressTable.querySelectorAll ( "tr" );

        // Loop through each row and check if it contains the search term
        tableRows.forEach ( function ( row ) {
            if ( row.innerText.toLowerCase().includes ( searchTerm ) ) {
                row.style.display = "table-row";
            } else {
                row.style.display = "none";
            }
        });
    });
</script>