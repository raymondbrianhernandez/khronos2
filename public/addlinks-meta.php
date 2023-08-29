<?php

require("../private/secure.php");
require_once("../private/db_config.php");
include("debug.php");
session_start();
date_default_timezone_set("America/Los_Angeles");
 
/************ CURL Doesn't work on local server so don't trip ************/
// Web page URL 
$url = $url = $_POST['links']; 

// Extract HTML using curl 
$ch = curl_init(); 
curl_setopt($ch, CURLOPT_HEADER, 0); 
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
curl_setopt($ch, CURLOPT_URL, $url); 
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); 

$data = curl_exec($ch); 
curl_close($ch); 

// Load HTML to DOM object 
$dom = new DOMDocument(); 
@$dom->loadHTML($data); 

// Parse DOM to get Title data 
$nodes = $dom->getElementsByTagName('title'); 
$title = $nodes->length > 0 ? $nodes->item(0)->nodeValue : "No title for website found"; 

// Parse DOM to get meta data 
$metas = $dom->getElementsByTagName('meta'); 

$description = ''; 
for($i=0; $i<$metas->length; $i++){ 
    $meta = $metas->item($i); 
     
    if($meta->getAttribute('name') == 'description'){ 
        $description = $meta->getAttribute('content'); 
        break;
    } 
   
}
$description = empty($description) ? "No description for website found" : $description;

function format_to_href($url, $title, $description) {
    return '<a href="' . $url . '" target="_blank">' . $title . '</a><br> ' . $description; 
}

$owner      = $_SESSION['owner'];
$date       = date("m/d/Y") ." at ". date("h:ia");
$notes      = htmlentities( format_to_href( $url, $title, addslashes( $description ) ) );

$add_query  = "INSERT INTO notebook ";
$add_query .= "(Owner, Date, Notes) ";
$add_query .= "VALUES (";
$add_query .= "'" . $owner . "',"; 
$add_query .= "'" . $date . "',";
$add_query .= "'" .  html_entity_decode( $notes ) . "'";
$add_query .= ")";
 
/* echo "Title: $title". '<br/>';
echo "Description: $description". '<br/>'; */
/* echo $notes; */ 
$result = mysqli_query($con, $add_query);

if( $result ) {
    header("Location: journal.php");
} else {
    echo mysqli_error($con);
    /* echo $add_query;*/
}
 
?>