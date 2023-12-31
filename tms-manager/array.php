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

This JW Workbook Parser is for the new 2024 format onwards (R.Hernandez)
-->

<?php

if ( session_status() !== PHP_SESSION_ACTIVE ) {
    session_start();
}

require 'db.php';
// require 'debug.php';
require '_functions.php';

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
        <?php
            // This is you loader animation, paste showLoader() on top of page,
            // then hideLoader() at the bottom of slow pages 
            include '../private/shared/loader.php';
            echo "<script>showLoader();</script>"; 

            include '../private/shared/navigation.php';
        ?>
        <div style="margin: 0 auto; text-align: center;">
            <?php include 'tms-navigation.php' ?>
        </div>

<?php

if ( isset ( $_POST['url'] ) ) {
    $session_array = array();
    
    // Extract the year from the URL
    $url = filter_var ( $_POST['url'], FILTER_SANITIZE_URL );
    $year_pattern = '/\d{4}/'; // Matches a 4-digit year
    if ( preg_match ( $year_pattern, $url, $matches ) ) {
        $_SESSION['workbook_year'] = $matches[0]; 
    }
    $workbook_year = $_SESSION['workbook_year'];

    // Initialize cURL
    $curl = curl_init();
    $doc = new DOMDocument();
    $response = fetchContent ( $url, $curl );
    
    if ( !$response ) { 
        die ( "Failed to fetch the content from the URL" ); 
    } 

    @$doc->loadHTML ( $response );
    $xpath = new DOMXPath ( $doc );

    // Parses the week's url from the workbook
    $week_pages = $xpath->query( "//div[@class='syn-body sqs   ']/h2/a[@href]" );

    foreach ( $week_pages as $week_page ) {
        $link = $week_page->getAttribute( 'href' );
        $week = $week_page->nodeValue;
        // echo "PARSING: https://www.jw.org" . $link . $week . "<br>"; // FOR DEBUG
    
        // Set CURL
        curl_setopt ( $curl, CURLOPT_URL, "https://www.jw.org" . $link );
        curl_setopt ( $curl, CURLOPT_RETURNTRANSFER, true );
        $response = curl_exec ( $curl );
        curl_close ( $curl );
        $doc = new DOMDocument();
        @$doc->loadHTML ( $response );
        $xpath = new DOMXPath ( $doc );

        // Find all parts (except opening prayer, mid song, and closing)
        $parts_query    = "//h3[contains(@class, 'du-fontSize--base')]";
        $parts_elements = $xpath->query ( $parts_query );
        $parts          = [];

        // Check if any <h3> elements are found
        if ( $parts_elements->length > 0 ) {
            foreach ( $parts_elements as $part ) {
                $data_pid = $part->getAttribute ( 'data-pid' );

                // Calculate the data-pid for the corresponding <p> element
                $p_next_data_pid = ( int ) $data_pid + 1;

                // Find the <p> element with the calculated data-pid
                $p_query   = "//p[@data-pid='$p_next_data_pid']";
                $p_element = $xpath->query ( $p_query );

                // Check if the <p> element is found and concatenate its content with the <h3> text
                if ( $p_element->length > 0 ) {
                    $p_text = trim ( $p_element->item(0)->nodeValue );
                    $h3_text = trim ( $part->nodeValue );
                    $parts[] = $h3_text . " " . $p_text;
                }
            }
            // foreach ( $parts as $part ) { echo $part . "<br>"; } // FOR DEBUG
        }

        if ( $parts_elements->length > 0 ) {
            // All 3 songs
            $find_songs = $xpath->query (
                "//h3[a[contains(@class, 'pub-sjj') and (contains(., 'Awit') 
                or contains(., 'Song'))] or span/a[contains(@class, 'pub-sjj') 
                and (contains(., 'Awit') or contains(., 'Song'))]]"
            );
            // foreach ( $find_songs as $song ) { echo trim ( $song->nodeValue ) . "<br>"; } // FOR DEBUG
        
            // Bible Verse that week
            $find_bible_verse = $xpath->query ( "//strong" );
            $bible_verse      = $find_bible_verse[0]->nodeValue;
            // echo trim ( $bible_verse ) . "<br>"; // FOR DEBUG
        
            // Create an array to store the song data
            $songs_array = array();
            $counter = 0;

            foreach ( $find_songs as $song ) {
                $fullText = trim ( $song->textContent );
                $counter++;

                // For the first and third songs, use regex to extract "Awit Blg. XX" or "Song XX"
                if ( $counter == 1 || $counter == 3 ) {
                    if ( preg_match ( '/(Awit Blg\. \d+|Song \d+)/', $fullText, $matches ) ) {
                        $songs_array[] = $matches[0];
                        // echo $matches[0] . "<br>"; // FOR DEBUG
                    } 
                } 
                // For the second song, keep the full text as is
                else if ( $counter == 2 ) {
                    $songs_array[] = $fullText;
                    // echo $fullText . "<br>"; // FOR DEBUG
                }
            }

            $select_week = trim ( $week );
            $song_open   = $songs_array[0];
            $song_mid    = $songs_array[1];
            $song_close  = $songs_array[2];

            // echo $select_week . "<br>"; // FOR DEBUG
            // echo $song_open . "<br>";// FOR DEBUG
            // echo $song_mid . "<br>";// FOR DEBUG
            // echo $song_close . "<br>";// FOR DEBUG

            // Check if the record already exists in the database
            $query = "SELECT * FROM songs WHERE select_week = ?  AND congregation = ? AND song_open = ? AND song_mid = ? AND song_close = ?";
            $stmt = $tmscon->prepare ( $query );
            $stmt->bind_param ( "sssss", $select_week, $congregation, $song_open, $song_mid, $song_close );
            $stmt->execute();
            $result = $stmt->get_result();

            if ( $result->num_rows > 0 ) {
                echo "Songs already exists, skipping insert!<br>";
            } else {
                // Record doesn't exist, proceed with the insert
                $query  = "INSERT INTO songs ( year, select_week, congregation, verse, song_open, song_mid, song_close ) ";
                $query .= "VALUES ( '$workbook_year', '$select_week', '$congregation', '$bible_verse', '$song_open', '$song_mid', '$song_close' )";            
                $result = mysqli_query ( $tmscon, $query );
 
                if ( ! $result ) {
                    echo "Songs and bible verse insert failed<br>";
                } else {
                    echo "Songs and bible verse added successfully<br>";
                }
            }
        
            // Add Opening Prayer to session array (Runs Once)
            // $session_array[] = array (
            //     'link'      => trim ( "https://www.jw.org" . $link ),
            //     'week'      => $select_week,
            //     'part'      => 'Opening Prayer',
            //     'assignee'  => '',
            //     'assistant' => ''
            // );

            // Add each element to session array (Runs on a loop)
            foreach ( $parts as $part ) {
                $session_array[] = array (
                    'link'      => trim ( "https://www.jw.org" . $link ),
                    'week'      => $select_week,
                    'part'      => trim ( $part ),
                    'assignee'  => '',
                    'assistant' => ''
                );
            }

            // // Add Closing Prayer to session array (Runs Once)
            // $session_array[] = array (
            //     'link'      => trim ( "https://www.jw.org" . $link ),
            //     'week'      => $select_week,
            //     'part'      => 'Closing Prayer',
            //     'assignee'  => '',
            //     'assistant' => ''
            // );
        }
    }
    
    // Now we are saving all parts 
    $_SESSION['data'] = $session_array;
    
    foreach ( $session_array as $session ) {
        $year       = $workbook_year;
        $link       = $session['link'];
        $week       = $session['week'];
        $part       = $session['part'];
        $assignee   = $session['assignee'];
        $assistant  = $session['assistant'];

        // Let's make sure no duplicates
        $check_query = "SELECT * FROM assignments WHERE congregation='$congregation' AND link='$link' AND week='$week' AND part='$part'";
        $result = mysqli_query ( $tmscon, $check_query );
        
        // If entries doesn't exist, we add
        if ( mysqli_num_rows ( $result ) == 0 ) {
            $query = "INSERT INTO assignments ( congregation, year, link, week, part, assignee, assistant ) VALUES ('$congregation', '$year', '$link', '$week', '$part', '$assignee', '$assistant')";
            echo "New parts inserted!<br>";
            //echo $query;
            mysqli_query ( $tmscon, $query );
        } else {
            echo "Parts already exists, skipping...<br>";
        }
    }
    echo "<script>hideLoader();</script>";
    
    // Close cURL after all operations
    curl_close ( $curl );
    
    // Close database connection
    $tmscon->close();
} else {
    echo "No URL Posted";
}

?>

    <div>
        <?php include '../private/shared/footer.php'; ?>
    </div>
    
</header>   

</body>
</html>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
