<table class="letterhead">
    <tr>
        <td style="width:50%"><h3><?php echo $congregation; ?> Congregation </h3></td>
        <td style="width:50%">
            <?php 
                if ($isTagalog) { 
                    echo "<h2>Iskedyul ng Pulong sa Gitnang Sanlinggo</h2>";
                } else {
                    echo "<h2>Midweek Meeting Schedule</h2>";
                } 
            ?>
        </td>
    </tr>
    <tr>
        <td style="width:50%"><b><?= $commonData['date'] . " | " . $commonData['verse']; ?></b></td>
        <td style="width:50%"></td>
    </tr>
</table>