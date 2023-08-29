<!-- Start: Navbar Right Links (Dark) -->
<nav class="navbar navbar-dark navbar-expand-md bg-dark py-3">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="dashboard.php">
            <img src="../img/khronos.gif" alt="logo" height="100px">
            <!-- <span class="bs-icon-sm bs-icon-rounded bs-icon-primary d-flex justify-content-center align-items-center me-2 bs-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="1em" height="1em" fill="currentColor">
                    <path d="M384 0H96C60.65 0 32 28.65 32 64v384c0 35.35 28.65 64 64 64h288c35.35 0 64-28.65 64-64V64C448 28.65 419.3 0 384 0zM240 128c35.35 0 64 28.65 64 64s-28.65 64-64 64c-35.34 0-64-28.65-64-64S204.7 128 240 128zM336 384h-192C135.2 384 128 376.8 128 368C128 323.8 163.8 288 208 288h64c44.18 0 80 35.82 80 80C352 376.8 344.8 384 336 384zM496 64H480v96h16C504.8 160 512 152.8 512 144v-64C512 71.16 504.8 64 496 64zM496 192H480v96h16C504.8 288 512 280.8 512 272v-64C512 199.2 504.8 192 496 192zM496 320H480v96h16c8.836 0 16-7.164 16-16v-64C512 327.2 504.8 320 496 320z"></path>
                </svg>
            </span> -->
            
            <span> Khro'nos Pro 2 </span>
        </a>
        <button data-bs-toggle="collapse" class="navbar-toggler" data-bs-target="#navcol-5">
            <span class="visually-hidden"> Toggle navigation </span>
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navcol-5">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link active" href="dashboard"> Dashboard </a></li>
                
                <!-- Dropdown for Resources -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarResourcesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Field Ministry
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarResourcesDropdown">
                        <li><a class="dropdown-item" href="../public/territories">Territories</a></li>
                        <li><a class="dropdown-item" href="../public/addresses">Address Book</a></li>
                        <li><a class="dropdown-item" href="../public/one-search">One Search</a></li>
                        <li><a class="dropdown-item" href="../public/hours">Reports</a></li>
                    </ul>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarResourcesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        KH Meetings
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarResourcesDropdown">
                        <li><a class="dropdown-item" href="../tms-manager/tms-admin"> Our Christian Life and Ministry Manager </a></li>
                        <li><a class="dropdown-item" href="../public/assignments">Assignments</a></li>
                        <li><a class="dropdown-item" href="../public/journal">Notebook</a></li>
                        
                    </ul>
                </li>
                
                <li class="nav-item"><a class="nav-link active" href="javascript:void(0);" onclick="openAboutUsWindow()"> About </a></li>
                <li class="nav-item"><a class="nav-link active" href="../public/logout"> Sign out </a></li>
            </ul>
        </div>

        <div style="position: absolute; left: 10; bottom: 0; color: white;">
            <?php include ('../public/user.php'); ?>
        </div>
    </div>
</nav>
<!-- End: Navbar Right Links (Dark) -->

<script>
    function openDonationWindow() {
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