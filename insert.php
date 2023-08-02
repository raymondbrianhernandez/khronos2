<?php

require("../private/secure.php");
require_once("../private/db_config.php");
include("debug.php");
session_start();

function geocode($address) {
    // Map API needs '+' in place of spaces
    $key = 'AIzaSyC8li2lywcN-LK9aCsVFpuCoGX1F7IO_-8';
    $address = str_replace (" ", "+", urlencode($address));
    $url = 'https://maps.googleapis.com/maps/api/geocode/json?address=' . $address . '&key=' . $key; 
    
    $unparsed_json = file_get_contents($url);
    $result = json_decode($unparsed_json, true);
    
    $gps = array(
        'latitude'      => $result['results'][0]['geometry']['location']['lat'],
        'longitude'     => $result['results'][0]['geometry']['location']['lng'],
        'full_address'  => $result['results'][0]['formatted_address'],
        'building_type' => $result['results'][0]['types'][0]
    ); 

    return $gps;
}

$address = $_POST['address']." ".$_POST['city']." ".$_POST['province']." ".$_POST['postal_code']." ".$_POST['country'];
$coordinates = geocode( $address );

$owner      = $_SESSION['owner'];
$language   = 'Tagalog';
$status     = $_POST['status'];
$name       = $_POST['name'];
$suite      = $_POST['suite'];
$address    = $_POST['address'];
$city       = $_POST['city'];
$province   = $_POST['province'];
$postal_code= $_POST['postal_code'];
$country    = 'USA';
$latitude  = $coordinates['latitude'];
$longitude = $coordinates['longitude'];
$telephone  = $_POST['telephone'];
$notes      = $_POST['notes'];
$notes_private = "";

$add_query  = "INSERT INTO householders ";
$add_query .= "(Owner, Language, Status, Name, Suite, "; 
$add_query .= "Address, City, Province, Postal_code, Country, "; 
$add_query .= "Latitude, Longitude, Telephone, Notes, Notes_private) ";
$add_query .= "VALUES (";
$add_query .= "'" . $owner . "',"; 
$add_query .= "'" . $language . "',";
$add_query .= "'" . $status . "',";
$add_query .= "'" . $name . "',";
$add_query .= "'" . $suite . "',";
$add_query .= "'" . $address . "',";
$add_query .= "'" . $city . "',";
$add_query .= "'" . $province . "',";
$add_query .= "'" . $postal_code . "',";
$add_query .= "'" . $country . "',";
$add_query .= "'" . $latitude . "',";
$add_query .= "'" . $longitude . "',";
$add_query .= "'" . $telephone . "',";
$add_query .= "'" . $notes . "',";
$add_query .= "'" . $notes_private . "'";
$add_query .= ")";

$result = mysqli_query($con, $add_query);

if ( $result ) {
    header("Location: territories.php");
} else {
    echo mysqli_error($con);
    /* echo $add_query; */
}

?>