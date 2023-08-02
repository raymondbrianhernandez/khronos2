<?php

require("../private/secure.php");
require_once("../private/db_config.php");
/* include("debug.php"); */
session_start();

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
    <title> Credits - Service Records </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" media="all" href="./stylesheets/charts.min.css" />
    <link rel="stylesheet" media="all" href="./stylesheets/phpvariables.php" />
    <link rel="stylesheet" media="all" href="./stylesheets/dashboard.css?v=1" />
    <link rel="stylesheet" media="all" href="./stylesheets/credits.css" />
    <!-- Map Libre -->
    <script src='https://unpkg.com/maplibre-gl@2.4.0/dist/maplibre-gl.js'></script>
    <link href='https://unpkg.com/maplibre-gl@2.4.0/dist/maplibre-gl.css' rel='stylesheet' />

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <header>
    <?php include("../private/shared/navigation.php"); ?>
    
        <div class="parent">
            <div class="leftborder"></div>
            <div class="rightborder"></div>

            <div class="mainbody">
                <p><h4> Admin and Credits </h4></p>
                <table>
                    <tr>
                        <td>
                            <a href="https://arbhie.com" target="_blank">
                            <img src="../img/arbhieLOGO.png"></a>
                        </td>
                        <td colspan="5" width="80%">
                            <p>
                                <strong> [Full-stack] Raymond Hernandez </strong><br> raymond@arbhie.com
                            </p>
                        </td>
                    </tr>
                    
                    <tr>
                        <td>
                            <a href="https://appsbycarla.com" target="_blank">
                            <img src="../img/appsbycarla_logo.png"></a>
                        </td>
                        <td colspan="5" width="80%">
                            <p>
                                <strong> [Front-end] Carla Ramos </strong><br> carla@appsbycarla.com
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <a href="https://gudeprojects.be" target="_blank">
                            <img src="../img/gudeprojects.gif"></a>
                        </td>
                        <td colspan="5" width="80%">
                            <p>
                                <strong> Gude Projects </strong><br> gudeprojects.be
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <a href="https://www.pexels.com/photo/white-blue-and-gray-concrete-building-164338/" target="_blank">
                            <img src="https://images.pexels.com/photos/164338/pexels-photo-164338.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1"></a>
                        </td>
                        <td colspan="5" width="80%">
                            <p>
                                <strong> Background Picture </strong><br> pexels.com/@pixabay
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <a href="https://cssgrid-generator.netlify.app/" target="_blank">
                            <img src="../img/css-grid.png"></a>
                        </td>
                        <td colspan="5" width="80%">
                            <p>
                                <strong> CSS Grid Generator </strong><br> cssgrid-generator.netlify.app
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <a href="https://www.flaticon.com/free-icons/free" target="_blank">
                            <img src="https://mediablog.cdnpk.net/sites/5/2021/12/Flaticon-Rediseno-Logo-Presentacion_Mesa-de-trabajo-1-copia-20.jpg"></a>
                        </td>
                        <td colspan="5" width="80%">
                            <p>
                                <strong> Icons </strong><br> flaticon.com
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <a href="https://chartscss.org/" target="_blank">
                            <img src="https://chartscss.org/assets/img/logo-animation.svg"></a>
                        </td>
                        <td colspan="5" width="80%">
                            <p>
                                <strong> CSS data visualization framework </strong><br> chartscss.org
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <a href="https://getbootstrap.com/" target="_blank">
                            <img src="https://getbootstrap.com/docs/5.3/assets/brand/bootstrap-logo-shadow.png"></a>
                        </td>
                        <td colspan="5" width="80%">
                            <p>
                                <strong> Frontend toolkit </strong><br> getbootstrap.com
                            </p>
                        </td>
                    </tr>

                </table>
                <br>
                <br>
                <br>
                <br>
                <br>
            </div>

            <div class="footer">
                <?php include("../private/shared/footer.php"); ?>
            </div>

        </div> <!-- Parent -->
    </header>   

</body>
</html>

<script>
    var coll = document.getElementsByClassName("collapsible");
    var i;

    for (i = 0; i < coll.length; i++) {
        coll[i].addEventListener("click", function() {
            this.classList.toggle("active");
            var content = this.nextElementSibling;
            if (content.style.display === "block") {
                content.style.display = "none";
            } else {
                content.style.display = "block";
            }
        });
    }
</script>