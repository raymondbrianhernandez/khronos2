<?php

include ('db.php');
include ('debug.php');

error_reporting(E_ALL);
session_start();

if(isset($_POST['url'])) {
    $url = $_POST['url'];

    // Initialize cURL
    $curl = curl_init();

    // Set the URL to scrape
    curl_setopt($curl, CURLOPT_URL, $url);

    // Return the response, rather than outputting it
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    // Execute the cURL request
    $response = curl_exec($curl);

    // Close the cURL session
    curl_close($curl);

    // Create a new DOMDocument
    $doc = new DOMDocument();
    // Load the HTML response
    @$doc->loadHTML($response);

    // Create a new DOMXPath
    $xpath = new DOMXPath($doc);

    // Search for the elements you're looking for
    $elements = $xpath->query("//div[@class='syn-body   textOnly accordionHandle ']/h2/a[@href]");

    $session_array = array();
    foreach ($elements as $element) {
        $link = $element->getAttribute('href');
        $text = $element->nodeValue;

        // Initialize cURL
        $curl = curl_init();

        // Set the URL to scrape
        curl_setopt($curl, CURLOPT_URL, "https://www.jw.org".$link);

        // Return the response, rather than outputting it
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        // Execute the cURL request
        $response = curl_exec($curl);

        // Close the cURL session
        curl_close($curl);

        // Create a new DOMDocument
        $doc = new DOMDocument();

        // Load the HTML response
        @$doc->loadHTML($response);

        // Create a new DOMXPath
        $xpath = new DOMXPath($doc);

        // Search for the text you're looking for
        $elements = $xpath->query("//p[starts-with(@id, 'p') and contains(., 'min.')]");

        if($elements->length > 0) {
            // Add Opening Prayer to session array
            $session_array[] = array(
                'link' => trim("https://www.jw.org".$link),
                'week' => trim($text),
                'part' => 'Opening Prayer',
                'assignee' => '',
                'assistant' => ''
            );
            // Add each element to session array
            foreach ($elements as $element) {
                $session_array[] = array(
                    'link'      => trim("https://www.jw.org".$link),
                    'week'      => trim($text),
                    'part'      => trim($element->nodeValue),
                    'assignee'  => '',
                    'assistant'  => ''
                );
            }
            // Add Closing Prayer to session array
            $session_array[] = array(
                'link'      => trim("https://www.jw.org".$link),
                'week'      => trim($text),
                'part'      => 'Closing Prayer',
                'assignee'  => '',
                'assistant'  => ''
            );
        }
    }
    $_SESSION['data'] = $session_array;
    
    foreach($session_array as $session) {
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
        if(mysqli_num_rows($result) == 0) {
            $query = "INSERT INTO assignments (year, link, week, part, assignee, assistant) VALUES ('$year', '$link', '$week', '$part', '$assignee', '$assistant')";
            mysqli_query($con, $query);
            /* echo $query."<br>";  */
        }
    }
    
    echo "<pre>";
    print_r($_SESSION['data']);
    echo "</pre>";
}

?>