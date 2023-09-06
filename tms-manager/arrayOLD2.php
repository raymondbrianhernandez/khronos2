<?php

include ( 'db.php' );
include ( 'debug.php' );
session_start();

if ( isset ( $_POST['url'] ) ) {
    $url = $_POST['url'];

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
        curl_setopt ( $curl, CURLOPT_URL, "https://www.jw.org".$link );

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
            $find_songs = $xpath->query ( "//a[contains(@class, 'pub-sjj') and contains(., 'Awit')]" );

            // Bible Verse that week
           /*  $xpath = new DOMXPath ( $doc );
            $find_verse = $xpath->query("//a[@class='jsBibleLink jsHasModalListener jsNoScroll']");
            if ($find_verse->length > 0) {
                foreach ($find_verse as $element) {
                    $verse = trim($element->nodeValue);
                    echo $verse . " test" . PHP_EOL;
                }
            } else {
                echo $verse." No elements with the specified class were found in the HTML document.<br>" . PHP_EOL;
            } */
            
            // Create an array to store the song data
            $songs_array = array();
            foreach ( $find_songs as $song ) {
                $songs_array[] = $song->textContent;
            }
            /* $select_week = trim ( $text ); */
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
                echo "Songs already exists, skipping insert!";
            } else {
                // Record doesn't exist, proceed with the insert
                $query = "INSERT INTO songs ( select_week,song_open,song_mid,song_close ) VALUES (?,?,?,?)";
                $stmt = $con->prepare ( $query );
                $stmt->bind_param ( "ssss", $select_week, $song_open, $song_mid, $song_close );
                $stmt->execute();

                // Check if the insert was successful
                if ( mysqli_affected_rows ( $con ) > 0) {
                    echo "Song inserted successfully!<br>";
                } else {
                    echo "Song insert failed!<br>";
                }
            }

            /* Output The Songs Array per Week */
            /* echo "<pre>";
            print_r ( $songs_array );
            echo "</pre>"; */

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
                'link'      => trim( "https://www.jw.org" . $link ),
                'week'      => trim( $text ),
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
        $check_query = "SELECT * FROM assignments WHERE link='$link' AND week='$week' AND part='$part'";
        $result = mysqli_query($con, $check_query);
        
        // If entries doesn't exist, we add
        if ( mysqli_num_rows ( $result ) == 0 ) {
            $query = "INSERT INTO assignments ( year, link, week, part, assignee, assistant ) VALUES ('$year', '$link', '$week', '$part', '$assignee', '$assistant')";
            echo "New parts inserted!<br>";
            mysqli_query ( $con, $query );
        } else {
            echo "Parts already exists, skipping...<br>";
        }
    }
    
    /* Output all parts */
    /* echo "<pre>";
    print_r ( $_SESSION['data'] );
    echo "</pre>"; */
}

?>