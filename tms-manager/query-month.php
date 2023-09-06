<?php
if (isset($_POST['get_month'])) {
    $selected_month = $_POST['month_select'];
    $current_year = date("Y");

    // SQL query using HEREDOC
    $query = <<<SQL
                SELECT week 
                FROM (
                    SELECT week, MIN(id) as min_id 
                    FROM assignments 
                    WHERE MONTH(week) = $selected_month AND YEAR(week) = $current_year
                    GROUP BY week
                ) as subquery 
                ORDER BY min_id ASC
                SQL;

    // Execute the query
    $result = mysqli_query($con, $query);
}
?>

<form method="post" action="">
    <hr>
    <div style="text-align: center; display: flex; justify-content: center; align-items: center;"> 
        <h6 style="margin-right: 10px;">Select Month</h6>
        <select name='month_select' style="margin-right: 10px;">
            <option></option>
            <?php
            for ($i = 1; $i <= 12; $i++) {
                $month_name = date('F', mktime(0, 0, 0, $i, 1));
                echo "<option value='$i'>$month_name</option>";
            }
            ?>
        </select>
        <input type="submit" name="get_month" value="Query">
    </div>
</form>

<?php
if (isset($result)) {
    echo "<div style='text-align: center; margin-top: 20px;'><h6>Weeks for the selected month:</h6>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<p>{$row['week']}</p>";
    }
    echo "</div>";
}
?>
