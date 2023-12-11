<?php

echo "<table>";
        echo "  <tr>";
        echo "    <td class='congregation'><h3>" . strtoupper ( $congregation ) . " CONGREGATION </h3></td>";
        echo "    <td class='schedule-header'>";
        echo $isTagalog ? 
            "<h3> Iskedyul ng Pulong sa Gitnang Sanlinggo </h3>" :
            "<h3> Midweek Meeting Schedule </h3>";
        echo "    </td>";
        echo "  </tr>";
        echo "  <tr>";
        echo "    <td class='col-1'><b>{$commonData['date']} | {$commonData['verse']} | {$commonData['week']} </b></td>";
        echo "  </tr>";
        echo "</table>";

?>