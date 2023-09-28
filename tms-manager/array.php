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

include ( 'db.php' );
include ( '../public/debug.php' );

$congregation = $_SESSION['congregation'];

?>

<head>    
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title> Upload JW Workbook - Khronos Pro 2 </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" media="all" href="../public/stylesheets/charts.min.css" />
    <link rel="stylesheet" media="all" href="../public/stylesheets/phpvariables.php" />
    <!-- <link rel="stylesheet" media="all" href="../public/stylesheets/dashboard.css" /> -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>

<body>
    <header>
        <?php include ( "../private/shared/loader.php" ); ?>
        <?php echo "<script>showLoader();</script>"; ?>
        <?php include ( "../private/shared/navigation.php" ); ?>
        <div style="margin: 0 auto; text-align: center;">
            <?php include ( 'tms-navigation.php' ) ?>
        </div>

<?php

if ( isset ( $_POST['url'] ) ) {
    
    // Extract the year from the URL
    $yearPattern = '/\d{4}/'; // Matches a 4-digit year
    if (preg_match($yearPattern, $url, $matches)) {
        $_SESSION['workbook_year'] = $matches[0]; // The year will be in $matches[0]
    }
    $workbook_year = $_SESSION['workbook_year'];

    // Initialize cURL
    $curl = curl_init();

    // Set the URL to scrape
    curl_setopt ( $curl, CURLOPT_URL, $url );

    // Return the response, rather than outputting it
    curl_setopt ( $curl, CURLOPT_RETURNTRANSFER, true );

    // Execute the cURL request
    $response = curl_exec ( $curl );

    // Create a new DOMDocument
    $doc = new DOMDocument();
    
    // Load the HTML response
    @$doc->loadHTML ( $response );

    // Create a new DOMXPath
    $xpath = new DOMXPath ( $doc );

    // Search for the elements you're looking for
    $elements = $xpath->query( "//div[@class='syn-body   textOnly accordionHandle ']/h2/a[@href]" );

    $session_array = array();

    foreach ( $elements as $element ) {
        $link = $element->getAttribute( 'href' );
        $text = $element->nodeValue;

        // Set the URL to scrape
        curl_setopt ( $curl, CURLOPT_URL, "https://www.jw.org" . $link );

        // Return the response, rather than outputting it
        curl_setopt ( $curl, CURLOPT_RETURNTRANSFER, true );

        // Execute the cURL request
        $response = curl_exec ( $curl );

        // Close the cURL session
        curl_close ( $curl );

        // Create a new DOMDocument
        $doc = new DOMDocument();

        // Load the HTML response
        @$doc->loadHTML ( $response );

        // Create a new DOMXPath
        $xpath = new DOMXPath ( $doc );

        // Search for the parts and songs you're looking for
        $elements = $xpath->query ( "//p[starts-with(@id, 'p') and contains(., 'min.')]" );  

        if ( $elements->length > 0 ) {
            // All 3 songs
            $find_songs = $xpath->query("//a[contains(@class, 'pub-sjj') and (contains(., 'Awit') or contains(., 'Song'))]");

            // Bible Verse that week
            $strongTags = $xpath->query ( "//strong" );
            $verse =  $strongTags[0]->nodeValue;
                       
            // Create an array to store the song data
            $songs_array = array();
            foreach ( $find_songs as $song ) {
                $songs_array[] = $song->textContent;
            }
            $select_week = trim ( $text );
            $song_open   = $songs_array[0];
            $song_mid    = $songs_array[1];
            $song_close  = $songs_array[2];

            // Check if the record already exists in the database
            $query = "SELECT * FROM songs WHERE select_week = ? AND song_open = ? AND song_mid = ? AND song_close = ?";
            $stmt = $con->prepare ( $query );
            $stmt->bind_param("ssss", $select_week, $song_open, $song_mid, $song_close);
            $stmt->execute();
            $result = $stmt->get_result();

            if ( $result->num_rows > 0 ) {
                // Record already exists, skip the insert
                echo "Songs already exists, skipping insert!<br>";
            } else {
                // Record doesn't exist, proceed with the insert
                $query  = "INSERT INTO songs ( year, select_week, verse, song_open, song_mid, song_close ) ";
                $query .= "VALUES ( '$workbook_year', '$select_week', '$verse', '$song_open', '$song_mid', '$song_close' )";            
                $result = mysqli_query ( $con, $query );
 
                if ( ! $result ) {
                    echo "Songs and bible verse insert failed<br>";
                } else {
                    echo "Songs and bible verse added successfully<br>";
                }
            }

            // Add Opening Prayer to session array (Runs Once)
            $session_array[] = array (
                'link'      => trim ( "https://www.jw.org" . $link ),
                'week'      => trim ( $text ),
                'part'      => 'Opening Prayer',
                'assignee'  => '',
                'assistant' => ''
            );

            // Add each element to session array (Runs on a loop)
            foreach ( $elements as $element ) {
                $session_array[] = array (
                    'link'      => trim ( "https://www.jw.org" . $link ),
                    'week'      => trim ( $text ),
                    'part'      => trim ( $element->nodeValue ),
                    'assignee'  => '',
                    'assistant' => ''
                );
            }

            // Add Closing Prayer to session array (Runs Once)
            $session_array[] = array (
                'link'      => trim ( "https://www.jw.org" . $link ),
                'week'      => trim ( $text ),
                'part'      => 'Closing Prayer',
                'assignee'  => '',
                'assistant' => ''
            );
        }
    }
    
    // Now we are saving all parts 
    $_SESSION['data'] = $session_array;
    
    foreach ( $session_array as $session ) {
        $year = date('Y');
        $link = $session['link'];
        $week = $session['week'];
        $part = $session['part'];
        $assignee = $session['assignee'];
        $assistant = $session['assistant'];

        // Let's make sure no duplicates
        $check_query = "SELECT * FROM assignments WHERE congregation='$congregation' AND link='$link' AND week='$week' AND part='$part'";
        $result = mysqli_query ( $con, $check_query );
        
        // If entries doesn't exist, we add
        if ( mysqli_num_rows ( $result ) == 0 ) {
            $query = "INSERT INTO assignments ( congregation, year, link, week, part, assignee, assistant ) VALUES ('$congregation', '$year', '$link', '$week', '$part', '$assignee', '$assistant')";
            echo "New parts inserted!<br>";
            //echo $query;
            mysqli_query ( $con, $query );
        } else {
            echo "Parts already exists, skipping...<br>";
        }
    }
    echo "<script>hideLoader();</script>";    
}

?>

        <div>
            <?php include ( "../private/shared/footer.php" ); ?>
        </div>
        
    </header>   

</body>
</html>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>

