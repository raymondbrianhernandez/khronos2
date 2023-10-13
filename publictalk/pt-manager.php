<?php ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>What to Expect</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Architects+Daughter&display=swap">
    <style>
        body {
            background-color: #FFF9C4;
            font-family: 'Architects Daughter', cursive;
        }
        header {
            background-color: #FFEB3B;
            padding: 1em;
            text-align: center;
        }
        ul {
            list-style-type: disc;
            padding-left: 2em;
            font-size: 16pt;
        }
        button {
            background-color: orange;
            font-family: 'Architects Daughter', cursive;
            font-size: 16pt;
        }
    </style>
</head>
<body>

    <header>
        <h1>Public Talk Manager</h1>
        <button onclick="goBack()">Go Back</button>
    </header>

    <main>
        <ul>
            <b>RAYMOND'S NOTES: September 28, 2023</b>
            <li>Ceate a database for Speakers, Congregation, Reminders, Chairman, Outline No.</li>
            <li>A function that randomizes Chairmans</li>
            <li>A function that checks if outline was used recently</li>
            <li>Overseer and Assitant assigned as PT-Admin access</li>
            <li>For non Admins, this page will also a hub for Public Talk Development</li>
                <ul style="list-style-type: circle;">
                    <li>Song Manager - checks if the song will overlap with Watchtower song schedule</li>
                    <li>Image Manager - Clips Images from JW Archives</li>
                    <li>Research Tools</li>
                </ul>
        </ul>
    </main>

    <div>
        <center>
        <?php include ( "../private/shared/footer.php" ); ?>
        </center>
    </div>

</body>

<script>
    function goBack() {
        window.history.back();
    }
</script>

</html>
