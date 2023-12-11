<?php

if ( session_status() == PHP_SESSION_NONE ) {
    session_start();
}

$year = $_SESSION['workbook_year'];

// SQL query using HEREDOC
$congregation = mysqli_real_escape_string ( $tmscon, $_SESSION['congregation'] );
$query = <<<SQL
            SELECT week, year 
            FROM (
                SELECT week, year, MIN(id) as min_id 
                FROM assignments 
                WHERE congregation = '$congregation'
                GROUP BY week
            ) as subquery 
            ORDER BY min_id ASC
            SQL;

// Execute the query
$result = mysqli_query ( $tmscon, $query );

?> 

<form method="post" action="" name="weekForm" onsubmit="return validateForm()">
    <hr>
    <div style="display: flex; flex-direction: column; align-items: center;">
        <h6><b>Select Week to Assign:</b></h6>
        <small>(if dropdown is empty or new weeks are not showing up, please <a href="upload"> upload a new JW Workbook</a>)</small>
        <div style="display: flex; justify-content: center; align-items: center;">
            <select name='week_select' style="margin-right: 10px;">
                <option></option>

                <?php

                while ( $row = mysqli_fetch_assoc ( $result ) ) {
                    echo "<option value='{$row['week']}' data-year='{$row['year']}'>{$row['week']}, {$row['year']}</option>";
                }

                ?>

            </select>
            <input type="hidden" name="year_select" id="year_select" value="<?= $year ?>">
            <input type="submit" name="get_weeks" value="Query">
        </div>
    </div>

</form>

<script>
    function validateForm() {
        var weekSelect = document.forms["weekForm"]["week_select"].value;
        if ( weekSelect == ""  ) {
            alert ( "Must select week to assign first" );
            return false;
        }
        return true;
    }

    document.getElementById ( "weekForm" ).addEventListener ( "submit", function() {
        var selectedWeek = document.getElementById ( "week_select" );
        var year = selectedWeek.options[selectedWeek.selectedIndex].getAttribute ( "data-year" );
        document.getElementById ( "year_select" ).value = year;
    });
</script>

