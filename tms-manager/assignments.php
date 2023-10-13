<div style="text-align: left; padding: 20px; margin: auto;">

    <?php

    if ( session_status() !== PHP_SESSION_ACTIVE ) {
        session_start();
    }

    include '../tms-manager/db.php';
    include '../public/debug.php';
    require '../private/secure.php';

    $assignee = $_SESSION['owner'];
    $assignee = mysqli_real_escape_string ( $tmscon, $assignee );
    
    $result_asssignee = mysqli_query ( $tmscon, "SELECT * FROM `assignments` WHERE assignee = '$assignee'" );
    $result_assistant = mysqli_query ( $tmscon, "SELECT * FROM `assignments` WHERE assistant = '$assignee'" );

    function monthToNumber ( $month ) {
        $englishMonths = [
            'January' => '01',
            'February' => '02',
            'March' => '03',
            'April' => '04',
            'May' => '05',
            'June' => '06',
            'July' => '07',
            'August' => '08',
            'September' => '09',
            'October' => '10',
            'November' => '11',
            'December' => '12'
        ];
    
        $tagalogMonths = [
            'Enero' => '01',
            'Pebrero' => '02',
            'Marso' => '03',
            'Abril' => '04',
            'Mayo' => '05',
            'Hunyo' => '06',
            'Hulyo' => '07',
            'Agosto' => '08',
            'Setyembre' => '09',
            'Oktubre' => '10',
            'Nobyembre' => '11',
            'Disyembre' => '12'
        ];

        $months = ( $_SESSION['language'] == "Tagalog" ) ? $tagalogMonths : $englishMonths;

        return $months[$month] ?? false;
    }

    function getEndWeekDate ( $weekRange ) {
        if ( preg_match ( "/(\w+) (\d+)/", $weekRange, $matches ) ) {
            $month = monthToNumber ( $matches[1] );
            $day = $matches[2];
            $year = date ( "Y" );
            $startDate = "$year-$month-$day";
    
            // Add 6 days to get the end date
            $endWeekDate = date ( 'Y-m-d', strtotime ( $startDate . ' +6 days' ) );
            return $endWeekDate;
        }
        return false;
    }    

    function fetchAndSortResults ( $result ) {
        $sortedResults = [];
        $currentDate = date ( "Y-m-d" ); // Get the current date in the format YYYY-MM-DD
    
        while ( $row = mysqli_fetch_assoc ( $result ) ) {
            $endWeekDate = getEndWeekDate ( $row['week'] );
            if ( !$endWeekDate)  continue;  // invalid date format, skip
    
            if ( $endWeekDate >= $currentDate ) {
                $sortedResults[] = [
                    'week' => $row['week'],
                    'part' => $row['part'],
                    'endWeekDate' => $endWeekDate
                ];
            }
        }
    
        // Sort the results by endWeekDate
        usort ( $sortedResults, function ( $a, $b ) {
            return $a['endWeekDate'] <=> $b['endWeekDate'];
        });
    
        return $sortedResults;
    }    
    
    // For assignee
    if ( $result_asssignee ) {
        $results = fetchAndSortResults ( $result_asssignee );
        echo '<span style="font-size: 1.1rem"><b>Upcoming part(s) for ' . $assignee . ' :</b></span><hr>';
        foreach ( $results as $i => $result ) {
            echo "<b><i>" . ( $i + 1 ) . ". Week of " . $result['week'] . "</i></b><br>";
            echo $result['part'] . "<br><br>";
        }
        if ( empty ( $results ) ) {
            echo "Hello {$assignee}, you have no upcoming assignments yet.<br>";
        }
    } else {
        echo "<br>Error for Assignee: " . mysqli_error ( $tmscon );
    }
    
    // For assistant
    if ( $result_assistant ) {
        $results = fetchAndSortResults ( $result_assistant );
        echo '<hr><span style="font-size: 1.1rem"><b>Upcoming part(s) as an householder/reader:</b></span><br>';
        foreach ( $results as $i => $result ) {
            echo "<b><i>" . ( $i + 1 ) . ". Week of " . $result['week'] . "</i></b><br>";
            echo $result['part'] . "<br><br>";
        }
        if ( empty ( $results ) ) {
            echo "Hello {$assignee}, you have no upcoming assignments as an householder/reader yet.<br>";
        }
    } else {
        echo "<br>Error for Assistant: " . mysqli_error ( $tmscon );
    }

    mysqli_close ( $tmscon );

    ?>
</div>