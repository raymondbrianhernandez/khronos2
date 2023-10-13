<!--
██╗  ██╗██╗  ██╗██████╗  ██████╗ ███╗   ██╗ ██████╗ ███████╗    ██████╗     ██████╗ 
██║ ██╔╝██║  ██║██╔══██╗██╔═══██╗████╗  ██║██╔═══██╗██╔════╝    ╚════██╗   ██╔═████╗
█████╔╝ ███████║██████╔╝██║   ██║██╔██╗ ██║██║   ██║███████╗     █████╔╝   ██║██╔██║
██╔═██╗ ██╔══██║██╔══██╗██║   ██║██║╚██╗██║██║   ██║╚════██║    ██╔═══╝    ████╔╝██║
██║  ██╗██║  ██║██║  ██║╚██████╔╝██║ ╚████║╚██████╔╝███████║    ███████╗██╗╚██████╔╝
╚═╝  ╚═╝╚═╝  ╚═╝╚═╝  ╚═╝ ╚═════╝ ╚═╝  ╚═══╝ ╚═════╝ ╚══════╝    ╚══════╝╚═╝ ╚═════╝ 
June 7, 2023
Raymond Brian D. Hernandez 
Carla Regine R. Hernandez
-->

<?php

include ( "debug.php" );

?>

<!DOCTYPE html>
<html lang="en">

<head>    
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title> One Search (Public Version) - Khronos Pro 2 </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" media="all" href="./stylesheets/charts.min.css" />
    <link rel="stylesheet" media="all" href="./stylesheets/phpvariables.php" />
    <link rel="stylesheet" media="all" href="./stylesheets/dashboard.css" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <header>
        <!-- < ?php include ( "../private/shared/navigation.php" ); ?> -->

        <div style="display: flex; flex-direction: column; align-items: center; justify-content: center;">
            <p></p>
            <h4><b>Telephone Witnessing One Search Tool</b></h4>
            <b>This is the Public Version - some features are hidden.  <a href="login">Login</a> to access all features.</b>
            <p>Search many reverse directories with one click using this tool.</p>
        </div>

    
        <!-- ***************************************************************** -->
        <!--                         AGAPE SEARCH                              -->
        <!-- ***************************************************************** -->
        <div style="text-align:center; max-width: 500px; margin: 0 auto;" id="search_area">
            <form action="results-public.php" method="get" id="search_form">
                <input type="text" name="street" placeholder="Street Address" style="margin-bottom: 20px;">
                <input type="text" name="city" placeholder="City" style="margin-bottom: 20px;">
                <select name="state">
                    <option value="CA">California</option>
                    <option value="AL">Alabama</option>
                    <option value="AK">Alaska</option>
                    <option value="AZ">Arizona</option>
                    <option value="AR">Arkansas</option>
                    <option value="CO">Colorado</option>
                    <option value="CT">Connecticut</option>
                    <option value="DE">Delaware</option>
                    <option value="DC">District Of Columbia</option>
                    <option value="FL">Florida</option>
                    <option value="GA">Georgia</option>
                    <option value="HI">Hawaii</option>
                    <option value="ID">Idaho</option>
                    <option value="IL">Illinois</option>
                    <option value="IN">Indiana</option>
                    <option value="IA">Iowa</option>
                    <option value="KS">Kansas</option>
                    <option value="KY">Kentucky</option>
                    <option value="LA">Louisiana</option>
                    <option value="ME">Maine</option>
                    <option value="MD">Maryland</option>
                    <option value="MA">Massachusetts</option>
                    <option value="MI">Michigan</option>
                    <option value="MN">Minnesota</option>
                    <option value="MS">Mississippi</option>
                    <option value="MO">Missouri</option>
                    <option value="MT">Montana</option>
                    <option value="NE">Nebraska</option>
                    <option value="NV">Nevada</option>
                    <option value="NH">New Hampshire</option>
                    <option value="NJ">New Jersey</option>
                    <option value="NM">New Mexico</option>
                    <option value="NY">New York</option>
                    <option value="NC">North Carolina</option>
                    <option value="ND">North Dakota</option>
                    <option value="OH">Ohio</option>
                    <option value="OK">Oklahoma</option>
                    <option value="OR">Oregon</option>
                    <option value="PA">Pennsylvania</option>
                    <option value="RI">Rhode Island</option>
                    <option value="SC">South Carolina</option>
                    <option value="SD">South Dakota</option>
                    <option value="TN">Tennessee</option>
                    <option value="TX">Texas</option>
                    <option value="UT">Utah</option>
                    <option value="VT">Vermont</option>
                    <option value="VA">Virginia</option>
                    <option value="WA">Washington</option>
                    <option value="WV">West Virginia</option>
                    <option value="WI">Wisconsin</option>
                    <option value="WY">Wyoming</option>
                </select>
                <br><br>
                <b><u>Choose a search site:</u></b><br>
                <b>
                <input type="checkbox" name="fps" value="yes" id="searchsites" checked> FastPeopleSearch.com      <br>
                <input type="checkbox" name="spf" value="yes" id="searchsites" checked> SearchPeopleFree.com      <br>
                <input type="checkbox" name="411" value="yes" id="searchsites" checked> 411.com                   <br>
                <input type="checkbox" name="wps" value="yes" id="searchsites" checked> WhitePages.com            <br>
                <input type="checkbox" name="tht" value="yes" id="searchsites" checked> ThatsThem.com             <br>
                <input type="checkbox" name="tps" value="yes" id="searchsites" checked> TruePeopleSearch.com      <br>
                <input type="checkbox" name="sbc" value="yes" id="searchsites" checked> SmartBackgroundCheck.com  <br>
                </b>
            </form>
            <hr>
            <button id="check_all" style="color: black;">Check All</button>
            <button id="uncheck_all" style="color: black;">Uncheck All</button>
            <br><br>
            </form>
            <input type="submit" value="Search from Selected Sites" id="submit_button">

            <script>
                document.getElementById("check_all").addEventListener("click", function() {
                    var checkboxes = document.querySelectorAll('input[type="checkbox"]');
                    for (var i = 0; i < checkboxes.length; i++) {
                        checkboxes[i].checked = true;
                    }
                });

                document.getElementById("uncheck_all").addEventListener("click", function() {
                    var checkboxes = document.querySelectorAll('input[type="checkbox"]');
                    for (var i = 0; i < checkboxes.length; i++) {
                        checkboxes[i].checked = false;
                    }
                });

                document.getElementById("submit_button").addEventListener("click", function(event) {
                    event.preventDefault();
                    
                    var street = document.getElementsByName("street")[0].value;
                    var city = document.getElementsByName("city")[0].value;

                    if (!street || !city) {
                        alert("Please fill out all required fields.");
                        return; // exit the function without submitting the form
                    }

                    document.getElementById("search_form").submit();
                });

            </script>
        </div>
        <!-- ***************************************************************** -->

        <div>
            <?php include ( "../private/shared/footer.php" ); ?>
        </div>

        </div> 
    </header>   

</body>
</html>