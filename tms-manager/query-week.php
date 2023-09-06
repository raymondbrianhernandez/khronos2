<?php

// SQL query using HEREDOC
$query = <<<SQL
            SELECT week 
            FROM (
                SELECT week, MIN(id) as min_id 
                FROM assignments 
                GROUP BY week
            ) as subquery 
            ORDER BY min_id ASC
            SQL;

// Execute the query
$result = mysqli_query ( $con, $query );

?> 

<form method="post" action="">
    <hr>
    <div style="display: flex; flex-direction: column; align-items: center;">
        <h6>Select Week to Assign:</h6>
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
