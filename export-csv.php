<?php

require("../private/secure.php");
require_once("../private/db_config.php");
include("./php/php_functions.php");
/* include("debug.php"); */
session_start();

$result = mysqli_query($con, "SELECT * FROM `householders` WHERE `Owner` = '" . $_SESSION['owner'] . "'");

if ( ! $result ) { die( 'Error: ' . mysqli_error( $con ) ); }

$fp = fopen( 'my_RVs.csv', 'w' ); // write mode

// Get the column names
$field_info_all = mysqli_fetch_fields( $result );
foreach( $field_info_all as $field_info ) {
  $headers[] = $field_info->name;
}

// Output the column names as the first row
fputcsv( $fp, $headers );

// Output the rest of the rows
while ( $row = mysqli_fetch_assoc( $result ) ) {
  // Change the value of the first column to an empty string,
  // because Alba uses their own Address_ID on master table
  $row[$headers[0]] = '';
  
  // Write it now as CSV
  fputcsv( $fp, $row );
}

// Close the file and the database connection
fclose( $fp );
mysqli_close( $con );

// This sets the content type of the file as "text/csv" browser knows 
// that it's a CSV file and can handle it accordingly.
header( 'Content-Type: text/csv' );

// This sets the filename that will be used when the file is downloaded. 
// It also sets the Content-Disposition as "attachment" so that the browser 
// prompts the user to download the file instead of displaying it in the browser.
header( 'Content-Disposition: attachment; filename="my_RVs.csv"' );

// This tells the browser not to cache the file, 
// so that it will always be the latest version.
header( 'Pragma: no-cache' );

// This sets the expiration date of the file to 0, so that the browser 
// will always check if a new version is available.
header( 'Expires: 0' );

// This reads the CSV file and sends its contents to the browser.
readfile( 'my_RVs.csv' );
?>