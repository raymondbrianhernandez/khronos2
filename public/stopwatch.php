<div class="card-header d-flex justify-content-between align-items-center" id="clock">
    <h5 class="text-primary fw-bold m-0"> Clock-in </h5>
</div>

<div class="card-body"> 
    <div id="analog-clock">
        <div>
            <h4 id="title_currentTime"> Time </h4>
            <p class="w-lg-50">“For everything there is an appointed time.”​ <br>(<i>Ecclesiastes 3:1, NWT</i>)</p>
            <?php include( 'analog-clock.php' ) ?>
        </div>
    </div>

    <?php include ( 'calculate-timeOLD.php' ); ?>
    <!-- <div class="text-center small mt-4"> 
        <form method="post" action="hours.php">
            <input type="hidden" id="start_time" name="start_time">
            <input type="hidden" id="end_time" name="end_time">
            <button id="startTimeBtn" type="button" onclick="clockIn()">Clock In</button>
            <button id="endTimeBtn" type="submit" onclick="clockOut()">Clock Out</button>
        </form>
        <form action="submit-time.php" method="POST">
            <button id="submitTimeBtn" type="submit"> Submit Time </button>
        </form>
        <div id="output">
        < ?php
            // Clock in
            $start_time = $_POST['start_time'];
            $end_time = $_POST['end_time'];
            $total_time = strtotime($end_time) - strtotime($start_time);
            $_SESSION['totalTime'] = gmdate("H:i:s", $total_time);
            echo "<br>Total time worked: " . gmdate("H:i:s", $total_time);
        ?>
        </div>
    </div> -->

</div>