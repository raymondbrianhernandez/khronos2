<!-- Start: Navbar Right Links (Dark) -->
<nav class="navbar navbar-dark navbar-expand-md bg-dark py-3">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="dashboard.php">
            <img src="../img/khronos.gif" alt="logo" height="100px">
            <span> Khro'nos Pro 2 </span>
        </a>
        <button data-bs-toggle="collapse" class="navbar-toggler" data-bs-target="#navcol-5">
            <span class="visually-hidden"> Toggle navigation </span>
            <span class="navbar-toggler-icon"></span>
        </button>

        <style>
           .coming-soon {
                color: red;
                font-size: 10pt;
                font-weight: bold;
            }
            .almost-complete {
                color: green;
                font-size: 10pt;
                font-weight: bold;
            } 
        </style>
        
        <div class="collapse navbar-collapse" id="navcol-5">
            <ul class="navbar-nav ms-auto" style="margin-bottom: 10px;">
                <li class="nav-item"><a class="nav-link active" href="dashboard"> Dashboard </a></li>
                
                <!-- Dropdown for Resources -->
                <li class="nav-item dropdown">
                    <a class="nav-link active dropdown-toggle" href="#" id="navbarResourcesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Field Ministry
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarResourcesDropdown">
                        <li><a class="dropdown-item" href="../public/masterlist">Master Territory <span class="almost-complete">(Almost Complete)</span></a></li>
                        <li><a class="dropdown-item" href="../public/territories">House to House Records </a></li>
                        <li><a class="dropdown-item" href="../public/onesearch">One Search</a></li>
                        <li><a class="dropdown-item" href="../public/hours">Service Reports</a></li>
                        <!-- <li><a class="dropdown-item" href="../public/alba">CSV Converter for Alba</a></li> -->
                    </ul>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link active dropdown-toggle" href="#" id="navbarResourcesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        KH Meetings
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarResourcesDropdown">
                         </a></li>
                        <li><a class="dropdown-item" href="../tms-manager/tms-admin"> Our Christian Life and Ministry Manager </a></li>
                        <li><a class="dropdown-item" href="../publictalk/pt-manager"> Public Talk Manager <span class="coming-soon">(Coming Soon)</span>
                        <li><a class="dropdown-item" href="../public/assignments">My Assignments <span class="coming-soon">(Coming Soon)</span></a></li>
                        <li><a class="dropdown-item" href="">Study Tools <span class="coming-soon">(Coming Soon)</span></a></li>
                        <li><a class="dropdown-item" href="../public/journal">Notebook</a></li>
                        
                    </ul>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link active dropdown-toggle" href="#" id="navbarResourcesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Fun Stuffs
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarResourcesDropdown">
                        <li><a target="_blank" class="dropdown-item" href="https://arbhie.com/projects/bible-game/"> Logikos Trivia Game </a></li>
                        <li><a target="_blank" class="dropdown-item" href="../public/emoji-game"> Bible Emoji Flashcards </a></li>
                        <li><a target="_blank" class="dropdown-item" href=""> Guitar/Piano Chords <span class="coming-soon">(Coming Soon)</span> </a></li>
                        <li><a target="_blank" class="dropdown-item" href=""> Game Ideas <span class="coming-soon">(Coming Soon)</span> </a></li>
                    </ul>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link active dropdown-toggle" href="#" id="navbarResourcesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Support 
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarResourcesDropdown">
                        <li><a class="dropdown-item" href="javascript:void(0);" onclick="openAboutUsWindow()"> About Khronos Pro 2 </a></li>
                        <li><a class="dropdown-item" href="javascript:void(0);" onclick="openContactUsWindow()"> Contact Us </a></li>
                        <li><a class="dropdown-item" href="javascript:void(0);" onclick="openDonateWindow()"> Donate/Volunteer </a></li>
                        <li><a class="dropdown-item" href="javascript:void(0);" onclick="openCreditsWindow()"> Credits </a></li>
                    </ul>
                </li>
                
                <li class="nav-item"><a class="nav-link active" href="../public/logout"> Sign out </a></li>
            </ul>
        </div>

        <div style="position: absolute; left: auto; bottom: 0; color: white;">
            <?php include ('../public/user.php'); ?>
        </div>
    </div>
</nav> 
<!-- End: Navbar Right Links (Dark) -->

<script>
    function openDonateWindow() {
      var url = "../public/donate";
      var width = 600;
      var height = 400;
      
      // Open the new window with specified width and height
      var newWindow = window.open ( url, "_blank", "width=" + width + ",height=" + height );
      
      // Focus the new window (optional)
      if ( newWindow ) {
        newWindow.focus(); 
      }
    }
</script>
<script>
    function openAboutUsWindow() {
      var url = "../public/about";
      var width = 600;
      var height = 400;
      
      // Open the new window with specified width and height
      var newWindow = window.open ( url, "_blank", "width=" + width + ",height=" + height );
      
      // Focus the new window (optional)
      if ( newWindow ) {
        newWindow.focus();
      }
    }
</script>
<script>
    function openContactUsWindow() {
      var url = "../public/contact-us";
      var width = 600;
      var height = 400;
      
      // Open the new window with specified width and height
      var newWindow = window.open ( url, "_blank", "width=" + width + ",height=" + height );
      
      // Focus the new window (optional)
      if ( newWindow ) {
        newWindow.focus(); 
      }
    }
</script>
<script>
    function openCreditsWindow() {
      var url = "../public/credits";
      var width = 600;
      var height = 400;
      
      // Open the new window with specified width and height
      var newWindow = window.open ( url, "_blank", "width=" + width + ",height=" + height );
      
      // Focus the new window (optional)
      if ( newWindow ) {
        newWindow.focus();
      }
    }
</script>