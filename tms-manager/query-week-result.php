<form method="post" action="">
    
    <?php

    require '_functions.php';
    include 'debug.php';

    if ( session_status() == PHP_SESSION_NONE ) {
        session_start();
    }

    $congregation = $_SESSION['congregation'];
    
    if ( isset ( $_POST['get_weeks'] ) ) {
        // Saves the week range
        $selected_week = $_SESSION['week_select'] = $_POST['week_select'];
        $year = $_SESSION['workbook_year'] = $_POST['year_select'];
        
        // Saves or queries the midweek meeting date 
        $midweek_date_sql_result  = mysqli_query ( $tmscon, "SELECT `date`, `time` FROM `songs` WHERE `select_week` = '$selected_week' AND `congregation` = '$congregation'" );
        $table_row                = mysqli_fetch_assoc ( $midweek_date_sql_result );
        $_SESSION['midweek_date'] = $table_row['date'];
        $_SESSION['midweek_time'] = $table_row['time'];
        
        // Now we query the assignments for that week range per congregation
        $query  = "SELECT * FROM assignments WHERE week = '$selected_week' and congregation = '$congregation'";
        $result = mysqli_query ( $tmscon, $query );

        // Displays the week range with time and date
        echo "<br><center><h4>For the week of " . $selected_week . "</h4></center><hr>";
        echo "<center><label for='midweek_date'>Set the midweek meeting date </label>";
        echo "<input type='date' id='midweek_date' name='midweek_date' value='".$_SESSION['midweek_date']."'> and time ";
        echo "<input type='time' id='midweek_time' name='midweek_time' value='".$_SESSION['midweek_time']."'></center>";

        // Displays the songs for that week
        $songs = mysqli_query ( $tmscon, "SELECT * FROM songs WHERE select_week = '".$_SESSION['week_select']."' AND congregation = '".$_SESSION['congregation']."'");
        echo "<center><table style='width: 80%; text-align: center;'>";
        echo "<tr>";
        echo "<td style='width: 25%;'><b>Bible Verses</b></td>";
        echo "<td style='width: 25%;'><b>Opening Song</b></td>";
        echo "<td style='width: 25%;'><b>Middle Song</b></td>";
        echo "<td style='width: 25%;'><b>Closing Song</b></td>";
        echo "</tr>";
        while ( $row = mysqli_fetch_array ( $songs ) ){
            echo "<tr>";
            $_SESSION["verse"]      = $row['verse'];
            $_SESSION["song_open"]  = $row['song_open']; 
            $_SESSION["song_mid"]   = $row['song_mid'];
            $_SESSION["song_close"] = $row['song_close'];
            echo "<td style='width: 25%;'>" . $row['verse'] . "</td>";
            echo "<td style='width: 25%;'>" . $row['song_open'] . "</td>";
            echo "<td style='width: 25%;'>" . $row['song_mid'] . "</td>";
            echo "<td style='width: 25%;'>" . $row['song_close'] . "</td>";
            echo "</tr>";
        }
        echo "</table></center><hr>";

        // Assigning the Chairman and Aux Counselor
        $temp_query = "SELECT chairman, advisor 
                        FROM assignments 
                        WHERE week = '$selected_week' 
                        AND year = '$year' 
                        AND congregation = '$congregation'
                        LIMIT 1";
        // echo $temp_query;
        $temp_result = mysqli_query( $tmscon, $temp_query );
        $temp_row = mysqli_fetch_assoc ( $temp_result );
        echo "<tr>";
        echo "  <td style='width: 50%; text-align: center;'>"; 
        echo "    <label for='chairman'>Chairman</label><br>";
        echo "    <select name='chairman' style='margin-left:auto; margin-right:auto; width:50%;'>";

        foreach ( $publishers as $publisher ) {
            $select = $publisher == $temp_row['chairman'] ? 'selected' : '';
            echo "<option value='" . $publisher . "' $select>" . $publisher . "</option>";
        }
        
        echo "    </select>"; 
        echo "  </td><br>";
        echo "  <td style='width: 50%; text-align: center;'>"; 
        echo "    <label for='advisor'>Auxiliary Classroom Counselor</label><br>";
        echo "    <select name='advisor' style='margin-left:auto; margin-right:auto; width:50%;'>";

        foreach ( $publishers as $publisher ) {
            $select = $publisher == $temp_row['advisor'] ? 'selected' : '';
            echo "<option value='" . $publisher . "' $select>" . $publisher . "</option>";
        }

        echo "    </select>"; 
        echo "  </td>";
        echo "</tr>";

        echo "<hr><center><table style='width:90%'>";
        echo "  <tr>
                    <th style='width:20%; text-align:center';>Assignee</th>
                    <th style='width:20%; text-align:center';>Assistant/Reader</th>
                    <th style='width:60%; text-align:center';>Assignment Details</th>
                </tr>";

        $_SESSION["assignment"] = array();
        
        while ( $row = mysqli_fetch_assoc ( $result ) ) {
            echo "<tr>";
            echo "  <td>"; 
            echo "    <center><select name='publishers[]'>";
                        //populating the assignee dropdown with the publishers array
                        foreach( $publishers as $publisher ) {
                            $select = $publisher == $row['assignee'] ? 'selected' : '';
                            echo "<option value='".$publisher."' $select>".$publisher."</option>";
                        }
            echo "    </select></center>"; 
            echo "  </td>";

            echo "  <td>"; 
            echo "    <center><select name='assistant[]'>";
                        //populating the assistant dropdown with the publishers array
                        foreach ( $publishers as $publisher ) {
                            $select = $publisher == $row['assistant'] ? 'selected' : '';
                            echo "<option value='".$publisher."' $select>".$publisher."</option>";
                        }
            echo "    </select></center>"; 
            echo "  </td>";

            echo "<td style='vertical-align:middle'>";
            echo "<textarea name='part[]' rows='3' style='width:100%; word-wrap:break-word;'>".$row['part']."</textarea></td>";
            echo "<input type='hidden' name='week' value='".$selected_week."'>";
            echo "<input type='hidden' name='year' value='".$year."'>";
            echo "</td>";
            echo "</tr>";

            array_push ( $_SESSION["assignment"], $row );
        }

        echo "</table>";
        echo "<br><input type='submit' name='assign' value='Update Assignments' style='background: none; border: 1px solid; padding: 2px 4px; margin: 0; color: black; font-size: medium; font-family: sans-serif; border-radius: 20px;'>&nbsp;&nbsp;";
        echo "<button onclick=\"window.open('report.php', '_blank')\" style='background: none; border: 1px solid; padding: 2px 4px; margin: 0; color: black; font-size: medium; font-family: sans-serif;'>Generate Print Report</button>";
        echo "</center>";

    }

    echo "<br>";

    // Once 'Update Assignments' button is pressed
    if ( isset ( $_POST['assign'] ) ) {
        $chairman           = $_POST['chairman'];
        $advisor            = $_POST['advisor'];
        $parts              = $_POST['part'];
        $publishers         = $_POST['publishers'];
        $assistants         = $_POST['assistant'];
        $week               = $_POST['week'];
        $year               = $_SESSION['workbook_year'];
        $midweek_date       = $_SESSION['midweek_date'] = $_POST['midweek_date'];
        $midweek_time       = $_SESSION['midweek_time'] = $_POST['midweek_time'];
        $isTagalog          = $_SESSION['language'] == 'Tagalog';
        $flaggedAssignees   = array();
        $warningOverlap     = false;
        $recentAssignees    = [];

        // Prepare the SQL query
        $updateSongsQuery = "UPDATE `songs` SET `date` = ?, `time` = ? WHERE `select_week` = ? AND `congregation` = ?";
        $updateAssignmentsQuery = "UPDATE `assignments` SET `date` = ?, `time` = ? WHERE `week` = ? AND `congregation` = ?";

        // Use prepared statements for both queries
        $stmt = mysqli_prepare ( $tmscon, $updateSongsQuery );
        mysqli_stmt_bind_param ( $stmt, "ssss", $midweek_date, $midweek_time, $week, $congregation );
        if ( !mysqli_stmt_execute ( $stmt ) ) {
            // Handle error
            echo "Error updating songs: " . mysqli_error ( $tmscon );
        }
        mysqli_stmt_close ( $stmt );

        $stmt = mysqli_prepare ( $tmscon, $updateAssignmentsQuery );
        mysqli_stmt_bind_param ( $stmt, "ssss", $midweek_date, $midweek_time, $week, $congregation );
        if ( !mysqli_stmt_execute ( $stmt ) ) {
            // Handle error
            echo "Error updating assignments: " . mysqli_error ( $tmscon );
        }
        mysqli_stmt_close ( $stmt );

        
        for ( $i = 0; $i < count ( $parts ); $i++ ) {
            $assignee     = trim ( $publishers[$i] );
            $assistant    = trim ( $assistants[$i] );
            $part         = $parts[$i];
            $id           = $_SESSION["assignment"][$i]['id'];

            // Skip this iteration if the assignee and assistant are empty strings
            if ( !$assignee && !$assistant ) {
                $update_query = "UPDATE assignments SET chairman = '$chairman', advisor = '$advisor', assignee = '$assignee', assistant = '$assistant', part = '$part' WHERE id = '$id' AND congregation = '$congregation';";
                mysqli_query ( $tmscon, $update_query );
            } else {
                // Check recent assignment for assignee
                if ( $assignee && !isset ( $recentAssignees[$assignee] ) ) {
                    $recentStatusAssignee = checkRecent ( $tmscon, $assignee, $week, $year, $isTagalog, $congregation );
                    //echo $assignee . " " .$recentStatusAssignee . "<br>";
                    if ( $recentStatusAssignee != "none" ) {
                        echo "<div><b>Warning:</b> $recentStatusAssignee.</div>";
                        $recentAssignees[$assignee] = true;
                    }
                }
            }

            // Check multiple parts for same week
            if ( $assignee && $assignee != '' && !in_array ( $assignee, $flaggedAssignees ) ) {
                $overlapStatusAssignee = checkArrayOverlaps ( $publishers, $assistants, $i, true );
                if ( $overlapStatusAssignee == "overlap" ) {
                    echo "<div><b>Warning:</b> $assignee has multiple assignments for the week of {$week}, {$year}.</div>";
                    $flaggedAssignees[] = $assignee;
                }
            }

            $update_query = "UPDATE assignments SET chairman = '$chairman', advisor = '$advisor', assignee = '$assignee', assistant = '$assistant', part = '$part' WHERE id = '$id';";
            mysqli_query ( $tmscon, $update_query );
        }

        echo "<div><hr><b>Note:</b> Assignments added for {$week}, {$year}</div>";
    }
        
    ?>

    </form>