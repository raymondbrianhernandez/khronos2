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

require_once ( "../private/db_config.php" );
require ( "../private/secure.php" ); 
include ( "./php/php_functions.php" );
include ( "../public/debug.php" );

$congregation = $_SESSION['congregation'];
$result = $con->query("SELECT border_name, boundary FROM borders WHERE congregation = '$congregation'");
$polygons = [];
while ($row = $result->fetch_assoc() ) {
    $polygons[] = [
        'border_name' => $row['border_name'],
        'boundary' => json_decode($row['boundary']) // assuming boundary is stored as JSON string
    ];
}
$polygonsJson = json_encode($polygons);

// Markers for the map
if ($con) {
    // Prepare SQL statement.
    if ( $stmt = $con->prepare("SELECT `Address_ID`, `Latitude`, `Longitude` FROM `master_territory` WHERE `Owner` = ?" ) ) {
        
        // Bind parameters
        $stmt->bind_param ( "s", $congregation ); // "s" denotes a string.
        
        // Execute the statement.
        if ( $stmt->execute() ) {
            
            // Bind result variables.
            $stmt->bind_result ( $address_ID, $latitude, $longitude );
            
            // Create an array to store marker data
            $markers = [];
            
            // Fetch the values and add them to the markers array
            while ( $stmt->fetch() ) {
                $markers[] = [
                    'address_ID' => $address_ID,
                    'latitude' => $latitude,
                    'longitude' => $longitude
                ];
            }
            
            // Convert the markers array to JSON for use in JavaScript
            $markersJson = json_encode ( $markers );
            
        } else {
            echo "Error: Unable to execute the SQL statement.";
        }
        $stmt->close();
    } else {
        echo "Error: Unable to prepare the SQL statement.";
    }
} else {
    echo "Error: mysqli is not initialized properly.";
}

// Users GPS Location
$lon = $_SESSION['centerX'];
$lat = $_SESSION['centerY']; 

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
    <link rel="stylesheet" media="all" href="./stylesheets/masterlist.css?v=1"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Map Libre General-->
    <link rel='stylesheet' href='https://unpkg.com/maplibre-gl/dist/maplibre-gl.css'/>
    <script src='https://unpkg.com/maplibre-gl/dist/maplibre-gl.js'></script>
    <!-- Turf JS -->
    <script src="https://cdn.jsdelivr.net/npm/@turf/turf/turf.min.js"></script>
    <!-- Map Libre Geocoder -->
    <script src="https://unpkg.com/@maplibre/maplibre-gl-geocoder@1.2.0/dist/maplibre-gl-geocoder.min.js"></script>
</head>
    
<body>
    <header>
        <?php include ( "../private/shared/navigation.php" ); ?>
    </header>
    
    <div class="main-container">
        <div class="sub-navigation centered">
            <h4><b>Master Territory Manager</b></h4>
            <a href="">Border Manager</a> | <a href="">Names Database</a> | <a href="">Publisher Assignments</a>
            <p><button id="toggleStyleButton"><b>Toggle Map View </b> (Satellite or Regular)</button></p>  
        </div>
        <div class="master-territory">
            <div class="boundaries">
                <button id="drawPolygonButton"> Draw a New Border </button>
                <input type="text" id="border_name" placeholder="Enter Border Name" required/>
                <button id="savePolygonButton" onclick="savePolygon()"> Save </button>
                <script>
                    function savePolygon() {
                        const borderNameInput = document.getElementById('border_name');
                        const rawData = {
                            boundary: currentPolygon,
                            border_name: borderNameInput.value,
                            congregation: congregationData,
                        };
                        fetch('../public/save_polygon.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                            },
                            body: JSON.stringify(rawData),
                        })
                        .then(response => response.text())
                        .then(data => {
                            document.getElementById('query_results').innerHTML = data;
                        })
                        .catch((error) => {
                            console.error('Error:', error);
                        });
                    }
                </script>
                <div id="query_results"></div>

                <div class="centered saved-borders">
                    <hr>
                    <h5>Saved Borders</h5>
                </div>
                <div id="savedBoundary">
                    <?php

                    if ( $con ) { // Check if $mysqli is initialized properly.
                        // Prepare SQL statement.
                        if ( $stmt = $con->prepare ( "SELECT border_name, boundary FROM borders WHERE congregation = ? ORDER BY border_name" ) ) {
                            
                            // Bind parameters
                            $stmt->bind_param ( "s", $congregation ); // "s" denotes a string. 
                            
                            // Execute the statement.
                            if ( $stmt->execute() ) {
                                
                                // Bind result variables.
                                $stmt->bind_result ( $borderName, $boundary );
                                
                                // Fetch the values.
                                while ( $stmt->fetch() ) {
                                    $borderName = htmlspecialchars ( $borderName ); // Escape the output to prevent XSS
                                    $boundary = htmlspecialchars ( $boundary );
                                    echo "<div class='border-item'>";
                                    echo "&nbsp;&nbsp;<a href='#' class='border-link' data-name='{$borderName}' data-boundary='{$boundary}'><b>{$borderName}</b></a>";
                                    echo "<button class='edit-button' data-name='{$borderName}'>Edit</button>";
                                    echo "<button class='delete-button' data-name='{$borderName}'>Delete</button>";
                                    echo "</div>";
                                }
                            } else {
                                echo "Error: Unable to execute the SQL statement.";
                            }
                            $stmt->close();
                        } else {
                            echo "Error: Unable to prepare the SQL statement.";
                        }
                    } else {
                        echo "Error: mysqli is not initialized properly.";
                    }
                    ?>
                </div>
            </div>
            
            <div class="map-area">
                <div id="map"></div>
            </div>
        </div>
    </div>

    <footer>
        <div>
            <?php include ( "../private/shared/footer.php" ); ?>
        </div>
    </footer>
</body>

<!-- SCRIPTS FOR THE MAP ONLY (Put other JS on a seperate script tag) -->
<script> 
document.addEventListener ( "DOMContentLoaded", function() {
    const polygons = <?php echo $polygonsJson; ?>;

    // Get the height of the parent .map-area
    var mapAreaHeight = document.querySelector( '.map-area' ).offsetHeight;

    // Set the height of #map to match .map-area
    document.getElementById('map').style.height = mapAreaHeight + 'px';

    // Define the map styles
    const mapStyle = <?php echo json_encode($_SESSION['map_style']); ?>;

    // Initialize the map
    const map = new maplibregl.Map({
        container: 'map', // container id
        center: [ <?php echo json_encode($lon); ?>, <?php echo json_encode($lat); ?> ],
        zoom: 11,
        antialias: true,
        pitch: 0, // tilts map in degrees
        bearing: 0, // rotates map in degrees
        style: mapStyle,
    });

    // Load existing boundaries
    map.on('load', function() {
        polygons.forEach(polygon => {
            const boundary = polygon.boundary.geometry;
            const borderName = polygon.border_name;

            // Calculate the area of the polygon
            const area = turf.area(boundary);

            // Map the area to a font size
            const minFontSize = 10; // Minimum font size
            const maxFontSize = 22; // Maximum font size
            const scaleFactor = 1; // Adjust this value to scale the font size appropriately
            let fontSize = Math.sqrt(area) * scaleFactor; // Square root scaling can sometimes give better results
            fontSize = Math.min(Math.max(fontSize, minFontSize), maxFontSize); // Clamp the font size between min and max value

            // Calculate the centroid of the polygon
            const centroid = turf.centroid(boundary);
            
            // Add source
            map.addSource(borderName, {
                "type": "geojson",
                "data": boundary
            });
            
            // Add layer
            map.addLayer({
                "id": borderName,
                "type": "fill",
                "source": borderName,
                "layout": {},
                "paint": {
                    "fill-color": "#ADD8E6",
                    "fill-opacity": 0.4
                }
            });

            // Add line layer for the polygon border
            map.addLayer({
                "id": borderName + '-border',
                "type": "line",
                "source": borderName,
                "layout": {},
                "paint": {
                    "line-color": "#000", // Set the border color to black
                    "line-width": 2 // Set the border width
                }
            });

            // Add source for the centroid
            map.addSource(borderName + '-centroid', {
                "type": "geojson",
                "data": centroid
            });
            
            // Add layer for the centroid
            map.addLayer({
                "id": borderName + '-label',
                "type": "symbol",
                "source": borderName + '-centroid',
                "layout": {
                "text-field": borderName,
                "text-anchor": "center",
                "text-offset": [0, 0],
                "text-size": fontSize,
                "text-font": ["Open Sans Bold", "Arial Unicode MS Bold"] // Use a bold font
            },
                "paint": {
                    "text-color": "#000" 
                }
            });
        });

        // Now, add markers based on dynamic coordinates
        const coordinates = <?php echo json_encode($markers); ?>;
        coordinates.forEach(coordinate => {
            // Create a DOM element for the marker
            const el = document.createElement('div');
            el.className = 'marker';
            el.style.width = '20px'; // Set marker width
            el.style.height = '20px'; // Set marker height
            //el.style.backgroundColor = 'red'; // Set background color

            // Add marker to map
            new maplibregl.Marker({ element: el })
                .setLngLat([coordinate.longitude, coordinate.latitude]) // Use your dynamic coordinates
                .addTo(map);
        });
    });

    // Initialize variables for drawing
    let points = [];
    let drawActive = false;
    let currentPolygon = null;
    let isDragging = false;
    let currentFeature = null;
    
    // Border Name Links
    const borderLinks = document.querySelectorAll ( '.border-link' );
    borderLinks.forEach ( link => {
        link.addEventListener ( 'click', function(e) {
            e.preventDefault();
            
            const borderName = e.target.getAttribute ( 'data-name' );
            const boundary = e.target.getAttribute ( 'data-boundary' );
            
            loadPolygon ( borderName, boundary );

            // Parse the boundary string back to JSON
            const parsedBoundary = JSON.parse ( boundary );
            
            // Use turf.js to get the bounding box of the polygon
            const bbox = turf.bbox ( parsedBoundary );

            // Focus the map on the polygon's bounding box
            map.fitBounds([[bbox[0], bbox[1]], [bbox[2], bbox[3]]], { padding: 20 });
        });
    });
    
    function loadPolygon ( borderName, boundary ) {
        // Parse boundary, which is assumed to be a JSON string.
        const parsedBoundary = JSON.parse ( boundary );
        
        // Check if the source with the same borderName already exists, if so remove it.
        if (map.getSource(borderName)) {
            map.removeLayer(borderName);
            map.removeSource(borderName);
        }
        
        // Add the source and layer to the map with the parsed boundary as data.
        map.addSource(borderName, {
            "type": "geojson",
            "data": {
                "type": "Feature",
                "geometry": parsedBoundary
            }
        });
        
        map.addLayer({
            "id": borderName,
            "type": "fill",
            "source": borderName,
            "layout": {},
            "paint": {
                "fill-color": "#088", // You can change the color as you like
                "fill-opacity": 0.8
            }
        });
        
        // Optionally, if you want to fly to the added polygon's bounding box, you can do something like this:
        const bbox = turf.bbox(parsedBoundary); // using turf.js to get the bounding box of the polygon
        map.fitBounds([[bbox[0], bbox[1]], [bbox[2], bbox[3]]], { padding: 20 });
    }

    // Handle button click for drawing polygon
    document.getElementById('drawPolygonButton').addEventListener('click', function() {
        drawActive = !drawActive;
        map.getCanvas().style.cursor = drawActive ? 'crosshair' : 'default';  // Change cursor style

        if (!drawActive) {
            // Update #savedBoundary div with the JSON representation of the current polygon
            document.getElementById('savedBoundary').innerHTML = JSON.stringify(currentPolygon, null, 2);
            points = [];
        } else {
            // Initialize the empty polygon
            currentPolygon = {
                type: "Feature",
                geometry: {
                    type: "Polygon",
                    coordinates: [[]]
                }
            };
        }
    });

    map.on('mousemove', function(e) {
        if (isDragging && currentFeature) {
            // Update the position of the dragged point in the polygon
            const idx = currentFeature.properties.id;
            currentPolygon.geometry.coordinates[0][idx] = [e.lngLat.lng, e.lngLat.lat];
            
            // Update Polygon
            updatePolygon();
        }
    });

    map.on('mousedown', function(e) {
        const features = map.queryRenderedFeatures(e.point, {
            layers: ['polygon-point']
        });
        if(!drawActive && features.length) {
            isDragging = true;
            currentFeature = features[0];
            map.getCanvas().style.cursor = 'grabbing';
        }
    });

    map.on('mouseup', function(e) {
        if (isDragging) {
            // Stop the dragging action
            isDragging = false;

            // Reset the cursor
            const features = map.queryRenderedFeatures(e.point, {
                layers: ['polygon-point']
            });
            map.getCanvas().style.cursor = features.length ? 'move' : (drawActive ? 'crosshair' : 'default');

            // Clear reference to the currently dragged feature
            currentFeature = null;
        }
    });

    map.on('mousemove', function(e) {
        if (isDragging && currentFeature) {
            // Update the position of the dragged point in the polygon
            currentPolygon.geometry.coordinates[0][currentFeature.properties.id] = [e.lngLat.lng, e.lngLat.lat];
            updatePolygon();
        } else {
            const features = map.queryRenderedFeatures(e.point, {
                layers: ['polygon-point']  // Check if hovering over a point in our polygon-point layer.
            });
            if (!drawActive) {
                map.getCanvas().style.cursor = features.length ? 'move' : 'default';
            } else {
                map.getCanvas().style.cursor = features.length ? 'move' : 'crosshair';
            }
        }
    });

    map.on('click', function(e) {
        if (drawActive && currentPolygon) {
            // Push the clicked point to the currentPolygon's coordinates
            currentPolygon.geometry.coordinates[0].push([e.lngLat.lng, e.lngLat.lat]);

            // Update Polygon (assuming this function is defined elsewhere)
            updatePolygon();
        }
    });

    function updatePolygon() {
        // Update the main polygon data. Create layer if it doesn't exist.
        if (!map.getSource('polygon')) {
            map.addSource('polygon', {
                "type": "geojson",
                "data": currentPolygon
            });
            map.addLayer({
                "id": "polygon",
                "type": "fill",
                "source": "polygon",
                "layout": {},
                "paint": {
                    "fill-color": "#088",
                    "fill-opacity": 0.8
                }
            });
        } else {
            map.getSource('polygon').setData(currentPolygon);
        }

        // Update the polygon line data. Create layer if it doesn't exist.
        if (!map.getSource('polygon-line')) {
            map.addSource('polygon-line', {
                "type": "geojson",
                "data": {
                    "type": "Feature",
                    "geometry": {
                        "type": "LineString",
                        "coordinates": currentPolygon.geometry.coordinates[0]
                    }
                }
            });
            map.addLayer({
                "id": "polygon-line",
                "type": "line",
                "source": "polygon-line",
                "layout": {},
                "paint": {
                    "line-color": "#FF0000",
                    "line-width": 3
                }
            });
        } else {
            map.getSource('polygon-line').setData({
                "type": "Feature",
                "geometry": {
                    "type": "LineString",
                    "coordinates": currentPolygon.geometry.coordinates[0]
                }
            });
        }

        // Update the polygon point data. Create layer if it doesn't exist.
        let features = currentPolygon.geometry.coordinates[0].map((coord, idx) => ({
            "type": "Feature",
            "geometry": {
                "type": "Point",
                "coordinates": coord
            },
            "properties": {
                "id": idx
            }
        }));

        if (!map.getSource('polygon-point')) {
            map.addSource('polygon-point', {
                "type": "geojson",
                "data": {
                    "type": "FeatureCollection",
                    "features": features
                }
            });
            map.addLayer({
                "id": "polygon-point",
                "type": "circle",
                "source": "polygon-point",
                "paint": {
                    "circle-radius": 6,    // Bigger circle
                    "circle-color": "#FF0000"   // Red color
                }
            });
        } else {
            map.getSource('polygon-point').setData({
                "type": "FeatureCollection",
                "features": features
            });
        }
    }

    document.getElementById('savePolygonButton').addEventListener('click', function () {
        drawActive = false; // Exit the draw option and go back to regular mode
        updatePolygon(); // Refresh the map
        const borderNameInput = document.getElementById('border_name');
        const borderName = borderNameInput.value;

        if ( !borderName ) {
            alert ( 'Please enter a border name!' );
            return;
        }
        
        const congregationData = <?php echo json_encode ( $_SESSION['congregation'] ) ?>;
        const markersData = <?php echo $markersJson; ?>; // Include markers data

        // Before sending the fetch request, log the data being sent
        console.log({
            boundary: currentPolygon, 
            border_name: borderName,
            congregation: congregationData,
            markers: markersData
        });
        
        // Save the currentPolygon, not the loaded polygonData.
        fetch('../public/save_polygon.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                boundary: currentPolygon, // Save the currently drawn polygon.
                border_name: borderName,
                congregation: congregationData,
                markers: markersData
            }),
        })
        .then(response => response.text())
        .then(data => {
            // Reload the page to reflect the changes
            window.location.reload();
        })
        .catch((error) => {
            console.error('Error:', error);
        });

        // Existing Polygons showing on map
        polygons.forEach(polygon => {
            const boundary = polygon.boundary;
            const borderName = polygon.border_name;
            
            // Create GeoJSON source and add it to the map
            map.addSource(borderName, {
                "type": "geojson",
                "data": {
                    "type": "Feature",
                    "geometry": boundary
                }
            });
            
            // Add layer to visualize the polygon
            map.addLayer({
                "id": borderName,
                "type": "fill",
                "source": borderName,
                "layout": {},
                "paint": {
                    "fill-color": "#088",
                    "fill-opacity": 0.8
                }
            });
        });
    });

    // Add a button click event listener to toggle the map style
    document.getElementById('toggleStyleButton').addEventListener('click', function() {
        fetch('toggle_map_style.php')
        .then(response => response.text())
        .then(data => {
            console.log('Map style toggled:', data);
            location.reload();
        })
        .catch(error => console.error('Error toggling map style:', error));
    });

    // Search Bar
    const geocoderApi = {
        forwardGeocode: async (config) => {
            const features = [];
            try {
                const request =
            `https://nominatim.openstreetmap.org/search?q=${
                config.query
            }&format=geojson&polygon_geojson=1&addressdetails=1`;
                const response = await fetch(request);
                const geojson = await response.json();
                for (const feature of geojson.features) {
                    const center = [
                        feature.bbox[0] +
                    (feature.bbox[2] - feature.bbox[0]) / 2,
                        feature.bbox[1] +
                    (feature.bbox[3] - feature.bbox[1]) / 2
                    ];
                    const point = {
                        type: 'Feature',
                        geometry: {
                            type: 'Point',
                            coordinates: center
                        },
                        place_name: feature.properties.display_name,
                        properties: feature.properties,
                        text: feature.properties.display_name,
                        place_type: ['place'],
                        center
                    };
                    features.push(point);
                }
            } catch (e) {
                console.error(`Failed to forwardGeocode with error: ${e}`);
            }

            return {
                features
            };
        }
    };
    map.addControl(
        new MaplibreGeocoder(geocoderApi, {
            maplibregl
        })
    );

    // Fullscreen Control
    map.addControl(new maplibregl.FullscreenControl());
    
    // Add geolocate control to the map.
    map.addControl(
        new maplibregl.GeolocateControl({
            positionOptions: {
                enableHighAccuracy: true
            },
            trackUserLocation: true
        })
    );

    // Add zoom and rotation controls to the map.
    map.addControl(new maplibregl.NavigationControl());
});
</script>

<script>
// Function to handle edit button click
function handleEditButtonClick(borderName) {
    // Implement the logic to allow editing the polygon with the specified borderName
    // You can open a modal or some other interface for editing here
    // Example: Load the polygon's data and enable editing
    const borderLink = document.querySelector(`.border-link[data-name='${borderName}']`);
    const boundaryData = JSON.parse(borderLink.getAttribute('data-boundary'));

    // TODO: Implement the logic to allow editing the polygon
}

// Function to handle delete button click
function handleDeleteButtonClick(borderName) {
    if (confirm(`Are you sure you want to delete the border "${borderName}"?`)) {
        // Implement the logic to delete the border with the specified borderName
        // Example: Send an AJAX request to delete the border
        const congregationData = <?php echo json_encode($_SESSION['congregation']) ?>;
        fetch('../public/delete_border.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                border_name: borderName,
                congregation: congregationData,
            }),
        })
        .then(response => response.text())
        .then(data => {
            if (data === 'success') {
                // Border deleted successfully, you can update the UI as needed
                alert(`Border "${borderName}" deleted successfully.`);
                // TODO: Remove the border from the UI or reload the page
            } else {
                alert(`Failed to delete border "${borderName}".`);
            }
        })
        .catch((error) => {
            console.error('Error:', error);
            alert(`An error occurred while deleting border "${borderName}".`);
        });
    }
}

// Add event listeners for edit and delete buttons
const editButtons = document.querySelectorAll('.edit-button');
editButtons.forEach(button => {
    const borderName = button.getAttribute('data-name');
    button.addEventListener('click', () => handleEditButtonClick(borderName));
});

const deleteButtons = document.querySelectorAll('.delete-button');
deleteButtons.forEach(button => {
    const borderName = button.getAttribute('data-name');
    button.addEventListener('click', () => handleDeleteButtonClick(borderName));
});
</script>


</html>