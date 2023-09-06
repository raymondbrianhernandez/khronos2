<form method="post" action="">
    
    <?php

    if ( isset ( $_POST['get_weeks'] ) ) {
        // Saves the week range
        $selected_week = $_SESSION['week_select'] = $_POST['week_select'];
        
        // Saves or queries the midweek meeting date 
        $midweek_date_sql_result  = mysqli_query ( $con, "SELECT `date` FROM `songs` WHERE `select_week` = '$selected_week'" );
        $table_row                = mysqli_fetch_assoc ( $midweek_date_sql_result );
        $_SESSION['midweek_date'] = $table_row['date'];
        
        // Now we query the assignments for that week range
        $current_year = date( "Y" );
        $query  = "SELECT * FROM assignments WHERE week = '$selected_week' and year = '$current_year'";
        $result = mysqli_query( $con, $query );

        // Displays the week range
        echo "<center><h4>For the week of " . $selected_week . "</h4></center><hr>";
        echo "<center><label for='midweek_date'>Set the midweek meeting date: </label>";
        echo "<input type='date' id='midweek_date' name='midweek_date' value='".$_SESSION['midweek_date']."'></center>";

        // Displays the songs for that week
        $songs = mysqli_query ( $con, "SELECT * FROM songs WHERE select_week = '".$_SESSION['week_select']."'" );
        echo "<center><table style='width: 80%; text-align: center;'>";
        echo "<tr>";
        echo "<td style='width: 25%;'><b>Bible Verses</b></td>";
        echo "<td style='width: 25%;'><b>Opening Song</b></td>";
        echo "<td style='width: 25%;'><b>Middle Song</b></td>";
        echo "<td style='width: 25%;'><b>Closing Song</b></td>";
        echo "</tr>";
        while($row = mysqli_fetch_array($songs)){
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
        
        // Displays the main assignment manager
        echo "<center><table style='width:90%'>";
        echo "  <tr>
                    <th style='width:20%; text-align:center';>Assignee</th>
                    <th style='width:20%; text-align:center';>Assistant/Reader</th>
                    <th style='width:60%; text-align:center';>Assignment Details</th>
                </tr>";

        $_SESSION["assignment"] = array();
        
        while( $row = mysqli_fetch_assoc( $result ) ) {
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
            echo "<input type='hidden' name='year' value='".$current_year."'>";
            echo "</td>";
            
            echo "</tr>";
            array_push ( $_SESSION["assignment"], $row );
        }

        echo "</table>";
        echo "<br><input type='submit' name='assign' value='Update Assignments' style='background: none; border: 1px solid; padding: 2px 4px; margin: 0; color: black; font-size: medium; font-family: sans-serif; border-radius: 20px;'>&nbsp;&nbsp;";
        echo "<button onclick=\"window.open('report.php', '_blank')\" style='background: none; border: 1px solid; padding: 2px 4px; margin: 0; color: black; font-size: medium; font-family: sans-serif;'>Generate Print Report</button>";
        echo "</center>";

    }

    // Once 'Update Assignments' button is pressed
    if ( isset ( $_POST['assign'] ) ) {
        $parts        = $_POST['part'];
        $publishers   = $_POST['publishers'];
        $assistants   = $_POST['assistant'];
        $week         = $_POST['week'];
        $year         = $_POST['year'];
        $midweek_date = $_SESSION['midweek_date'] = $_POST['midweek_date'];

        $set_midweek_date_sql = "UPDATE `songs` SET `date`='$midweek_date' WHERE `select_week` = '$week'";
        mysqli_query ( $con, $set_midweek_date_sql );
        
        for ( $i = 0; $i < count ( $parts ); $i++ ) {
            $assignee     = $publishers[$i];
            $assistant    = $assistants[$i];
            $part         = $parts[$i];
            $id           = $_SESSION["assignment"][$i]['id'];
            $update_query = "UPDATE assignments SET assignee = '$assignee', assistant = '$assistant', part = '$part' WHERE id = '$id';";
            mysqli_query ( $con, $update_query );
        }
    }
        
    ?>

    </form>