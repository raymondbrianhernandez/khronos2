<?php ?>

<div class="text-center small mt-4">
    <div class="btn-group" role="group">
        <form action="reset-timer.php" method="POST">
            <button id="resetTimeBtn" type="submit"> Reset Timer </button>&nbsp;
        </form>
        
        <button id="startTimeBtn" onclick="startTime()"> Service Start </button>&nbsp;
        <button id="endTimeBtn" onclick="endTime()"> Service Stop </button>&nbsp;
        
        <form action="submit-time.php" method="POST">
            <button id="submitTimeBtn" type="submit"> Submit Time </button>
        </form>
    </div>
    <div id="display-timestamp-message"></div>
    <script>
        /* localStorage.setItem('isLoggedIn', false); */
        
        document.getElementById("startTimeBtn").addEventListener("click", 
            function() {
                var startTime = new Date().toLocaleTimeString('en-US');
                window.location = "hours.php?startTime="+startTime+"#clock";

            }
        );
        
        document.getElementById("endTimeBtn").addEventListener("click", 
            function() {
                var endTime = new Date().toLocaleTimeString('en-US');
                /* document.getElementById('display-timestamp-message').innerHTML = 'Service Stopped'; */
                window.location = "hours.php?endTime="+endTime+"#clock";
            }
        );
    </script>
    
    <?php
    if ( !isset( $_SESSION['startTime'] ) && $_SESSION['clockedIn'] == FALSE ) {
        $_SESSION['startTime'] = $_GET['startTime'];
        
    }
    if ( !isset( $_SESSION['endTime'] ) ) {
        $_SESSION['endTime'] = $_GET['endTime'];
        $diff = strtotime($_SESSION['endTime']) - strtotime($_SESSION['startTime']);
        $hours = floor($diff / (60 * 60));
        $minutes = floor(($diff % (60 * 60)) / 60 );
        
        $_SESSION['totalTime'] = $hours.".".$minutes;  
        $_SESSION['hrs'] = $hours;
        $_SESSION['min'] = $minutes;
    } 
    echo "<b>Time Started: </b>" . $_SESSION['startTime'] . "<br>";
    echo "<b>Time Stopped: </b>" . $_SESSION['endTime'] . "<br>";
    
    if ( isset( $_SESSION['startTime'] ) && !isset( $_SESSION['endTime'] ) ) {
        $_SESSION['clockedIn'] = TRUE;
        echo "<hr><span style=\"color:red\"><b>Clock-in recorded. Press 'Service Stop' when done for service.<br></span>";
    } else if ($_SESSION['totalTime'] > 24) { // Overflow control if the pioneer forgots to clock in for days
        echo "<hr><span style=\"color:red\"><b>ERROR: You must clock-in first.  Please reset the timer.<br></span>"; 
    } else {
        echo "<b>Total Time: </b>" . $_SESSION['hrs'] . " hour(s) and ".  $_SESSION['min'] ." minutes<br>";
        echo "<hr>1. Click <b>'Service Start'</b> to start recording your time<br>";
        echo "2. Click <b>'Service Stop'</b> when done <br>";
        echo "3. Click <b>'Submit Time'</b>.";
    }
    ?>
</div>