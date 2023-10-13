<?php

include ( '../private/db_config.php' ); 

$sql = "SELECT `congregation_name` FROM `congregations`";
$result = $con->query($sql);

echo '<select name="congregation" class="form-control" style="text-align:center" required>';
echo '<option value="" disabled selected>Select your congregation</option>';

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo '<option value="' . htmlspecialchars($row['congregation_name']) . '">' . htmlspecialchars($row['congregation_name']) . '</option>';
    }
} else {
    echo '<option value="" disabled>No congregations found</option>';
}

echo '</select>';

$con->close();

?>
