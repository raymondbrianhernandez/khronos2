<?php

require("../private/secure.php");
require_once("../private/db_config.php");
/* include("debug.php"); */
session_start();

date_default_timezone_set("America/Los_Angeles");
$query = 'SELECT * FROM notebook WHERE owner="'.$_SESSION['owner']. '" ORDER BY id DESC';

?>

<!DOCTYPE html>
<html lang="en">
<!-- 
________________________________________________________
__|____|____|______|___|____|____|_____|___|_______|____
___|__|______|____|___|___/\__|____|__|___|__/\__|___|__
____|__|___|__|__\  |____|  |____|__|___|____)/_|___|___
_\__  \__\    _ \_| __ \_|  |  \_|  |_/  _ \____/  ___/_
__/ __ \__|  |_\/_| \_\ \|      \|  |\   __/____\__  \__
_(____  /_|__|____|___  /|___|  /|__|_\___  /|_/____  \_
___|__\/___|__________\/______\/__|_______\/_____|__\/__
_____|______|______|_______|___|___|___|___________|____
________________________________________________________
______|_____|___|____|_____|___|_|_____|__|____|___|____
____|___|__|___|______|______|_____|__|____|__|___|_____
__|___|_____|______|__|___|___|_|__|___|_______|________
___/  ___/_/  _ \_\    _ \\  \/ /|  |_/ ___\__/  _ \____
___\__  \_\   __/__|  |_\/_\   /_|  |\  \____\   __/____
__/____  \_\___  /_|__|___|_\_/__|__|_\___  /_\___  /___
____|__\/______\/___|_______|_____|_______\/______\/____
______|_____|________|________|____|____|______|________
________________________________________________________
___|______|___|___|__|_______|_____|______|___|_____|___
____|____|___|___|____|___|_________|____|___|____|___|_
__|__|_____|_______|_______|______|__|______|  /_|___|__
\    _ \_/  _ \__/ ___\__/ __ \_\    _ \_/ __ |__/  ___/
_|  |_\/\   __/_\  \____(  \_\ )_|  |_\// /_/ |__\__  \_
_|__|____\___  /_\___  /_\____/__|__|___\____ |_/____  \
__|__________\/______\/___|_______|__________\/___|__\/_
___|______|________|________|______|______|_________|___ 
-->
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>My Notebook - Service Records</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" media="all" href="./stylesheets/charts.min.css" />
    
    <link rel="stylesheet" media="all" href="./stylesheets/phpvariables.php" />
    <link rel="stylesheet" media="all" href="./stylesheets/notebook.css" />
    <link rel="stylesheet" media="all" href="./stylesheets/dashboard.css" />
    <!-- Map Libre -->
    <script src='https://unpkg.com/maplibre-gl@2.4.0/dist/maplibre-gl.js'></script>
    <link href='https://unpkg.com/maplibre-gl@2.4.0/dist/maplibre-gl.css' rel='stylesheet' />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="./src/javascript.js"></script>

    <!-- CODE SYNTAX HIGHLIGHTING -->
    <link rel="stylesheet" href="/path/to/styles/default.min.css">
    <script src="/path/to/highlight.min.js"></script>
    <script>hljs.highlightAll();</script>

    <!-- Handwriting Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Architects+Daughter&display=swap" rel="stylesheet">
</head>

<body>
    <header>
        <?php include("../private/shared/navigation.php"); ?>
    
        <div class="parent">
            <div class="leftborder"></div>
            <div class="rightborder"></div>

            <div class="mainbody">
                <!-- Start: Login Form Basic -->
                <div class="container">
                    <div class="row d-flex justify-content-center"> 
                    <!-- MAIN CONTENT HERE -->
                    <div class="welcome">
                        <p><h5><b><?= $_SESSION['owner']."'s Notebook"; ?> </b></h5></p>
                    </div>

                    <div style="text-align:left; background-color:#d9e5ff; height:100px; overflow-y:auto">
                        <p><b><i> Did you know? </i></b></p>
                        <p> 
                            Basic HTML tags works on this text editor.  So customize your notes!
                            Yes, emojis works too! <span style='font-size:20px;'>&#128525;</span> 
                            <a href = "https://www.w3schools.com/charsets/ref_emoji.asp" target="_blank"> Here's
                            a reference on using emojis. </a>
                        </p>    
                    </div>
                    
                </div>    
                
                <div >
                    <form action="notes.php" method="post">
                        <div class="notebook">
                            <label for="notebook"></label>
                            <center><textarea rows="10" cols="50" name="notebook" required></textarea></center>
                            <br>
                        </div>
                        <div>
                            <center><button id="greenbutton" type="submit"> Save Notes </button></center>
                        </div>
                    </form>
                </div>
                <hr> 

                <div class="save-links">
                    <form action="addlinks-meta.php" method="post">
                        <p style="text-align:center"><b> Website Links Bookmark Manager </b></p>
                        <div class="row">
                            <div class="col-25">
                                <label for="links"> Link: </label>
                            </div>
                            <div class="col-75">
                                <input type=url name="links" style="width:70%" required>
                            </div>
                            <!-- <div class="col-25">
                                <label for="links"> Description: </label>
                            </div>
                            <div class="col-75">
                                <input type=text name="desc" style="width:70%" required>
                            </div> -->
                        </div>
                        <button id="greenbutton" type="submit"> Save Links to Notes </button>
                    </form>
                </div>
                
                <hr>

                <div class="row d-flex justify-content-center">
                    <p style="text-align:center"><b>  </b></p>
                    <!-- <table id="address-table">
                        <tr id="column-header">
                            <th> DATE </th>
                            <th> SAVED NOTES & LINKS </th>
                            <th> ACTION </th>
                        </tr> -->
                        
                        <?php
                            $result = mysqli_query($con, $query); 
                            while ($row =  mysqli_fetch_assoc($result)):
                        ?>
                            <button type="button" class="collapsible-journal">
                                <p><b><?= $row['date']; ?></b></p>
                                <p><?= $row['notes']; ?></p>
                            </button>
                            <div class="content">
                            <form action="notes_append.php" method="post">      
                                <textarea rows="7" cols="40" name="notes" ><?= $row['notes']; ?></textarea><br>
                                <input type="hidden" name="id" value="<?= $row['id']; ?>" >
                                <input type="hidden" name="date" value="<?= $row['date']; ?>" >
                            
                                <center>
                                    <button id="greenbutton" type="submit"> Save changes </button>
                                    <button id="redbutton" type="submit" formaction="notes_delete.php"> Delete note </button>
                                </center>
                            </form>
                            </div>

                        <?php endwhile; ?>

                    </table>
                </div>

            </div>

            <div>
            <?php include("../private/shared/footer.php"); ?>
            </div>

        </div> <!-- Parent -->
    </header>   
 
</body>
</html>

<script>
    var coll = document.getElementsByClassName("collapsible-journal");
    var i;

for (i = 0; i < coll.length; i++) {
    coll[i].addEventListener("click", function() {
        this.classList.toggle("active-note");
        var content = this.nextElementSibling;
        
        if ( content.style.display === "block" ) {
            content.style.display = "none";
        } else {
            content.style.display = "block";
        }
    });
}
</script>