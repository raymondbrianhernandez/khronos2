<?php

// THIS FUNCTION CONVERTS STREET ADDRESS INTO GPS COORDINATES
function geocode ( $address ) {

    // Map API needs '+' in place of spaces
    $key = 'USE YOUR OWN';
    $address = str_replace (" ", "+", urlencode($address));
    $url = 'https://maps.googleapis.com/maps/api/geocode/json?address=' . $address . '&key=' . $key; 
    /* $url = 'https://geocode.maps.co/search?q=' . $address; */
    
    $unparsed_json = file_get_contents ( $url );
    $result = json_decode ( $unparsed_json, true );
    
    $gps = array (
        'latitude'      => $result['results'][0]['geometry']['location']['lat'],
        'longitude'     => $result['results'][0]['geometry']['location']['lng'],
        'full_address'  => $result['results'][0]['formatted_address'],
        'building_type' => $result['results'][0]['types'][0]
    ); 

    return $gps;
}

function redirect ( $url, $message ) {
    echo "<script type='text/javascript'>
            alert( '".$message."' );
            window.location.href='".$url."';
            </script>";
}

?>