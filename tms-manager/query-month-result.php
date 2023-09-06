<form method="post" action="">

    <div style="text-align: center; display: flex; justify-content: center; align-items: center;"> 
        <h6 style="margin-right: 10px;">Select Month</h6>
        <select name='month_select' style="margin-right: 10px;" onchange="this.form.submit()">
            <option></option>
            <?php
            for ($i = 1; $i <= 12; $i++) {
                $month_name = date("F", mktime(0, 0, 0, $i, 10));
                echo "<option value='$i'>$month_name</option>";
            }
            ?>
        </select>
    </div>

    <?php
    if (isset($_POST['month_select'])) {
        $selected_month = $_POST['month_select'];
    ?>

    <div style="text-align: center; display: flex; justify-content: center; align-items: center;"> 
        <h6 style="margin-right: 10px;">Select Week</h6>
        <select name='week_select' style="margin-right: 10px;">
            <option></option>
            <?php
            $query = "SELECT DISTINCT `select_week` FROM `songs` WHERE MONTH(`select_week`) = '$selected_month' ORDER BY `select_week` ASC";
            $weeks = mysqli_query($con, $query);
            while ($row = mysqli_fetch_assoc($weeks)) {
                echo "<option value='{$row['select_week']}'>{$row['select_week']}</option>";
            }
            ?>
        </select>
        <input type="submit" name="get_weeks" value="Query">
    </div>
    <hr>

    <?php } // End of the if statement for month selection
    ?>

    <?php

    if ( isset ( $_POST['get_weeks'] ) ) {
        $selected_week = $_SESSION['week_select'] = $_POST['week_select'];
        $current_year = date("Y");

        // Query midweek date
        $stmt = $con->prepare ( "SELECT `date` FROM `songs` WHERE `select_week` = ?" );
        $stmt->bind_param ( "s", $selected_week );
        $stmt->execute();
        $table_row = $stmt->get_result()->fetch_assoc();
        $_SESSION['midweek_date'] = $table_row['date'];
        $stmt->close();

        // Display week range and midweek date
        echo <<<HTML
                    <div style="text-align: center;">
                        <h4>For the week of $selected_week</h4>
                        <label for="midweek_date">Set the midweek meeting date: </label>
                        <input type="date" id="midweek_date" name="midweek_date" value="{$_SESSION['midweek_date']}">
                    </div>
                    <hr>
                HTML;

        // Display songs
        displaySongs ( $con, $selected_week );

        // Display assignments
        displayAssignments ( $con, $selected_week, $current_year, $publishers );
    }

    // Update Assignments logic
    if ( isset ( $_POST['assign'] ) ) {
        updateAssignments ( $con );
    }

    function displaySongs ( $con, $selected_week ) {
        $stmt = $con->prepare ( "SELECT * FROM songs WHERE select_week = ?" );
        $stmt->bind_param ( "s", $selected_week );
        $stmt->execute();
        $result = $stmt->get_result();
        
        echo "<div style='text-align: center; width: 80%; margin: 0 auto;'>";
        echo "<table style='width: 100%; text-align: center;'>";
        echo "<tr><th>Bible Verses</th><th>Opening Song</th><th>Middle Song</th><th>Closing Song</th></tr>";
        
        while ( $row = $result->fetch_assoc() ) {
            echo "<tr>";
            echo "<td>{$row['verse']}</td>";
            echo "<td>{$row['song_open']}</td>";
            echo "<td>{$row['song_mid']}</td>";
            echo "<td>{$row['song_close']}</td>";
            echo "</tr>";
        }
        echo "</table></div><hr>";
        $stmt->close();
    }

    function displayAssignments ( $con, $selected_week, $current_year, $publishers ) {

        $stmt = $con->prepare ( "SELECT * FROM assignments WHERE week = ? and year = ?" );
        $stmt->bind_param ( "ss", $selected_week, $current_year );
        $stmt->execute();
        $result = $stmt->get_result();

        echo "<div style='text-align: center; width: 90%; margin: 0 auto;'>";
        echo "<table style='width: 100%; text-align: center;'>";
        echo "<tr><th>Assignee</th><th>Assistant/Reader</th><th>Assignment Details</th></tr>";

        $_SESSION["assignment"] = array();

        while ( $row = $result->fetch_assoc() ) {
            $assigneeOptions = generateOptionList ( $publishers, $row['assignee'] );
            $assistantOptions = generateOptionList ( $publishers, $row['assistant'] );

            echo "<tr>";
            echo "<td><select name='publishers[]'>$assigneeOptions</select></td>";
            echo "<td><select name='assistant[]'>$assistantOptions</select></td>";
            echo "<td><textarea name='part[]' rows='3' style='width:100%;'>{$row['part']}</textarea></td>";
            echo "</tr>";
            
            $_SESSION["assignment"][] = $row;
        }

        echo "</table>";
        echo "<br><input type='submit' name='assign' value='Update Assignments'>&nbsp;&nbsp;";
        echo "<button onclick=\"window.open('report.php', '_blank')\">Generate Print Report</button>";
        echo "</div>";

        $stmt->close();
    }

    function generateOptionList ( $publishers, $selectedValue ) {
        $options = "";
        foreach ( $publishers as $publisher ) {
            $selected = $publisher == $selectedValue ? 'selected' : '';
            $options .= "<option value='$publisher' $selected>$publisher</option>";
        }
        return $options;
        }

    function updateAssignments ( $con ) {
        $parts = $_POST['part'];
        $publishers = $_POST['publishers'];
        $assistants = $_POST['assistant'];
        $week = $_POST['week'];
        $year = $_POST['year'];
        $midweek_date = $_SESSION['midweek_date'] = $_POST['midweek_date'];

        $stmt = $con->prepare ( "UPDATE `songs` SET `date`=? WHERE `select_week` = ?" );
        $stmt->bind_param ( "ss", $midweek_date, $week );
        $stmt->execute();
        $stmt->close();

        for ( $i = 0; $i < count ( $parts ); $i++ ) {
            $assignee = $publishers[$i];
            $assistant = $assistants[$i];
            $part = $parts[$i];
            $id = $_SESSION["assignment"][$i]['id'];

            $stmt = $con->prepare ( "UPDATE assignments SET assignee = ?, assistant = ?, part = ? WHERE id = ?" );
            $stmt->bind_param ( "ssss", $assignee, $assistant, $part, $id );
            $stmt->execute();
            $stmt->close();
        }
    }

    ?>

</form>
