<?php

if ( session_status() == PHP_SESSION_NONE ) {
    session_start();
}

require ( "../private/secure.php" );
require_once ( "../private/db_config.php" );

// Set the character set for the database connection to utf8mb4 (supports wider range of characters including emojis)
$charset = 'utf8mb4';

// Create the Data Source Name (DSN) string for the PDO connection
// It specifies the type of database (mysql), the host, the database name, and the character set
$dsn = "mysql:host=$host;dbname=$db_name;charset=$charset";

// Set PDO options for the database connection:
$options = [
    // Enable exceptions for errors. This means if there's an error, a PDOException will be thrown
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    
    // Set the default fetch mode to associative arrays. This means when you fetch data, it'll be in an associative array format
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    
    // Turn off emulated prepared statements. Using true prepared statements is more secure
    PDO::ATTR_EMULATE_PREPARES   => false,
];

$startTime = new DateTime ( $_SESSION['startTime'] );
$endTime = new DateTime ( $_SESSION['endTime'] );
$hoursLogged = ( $endTime->getTimestamp() - $startTime->getTimestamp() ) / ( 60 * 60 ); // Calculate hours
    
$owner = $_SESSION['owner'];
$date = date ( 'Y-m-d' ); 
$service_year = $_SESSION['service_year'];

try {
    $pdo = new PDO ( $dsn, $user, $password, $options );
    
    $data = json_decode ( file_get_contents ( "php://input" ) );

    $insert_sql = "INSERT INTO report (owner, service_year, date, hours) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare ( $insert_sql );
    $stmt->execute ( [$owner, $service_year, $date, $hoursLogged] );

    echo json_encode ( ['success' => true] );
} catch ( \PDOException $e ) {
    echo json_encode ( ['success' => false, 'error' => $e->getMessage()] );
}

?>
