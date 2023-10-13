<?php

// SQL query using HEREDOC
$tmscongregation = mysqli_real_escape_string ( $tmscon, $_SESSION['congregation'] );
$query = <<<SQL
            SELECT week 
            FROM (
                SELECT week, MIN(id) as min_id 
                FROM assignments 
                WHERE congregation = '$tmscongregation'
                GROUP BY week
            ) as subquery 
            ORDER BY min_id ASC
            SQL;

// Execute the query
$result = mysqli_query ( $tmscon, $query );

?> 

<form method="post" action="">
    <hr>
    <div style="display: flex; flex-direction: column; align-items: center;">
        <h6><b>Select Week to Assign:</b></h6>
        <small>(if dropdown is empty, please upload a new JW Workbook)</small>
        <div style="display: flex; justify-content: center; align-items: center;">
            <select name='week_select' style="margin-right: 10px;">
                <option></option>

                <?php
                    while ( $row = mysqli_fetch_assoc ( $result ) ) {
                        echo "<option value='{$row['week']}'>{$row['week']}</option>";
                    }
                ?>

            </select>
            <input type="submit" name="get_weeks" value="Query">
        </div>
    </div>

</form>
