<div class="map-container">
    <div id='map'>
    <script>
        function mapLibre() {
            var map = new maplibregl.Map( {
                container: 'map',
                style:'https://api.maptiler.com/maps/bright-v2/style.json?key=yIFC37lpVhEBM5HG2OUY',
                center: ( [<?= $lat; ?>, <?= $lon; ?>] ),
                zoom: 15
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