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
    require("../private/secure.php");
    require_once("../private/db_config.php");
    include("./php/php_functions.php");
    /* include("debug.php"); */
    session_start();

    $query = 'SELECT @i:=@i+1 AS num, householders.* FROM householders, (SELECT @i:=0) i WHERE owner="'.$_SESSION['owner']. '" ORDER BY Address_ID DESC LIMIT ?,?';

    // Google Maps API
    // $googlemap = "https://www.google.com/maps/search/?api=1&query=";
    $googlemap = "https://www.google.com/maps/dir//";

    // Pagination
    $total_pages = $con->query('SELECT COUNT(status) FROM householders WHERE owner='.'"'.$_SESSION['owner'].'"')->fetch_row()[0];
    $page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
    $_SESSION['page'] = $page;
    $num_results_on_page = 15;
    $_SESSION['offset'] = $num_results_on_page;

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
    while( $row = mysqli_fetch_assoc( $gps_result ) ) {
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
    <title>Territories - Service Records</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous"> 
    <link rel="stylesheet" media="all" href="./stylesheets/webapp_styles.css"/>
    <link rel="stylesheet" media="all" href="./stylesheets/dashboard.css"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>
    
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
                    <div class="map-container">
                        <div id='map'>
                        <script>
                            function mapLibre() {
                                var map = new maplibregl.Map( {
                                    container: 'map',
                                    style:'https://api.maptiler.com/maps/bright-v2/style.json?key=yIFC37lpVhEBM5HG2OUY',
                                    center: ( [<?= $lat; ?>, <?= $lon; ?>] ),
                                    zoom: 11
                                } );
                                
                                // Convert the PHP markers array to a JSON object
                                var markers = <?php echo json_encode( $markers ); ?>;
                                
                                // Loop through the markers and add them to the map
                                for ( var i = 0; i < markers.length; i++ ) {
                                    newMapMarker( markers[i].longitude, markers[i].latitude, map );
                                }
                            }

                            function newMapMarker( lon, lat, map ) {
                                var marker = new maplibregl.Marker()
                                    .setLngLat( [lon, lat] )
                                    .addTo( map );
                            }

                            mapLibre();
                        </script>  
                        </div>
                    </div>
                    <!------------------------------ END MAP AREA ------------------------------->
                    
                    <br>
                    <div class="row d-flex justify-content-center" id=search>
                        <div class="search-bar">
                            <input type="text" id="search-input" style="width:100%" placeholder="Search for names...">
                            <button id="greenbutton" onclick="location.reload()"> Reset </button>
                        </div>
                        <hr>
                        <table id="address-table">
                            <tr id="column-header">
                                <th> STATUS    </th>
                                <th> NAME      </th>
                                <th> ADDRESS   </th>
                                <th> MAP       </th>
                                <th> TELEPHONE </th>
                                <th> NOTES     </th>
                                <th> ACTIONS   </th>
                            </tr>
                            
                        <?php 
                        while ( $row = $result->fetch_assoc() ):
                            $tempAddr = $row['Address'].', '.$row['Suite'].' '.$row['City'].' '.$row['Province'].' '.$row['Postal_code'];
                            echo "<script>newMapMarker(" . $row['Longitude'] . ", " . $row['Latitude'] . ", map);</script>";
                        ?>
                            <tr>
                                <!-- Index Numbers -->  
                                <!-- <td style="text-align:center; width:1px;"> 
                                    //<= $row['num'] + ($page-1) * $num_results_on_page; ?>
                                </td> -->
                                <td style="text-align:center; width:1px;">
                                    <b>
                                    <?php if ($row['Status'] == "New") { ?>
                                        <span style="color:blue"><?= $row['Status']; ?></span> 
                                    <?php } else if ($row['Status'] == "Valid") { ?>
                                        <span style="color:green"><?= $row['Status']; ?></span>
                                    <?php } else if ($row['Status'] == "Invalid") { ?>
                                        <span style="color:black"><?= $row['Status']; ?></span>
                                    <?php } else if ($row['Status'] == "Do not call") { ?>
                                        <span style="color:red"><?= $row['Status']; ?></span>        
                                    <?php } ?>
                                    </b>
                                </td>
                                <td style="width:80px;">
                                    <b><?= $row['Name']; ?></b>
                                </td>
                                <td style="width:100px;">
                                    <?= $tempAddr; ?>
                                </td>
                                <td style="text-align:center; width:5px;">
                                    <a href="<?= $googlemap.$tempAddr?>" target="_blank"> Directions </a>
                                </td>
                                <td style="text-align:center; width:5px;">
                                    <a href="tel:<?= $row['Telephone']; ?>"><?= $row['Telephone']; ?></a>
                                </td>
                                <td style="width:300px;">
                                    <?= $row['Notes']; ?>
                                </td>
                                <td style="text-align:center; width:100px;">
                                    <button id="greenbutton" data-toggle="toggle"> Edit </button>
                                    <!-- <button id="redbutton" onclick="showOnMap(<?= $tempAddr; ?>);"> Mark </button> -->
                                </td>   
                            </tr>  
                             
                            <tr class="hideTr">
                                <form action="edit.php" method="post">
                                    <td colspan="6">
                                        <label for="name"> Name: </label>
                                        <input type="text" name="name" value="<?= $row['Name']; ?>" ><br>            
                                        
                                        <label for="suite"> Suite: </label>
                                        <input type="text" name="suite" value="<?= $row['Suite']; ?>"><br>
                                        
                                        <label for="address"> Address: </label>
                                        <input type="text" name="address" value="<?= $row['Address']; ?>"><br>
                                        
                                        <label for="city"> City: </label>
                                        <input type="text" name="city" value="<?= $row['City']; ?>"><br>
                                        
                                        <label for="province"> State: </label>
                                        <input type="text" name="province" value="<?= $row['Province']; ?>"><br>
                                        
                                        <label for="postal_code"> Zipcode: </label>
                                        <input type="text" name="postal_code" value="<?= $row['Postal_code']; ?>"><br>
                                        
                                        <label for="telephone"> Telephone: </label>
                                        <input type="text" name="telephone" value="<?= $row['Telephone']; ?>"><br>
                                        
                                        <!-- Get the readonly values -->
                                        <input type="hidden" name="address_id" value="<?= $row['Address_ID']; ?>" >
                                        <input type="hidden" name="dropdown" value="<?= $row['Status']; ?>" >
                                    
                                        <label for="dropdown"> Status: </label>
                                        <select name = "dropdown">
                                            <option value = "Valid"> Valid </option>
                                            <option value = "New"> New </option>
                                            <option value = "Invalid"> Invalid </option>
                                            <option value = "Do not call"> Do not call </option>
                                        </select><br>
                                        <label for="notes"> Notes: </label>
                                        <textarea rows="7" cols="40" name="notes" value=<?= $row['Notes']; ?>><?= $row['Notes']; ?></textarea><br>
                                        <label for="gps"> Geotag: </label>
                                        <input type="text" name="gps" value="<?= $row['Latitude'] .' '.  $row['Longitude']; ?>"><br>
                                    </td>
                                    <td style="text-align:center;">
                                        <button id="greenbutton" type="submit"> Save </button>
                                        <!-- <button id="bluebutton" onclick=<//?php geocode($tempAddr) ?> > Geotag </button> --> 
                                        <button id="redbutton" type="submit" formaction="delete.php" onclick="return confirm('Are you sure you want to delete this entry?');">
                                            Delete
                                        </button>   
                                    </td>
                                </form>
                            </tr>
                            
                        <?php endwhile; ?>

                        </table>
    
                    </div>
                    <hr>
                    <!-- ADD NEW RECORD -->
                    <button type="button" class="collapsible">
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
    var coll = document.getElementsByClassName( "collapsible" );
    var i;

    for ( i = 0; i < coll.length; i++ ) {
        coll[i].addEventListener( "click", function() {
            this.classList.toggle( "active" );
            var content = this.nextElementSibling;
            if ( content.style.display === "block" ) {
                content.style.display = "none";
            } else {
                content.style.display = "block";
            }
        } );
    }
</script>

<script src="./src/javascript.js"></script>

<script>
const searchInput = document.getElementById("search-input");
const addressTable = document.getElementById("address-table");

searchInput.addEventListener("keyup", function() {
  // Get the search term
  const searchTerm = this.value.toLowerCase();

  // Get all of the rows in the table
  const tableRows = addressTable.querySelectorAll("tr");

  // Loop through each row and check if it contains the search term
  tableRows.forEach(function(row) {
    if (row.innerText.toLowerCase().includes(searchTerm)) {
      row.style.display = "table-row";
    } else {
      row.style.display = "none";
    }
  });
});
</script>