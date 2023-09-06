<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JW TMS Manager</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link rel="stylesheet" href="raymondstyles.css">
</head>
<body>

<?php
session_start();

if(isset($_POST['view_arrays']) && $_POST['view_arrays'] == 1) {
    $_SESSION['url'] = $_POST['url'];
    header('Location: array.php');
    exit;
}

$url = $_POST['url'];

$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
curl_close($curl);

$doc = new DOMDocument();
@$doc->loadHTML($response);

$xpath = new DOMXPath($doc);
$elements = $xpath->query("//div[@class='syn-body   textOnly accordionHandle ']/h2/a[@href]");

foreach ($elements as $element) {
    $link = $element->getAttribute('href');
    $text = $element->nodeValue;

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, "https://www.jw.org".$link);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);
    curl_close($curl);

    $doc = new DOMDocument();
    @$doc->loadHTML($response);

    $xpath = new DOMXPath($doc);
    $elements = $xpath->query("//p[starts-with(@id, 'p') and contains(., 'min.')]");

    echo "<form method='post' action='report.php'>";
    echo "<br><center><b>Para sa linggo ng ".$text."</b></center>";
    echo "<table>";
    echo "<tr>";
    echo "<th>Assignee</th>";
    echo "<th style='text-align:left;'>Assignment</th>";
    echo "</tr>";

    if($elements->length > 0) {
        foreach ($elements as $element) {
            echo "<tr>";
            echo "<td>";
            include ( 'publishers.php' );
            echo "</td>";
            echo "<td>" . $element->nodeValue; 
            echo "<input type='hidden' name='assignment' value='" . $element->nodeValue . "'>";
            echo "</td>";
            echo "</tr>";
        }
        echo "</table><hr>";
    } else {
        echo "Error: Elements not parsed correctly.";
    }
    echo "<input type='submit' value='Generate Report'>";
    echo "</form>";
}
?>

<div>
    <button></button>
</div>

</body>
</html>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
