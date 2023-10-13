<!-- Display Div -->
<div id="timeDisplay"></div>

<!-- Buttons -->
<div class="col-12">
    <button id="resetTimeBtn">Reset Timer</button>
</div>
<div class="col-12">
    <button id="startTimeBtn">Start Time</button>
</div>
<div class="col-12">
    <button id="endTimeBtn">End Time & Submit</button>
</div>
<!-- <button id="submitTimeBtn">Submit Time</button> -->

<!-- JavaScript -->
<script>
    let startTime     = <?php echo isset ( $_SESSION['startTime']) ? "'".$_SESSION['startTime']."'" : 'null'; ?>; 
    let endTime       = null;
    const timeDisplay = document.getElementById ( 'timeDisplay' );

    // Fetch session values on page load
    fetch ( 'getSessionData.php' )
        .then ( response => response.json() )
        .then ( data => {
            if ( data.clockedIn ) {
                let formattedTime = new Date ( data.startTime ).toLocaleTimeString();
                timeDisplay.innerHTML = `Time Started: ${formattedTime}`;
            }
        });


    document.getElementById ( 'resetTimeBtn' ).addEventListener ( 'click', function() {
        startTime = null;
        endTime   = null;
        timeDisplay.innerHTML = ''; // Clear the display
        alert ( 'Timer reset!' );
    });

    document.getElementById ( 'startTimeBtn' ).addEventListener ( 'click', function() {
        startTime = new Date();
        if ( typeof $_SESSION !== 'undefined' && $_SESSION['clockedIn'] ) {
            timeDisplay.innerHTML = `Time Started: $_SESSION['startTime']`;
        } else {
            timeDisplay.innerHTML = `Time Started: ${startTime.toLocaleTimeString()}`; // Display start time
            saveTimeToSession ( 'startTime', startTime );
            alert ( 'Timer started!' );
        }
    });

    document.getElementById ( 'endTimeBtn' ).addEventListener ( 'click', function() {
        fetch ( 'getSessionData.php' )
            .then ( response => response.json() )
            .then ( data => {
                if ( startTime || data.clockedIn ) {
                    endTime = new Date();
                    timeDisplay.innerHTML += `<br>Time Ended: ${endTime.toLocaleTimeString()}`; // Display end time
                    saveTimeToSession ( 'endTime', endTime );
                    
                    // Update the session value for clockedIn to false
                    fetch ( 'endSession.php', {
                        method: 'POST'
                    })
                    .then ( response => response.json() )
                    .then ( data => {
                        if ( data.success ) {
                            // Calculate hours logged and send to server
                            if ( startTime && endTime ) {
                                let hoursLogged = ( ( endTime - startTime ) / ( 1000 * 60 * 60 ) ).toFixed ( 2 ); // Rounded to 2 decimal places
                                sendDataToServer ( hoursLogged );
                            } else {
                                alert ( 'Please start the timer first!' );
                            }
                        } else {
                            alert ( 'There was an error ending the timer.' );
                        }
                    });
                } else {
                    alert ( 'Please start the timer first!' );
                }
            });
    });

    function saveTimeToSession ( type, time ) {
        fetch ( `${type}.php`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify ( { time: time.toISOString() } )
        });
    }

    function sendDataToServer ( hours ) {
        fetch ( 'submit-time.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify ( { hoursLogged: hours } )
        })
        .then ( response => response.json() )
        .then ( data => {
            if ( data.success ) {
                hours = parseFloat ( hours ).toFixed ( 2 );  // Convert hours to a float here
                alert ( `Your service time for today have been submitted.` );
            } else {
                alert ( 'There was an error submitting the time.' );
            }
        });
    }

</script>
