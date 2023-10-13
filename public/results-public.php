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

// require ( "../private/secure.php" );
include ( "debug.php" );

?>

<!DOCTYPE html>
<html lang="en">

<head>    
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title> One Search Results (Public Version) - Khronos Pro 2 </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" media="all" href="./stylesheets/charts.min.css" />
    <link rel="stylesheet" media="all" href="./stylesheets/phpvariables.php" />
    <link rel="stylesheet" media="all" href="./stylesheets/dashboard.css" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <header>
        <div style="text-align:center">
            <div class="row mb-4 mb-lg-5">
                <div class="col-md-8 col-xl-6 text-center mx-auto">
                    <!-- <img id="image_logo" src="assets/img/alba-helperLOGO.png"> -->
                    <h4 class="fw-bold" id="title_bookmarks"> Search Results</h4>
                </div>
            </div>

            <?php

            $street = $_GET['street'];
            $city   = $_GET['city'];
            $state  = $_GET['state'];
            
            ?>

            <!-- ***************************************************************** -->
            <!--                     FastPeopleSearch(fps) API                     -->
            <!-- ***************************************************************** -->

            <?php

            if ( isset ( $_GET['fps'] ) && $_GET['fps'] == 'yes' ) {
                function format_for_fastpeoplesearch( $street, $city ) {
                    $street = strtolower ( $street ); // convert to lowercase
                    $street = preg_replace ( '/[^a-z0-9]+/', '-', $street ); // replace non-alphanumeric characters with a dash
                    $city   = strtolower ( $city ); // convert to lowercase
                    $city   = preg_replace ( '/[^a-z0-9]+/', '-', $city ); // replace non-alphanumeric characters with a dash
                    return $street . '_' . $city;
                }

                $url_for_fastpeoplesearch = 'https://www.fastpeoplesearch.com/address/';
                $query  = $url_for_fastpeoplesearch; 
                $query .= format_for_fastpeoplesearch ( $street, $city ); 
                $query .= '-' . $state;
                
                ?>

                <script>
                    window.open ( "<?php echo $query; ?>", "_blank" );
                </script>
                <a id="results" href="<?php echo $query; ?>" target="_blank">View Results from FastPeopleSearch.com</a><br><br>
                
                <?php

                } 

            ?>
            
            <!-- ***************************************************************** -->
            <!--                     SearchPeopleFree(spf) API                     -->
            <!-- ***************************************************************** -->

            <?php

            if ( isset ( $_GET['spf'] ) && $_GET['spf'] == 'yes' ) {
                function format_for_searchpeoplefree ( $street, $city ) {
                    $parts = explode(' ', $street);
                    $street_number = array_shift($parts);
                    $street = implode('-', $parts);
                    $city = str_replace(' ', '-', $city);
                    return strtolower($city) . '/' . strtolower($street) . '/' . $street_number;
                }

                $url_for_searchpeoplefree = 'https://www.searchpeoplefree.com/address/';
                $query  = $url_for_searchpeoplefree . $state . '/'; 
                $query .= format_for_searchpeoplefree ( $street, $city ); 

                ?>

                <script>
                    window.open ( "<?php echo $query; ?>", "_blank" );
                </script>
                <a id="results" href="<?php echo $query; ?>" target="_blank">View Results from SearchPeopleFree.com</a><br><br>

                <?php

                } 

            ?>
            
            <!-- ***************************************************************** -->
            <!--                          411 API                                  -->
            <!-- ***************************************************************** -->

            <?php

            if ( isset ( $_GET['411'] ) && $_GET['411'] == 'yes' ) {
                function format_for_411 ( $street, $city ) {
                    $parts = explode(' ', $street);
                    $street_number = array_shift($parts);
                    $street = implode('-', $parts);
                    $city = str_replace(' ', '-', $city);
                    return $street_number . '-' . strtolower ( $street ) . '/' . strtolower ( $city ) . '-';
                }

                $url_for_411 = 'https://www.411.com/address/';
                $query  = $url_for_411; 
                $query .= format_for_411 ( $street, $city ) . $state; 

                ?>

                <script>
                    window.open ( "<?php echo $query; ?>", "_blank" );
                </script>
                <a id="results" href="<?php echo $query; ?>" target="_blank">View Results from 411.com</a><br><br>

                <?php

                } 

            ?>

            <!-- ***************************************************************** -->
            <!--                     WhitePages(wps) API                           -->
            <!-- ***************************************************************** -->

            <?php

            if ( isset ( $_GET['wps'] ) && $_GET['wps'] == 'yes' ) {
                function format_for_whitepages ( $street, $city ) {
                    $parts = explode(' ', $street);
                    $street_number = array_shift($parts);
                    $street = implode('-', $parts);
                    $city = str_replace(' ', '-', $city);
                    return $street_number . '-' . strtolower ( $street ) . '/' . strtolower ( $city ) . '-';
                }

                $url_for_whitepages = 'https://www.whitepages.com/address/';
                $query  = $url_for_whitepages; 
                $query .= format_for_whitepages ( $street, $city ) . $state; 

                ?>

                <script>
                    window.open ( "<?php echo $query; ?>", "_blank" );
                </script>
                <a id="results" href="<?php echo $query; ?>" target="_blank">View Results from WhitePages.com</a><br><br>

                <?php

                } 

            ?>
            
            <!-- ***************************************************************** -->
            <!--                     That'sThem(tht) API                           -->
            <!-- ***************************************************************** -->

            <?php

            if ( isset ( $_GET['tht'] ) && $_GET['tht'] == 'yes' ) {
                function format_for_thatsthem( $street, $city ) {
                    $street = strtolower ( $street ); // convert to lowercase
                    $street = preg_replace ( '/[^a-z0-9]+/', '-', $street ); // replace non-alphanumeric characters with a dash
                    $city   = strtolower ( $city ); // convert to lowercase
                    $city   = preg_replace ( '/[^a-z0-9]+/', '-', $city ); // replace non-alphanumeric characters with a dash
                    return $street . '-' . $city;
                }

                $url_for_thatsthem = 'https://thatsthem.com/address/';
                $query  = $url_for_thatsthem; 
                $query .= format_for_thatsthem ( $street, $city ); 
                $query .= '-' . $state;

                ?>

                <script>
                    window.open ( "<?php echo $query; ?>", "_blank" );
                </script>
                <a id="results" href="<?php echo $query; ?>" target="_blank">View Results from ThatsThem.com</a><br><br>
                
                <?php

                } 

            ?>
            
            <!-- ***************************************************************** -->
            <!--                 TruePeopleSearch(tps) API                         -->
            <!-- ***************************************************************** -->

            <?php

            if ( isset ( $_GET['tps'] ) && $_GET['tps'] == 'yes' ) {
                function format_for_truepeoplesearch ( $street, $city ) {
                    $street = urlencode ( $street );
                    $city   = urlencode ( $city );
                    return "streetaddress=$street&citystatezip=$city";
                }

                $url_for_truepeoplesearch = 'https://www.truepeoplesearch.com/resultaddress?';
                $query  = $url_for_truepeoplesearch; 
                $query .= format_for_truepeoplesearch ( $street, $city ); 
                $query .= '+' . $state;

                ?>

                <script>
                    window.open ( "<?php echo $query; ?>", "_blank" );
                </script>
                <a id="results" href="<?php echo $query; ?>" target="_blank">View Results from TruePeopleSearch.com</a><br><br>

                <?php

                } 

            ?>
            
            <!-- ***************************************************************** -->
            <!--                 SmartBackgroundChecks(sbc) API                    -->
            <!-- ***************************************************************** -->

            <?php

            if ( isset ( $_GET['sbc'] ) && $_GET['sbc'] == 'yes' ) {
                function format_for_smartbackgroundchecks ( $street, $city ) {
                    $street = strtolower ( $street ); // convert to lowercase
                    $street = preg_replace ( '/[^a-z0-9]+/', '-', $street ); // replace non-alphanumeric characters with a dash
                    $city   = strtolower ( $city ); // convert to lowercase
                    $city   = preg_replace ( '/[^a-z0-9]+/', '-', $city ); // replace non-alphanumeric characters with a dash
                    return  '/' .$street . '/' . $city;
                }

                $url_for_smartbackgroundchecks = 'https://www.smartbackgroundchecks.com/address-search';
                $query  = $url_for_smartbackgroundchecks; 
                $query .= format_for_smartbackgroundchecks ( $street, $city ); 
                $query .= '/' . $state;

                ?>

                <script>
                    window.open ( "<?php echo $query; ?>", "_blank" );
                </script>
                <a id="results" href="<?php echo $query; ?>" target="_blank">View Results from SmartBackgroundChecks.com</a><br><br>

                <?php

                } 

            ?>
        
        </div>
        
        <div>
            <?php include ( "../private/shared/footer.php" ); ?>
        </div>

        </div> 
    </header>   

</body>
</html>
