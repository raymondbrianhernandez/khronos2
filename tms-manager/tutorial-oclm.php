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

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
    <title>OCLM Manager Tutorial - Khronos Pro 2</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" media="all" href="./stylesheets/styles.min.css"/>
    <link rel="stylesheet" media="all" href="tutorial_styles.css"/>
</head>

<body>

<header>
    <!-- Start: Navbar Right Links (Dark) -->
    <nav class="navbar navbar-dark navbar-expand-md bg-dark py-3">
        <div class="container">
            <img src="../img/khronos.gif" alt="logo" height="100px">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <span> Khro'nos Pro 2 </span>
            </a>
                <button data-bs-toggle="collapse" class="navbar-toggler" data-bs-target="#navcol-5">
                    <span class="visually-hidden"> Toggle navigation </span>
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navcol-5">
                    <ul class="navbar-nav ms-auto font-weight-bold">
                        <li class="nav-item dropdown">
                            <a class="nav-link active dropdown-toggle" href="#" id="quickLinksDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Quick Links
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="quickLinksDropdown">
                                <!-- Add your quick links here -->
                                <li><a class="dropdown-item" href="../public/onesearch-public" target="_blank"> One Search </a></li>
                                <li><a class="dropdown-item" href="https://arbhie.com/projects/bible-game/" target="_blank"> Logikos Trivia Game </a></li>
                                <li><a class="dropdown-item" href="https://emoji.khronos.pro" target="_blank"> Bible Emoji Flashcards </a></li>
                                <!-- ... -->
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link active dropdown-toggle" href="#" id="quickLinksDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Tutorials
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="quickLinksDropdown">
                                <!-- Add your quick links here -->
                                <li><a class="dropdown-item" href="../tutorials/tutorial-oclm"> Our Christian Life and Ministry Manager </a></li>
                                <li><a class="dropdown-item" href="../tutorials/tutorial-pt"> Public Talk Manager </a></li>
                                <li><a class="dropdown-item" href="../tutorials/tutorial-terr"> Master Territory Manager </a></li>
                                <li><a class="dropdown-item" href="../tutorials/tutorial-hth"> House-to-House Records </a></li>
                                <li><a class="dropdown-item" href="../tutorials/tutorial-msr"> Service Reports </a></li>
                                <li><a class="dropdown-item" href="../tutorials/tutorial-search"> One Search </a></li>
                                <li><a class="dropdown-item" href="../tutorials/tutorial-note"> Notebook </a></li>
                                <!-- ... -->
                            </ul>
                        
                        <li class="nav-item"><a class="nav-link active" href="../public/login"> Login </a></li>
                        <li class="nav-item"><a class="nav-link active" href="../public/registration"> Register </a></li>
                        <li class="nav-item"><a class="nav-link active" href="../public/resetpassword"> Reset Password </a></li>
                        <li class="nav-item"><a class="nav-link active" href="javascript:void(0);" onclick="openAboutUsWindow()"> About </a></li>
                    </ul>
                </div>

        </div>
    </nav>
    <!-- End: Navbar Right Links (Dark) -->
    
    <section class="tutorial">
        <h3>OCML Manager Video Tutorial</h3>

        <!-- YouTube Video Embed -->
        <div class="video-container">
            <iframe width="560" height="315" src="https://www.youtube.com/embed/9288Vhew53o?si=nI996bO7C35mhkZR" title="OCML Manager Tutorial" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
        </div>

        <!-- Step by Step Tutorial -->
        <div class="steps-container" id="toc">
            <h4><b>Our Christian Life & Ministry Manager Features</b></h4>
            
            <div class="table-of-contents">
                <h5><u>Table of Contents</u></h5>
                <ul>
                    <li><a href="#assign">1. Assigning Parts Section</a></li>
                    <li><a href="#manage">2. Managing Publishers</a></li>
                    <li><a href="#statistics">3. Statistics</a></li>
                    <li><a href="#upload">4. Uploading New Workbook</a></li>
                    <li><a href="#privacy">5. Privacy</a></li>
                </ul>
            </div>

            <hr>
            
            <div class="tutorial-step" id="assign">
                <h5><u>1. Assigning Parts Section</u></h5>
                <ol>
                    <li>
                        <p>Choose a week to manage. If the week is not showing, you may need to upload a new JW workbook first.</p>
                        <figure>
                            <img src="../tutorials/images/query_week.png" alt="Query Week" class="tutorial-image">
                            <figcaption>Fig 1.1 - Querying the week</figcaption>
                        </figure>
                    </li>

                    <li>
                        <p>Select the week from the dropdown list.</p>
                        <figure>
                            <img src="../tutorials/images/weeks.png" alt="Available Weeks" class="tutorial-image">
                            <figcaption>Fig 1.2 - Selecting the week from the drop-down list</figcaption>
                        </figure>
                    </li>

                    <li>
                        <p>Set the date and time.</p>
                        <figure>
                            <img src="../tutorials/images/set_datetime.png" alt="Setting date and time" class="tutorial-image">
                            <figcaption>Fig 1.3 - Assigning the date and time of the meeting</figcaption>
                        </figure>
                    </li>
                    
                    <li>
                        <p>Assign the participants for each part. Publishers are arrange by privileges.</p>
                        <figure>
                            <img src="../tutorials/images/assignees.png" alt="Assigning participants" class="tutorial-image">
                            <figcaption>Fig 1.4 - Assigning participants</figcaption>
                        </figure>
                    </li>

                    <li>
                        <p>After choosing the assignees, press "Update Assignments"</p>
                        <figure>
                            <img src="../tutorials/images/update.png" alt="Update Button" class="tutorial-image">
                            <figcaption>Fig 1.5 - Updating the record</figcaption>
                        </figure>
                    </li>
                    
                    <li>
                        <p>To generate print report, query the week again then click "Generate Print Report".</p>
                        <figure>
                            <img src="../tutorials/images/print_report.png" alt="Print Report Button" class="tutorial-image">
                            <figcaption>Fig 1.6 - Generate Print Report button</figcaption>
                        </figure>
                    </li>
                    
                    <li>
                        <p>The print report has several options such as:</p>
                        <ul>
                            <li>
                                View/Hide Complete Parts - Toggles if the overseer wants to display the whole part or just the heading.
                                <figure>
                                    <img src="../tutorials/images/full_part.png" alt="Full Parts" class="tutorial-image">
                                    <figcaption>Fig 1.7a - Full parts shown</figcaption>
                                </figure>
                                <figure>
                                    <img src="../tutorials/images/hide_part.png" alt="Hidden Part" class="tutorial-image">
                                    <figcaption>Fig 1.7b - Just the heading shown</figcaption>
                                </figure>
                            </li>

                            <li>
                                Save as .docx - creates a document compatible with Microsoft Word and Google Docs
                                <figure>
                                    <img src="../tutorials/images/doc.png" alt=".docx Document" class="tutorial-image">
                                    <figcaption>Fig 1.7c - docx Document saved in Downloads folder</figcaption>
                                </figure>

                                <figure>
                                    <img src="../tutorials/images/word.png" alt="Word Document" class="tutorial-image">
                                    <figcaption>Fig 1.7d - .docx opened in Microsoft Word</figcaption>
                                </figure>

                                <figure>
                                    <img src="../tutorials/images/gdoc.png" alt="Word Document" class="tutorial-image">
                                    <figcaption>Fig 1.7e - .docx opened in Google Docs</figcaption>
                                </figure>
                                
                            </li>

                            <li>
                                View as RAW - view the raw data from the server.
                                <figure>
                                    <img src="../tutorials/images/raw.png" alt="Raw data" class="tutorial-image">
                                    <figcaption>Fig 1.7f - Raw data for debugging</figcaption>
                                </figure>
                            </li>
                            
                        </ul>
                        <figure>
                            <img src="../tutorials/images/report.png" alt="Print Report Button" class="tutorial-image">
                            <figcaption>Fig 1.7g - Print Preview of the report</figcaption>
                        </figure>
                        
                    </li>
                </ol>
                <a href="#toc">Back to Table of Contents</a>
            </div>

            <div class="tutorial-step" id="manage">
                <h5>2. Managing Publishers</h5>
                <ol>
                    <li>
                        <p>With "Manage Publishers" the overseer can add, delete, or edit participant's names and information</p>
                        <figure>
                            <img src="../tutorials/images/publishers.png" alt=" Managing the participant's database" class="tutorial-image">
                            <figcaption>Fig 2.1 - Managing the participant's database.</figcaption>
                        </figure>
                        <figure>
                            <img src="../tutorials/images/edit.png" alt="Editing participant's information" class="tutorial-image">
                            <figcaption>Fig 2.2 - Editing participant's information (change privilege if needed).</figcaption>
                        </figure>
                        <figure>
                            <img src="../tutorials/images/delete.png" alt="Deleting" class="tutorial-image">
                            <figcaption>Fig 2.3 - Deleting the participant's name.</figcaption>
                        </figure>
                    </li>

                    <li>
                        <p>If the participant is not on the list yet, use the "Add Record" to enter new entry.</p>
                        <figure>
                            <img src="../tutorials/images/add_record.png" alt="Adding a new participant" class="tutorial-image">
                            <figcaption>Fig 2.4 - Adding a new participant</figcaption>
                        </figure>
                    </li>

                </ol>
                <a href="#toc">Back to Table of Contents</a>
            </div>

            <div class="tutorial-step" id="statistics">
                <h5>3. Statistics</h5>
                <ol>
                    <li>
                        <p>With "Statistics" the overseer can oversee the assignment's distribution for the whole year</p>
                        <figure>
                            <img src="../tutorials/images/statistics.png" alt="Query Week" class="tutorial-image">
                            <figcaption>Fig 3.1 - Assignment's distribution for the year.</figcaption>
                        </figure>
                    </li>
                </ol>
                <a href="#toc">Back to Table of Contents</a>
            </div>

            <div class="tutorial-step" id="upload">
                <h5>4. Uploading New Workbook</h5>
                <ol>
                    <li>
                        <p>If a new workbook has been released, the overseer can paste the link and 
                            copy the data to prepare the next assignments.</p>
                        <figure>
                            <img src="../tutorials/images/upload.png" alt="Assignment's distribution for the year" class="tutorial-image">
                            <figcaption>Fig 4.1 - Upload area for new workbooks.</figcaption>
                        </figure>
                    </li>

                    <li>
                        <p>Navigate to the <a href="https://www.jw.org/en/library/jw-meeting-workbook/" target="_blank">JW Workbook</a>, 
                            choose the month and copy the link.</p>
                        <figure>
                            <img src="../tutorials/images/workbook.png" class="tutorial-image">
                            <figcaption>Fig 4.2 - Available workbooks from jw.org</figcaption>
                        </figure>
                    </li>

                    <li>
                        <p>Choose the month and copy the link.</p>
                        <figure>
                            <img src="../tutorials/images/month_link.png" class="tutorial-image">
                            <figcaption>Fig 4.3 - Link needed to copy.</figcaption>
                        </figure>
                    </li>

                    <li>
                        <p>Paste the link and click "Fetch and Parse Data". Please note that depending on your internet connection, 
                            the copy process might be slow, so please wait till everything is loaded.</p>
                        <figure>
                            <img src="../tutorials/images/pasted_link.png" class="tutorial-image">
                            <figcaption>Fig 4.4 - Link ready to be copied.</figcaption>
                        </figure>
                    </li>
                </ol>
                <a href="#toc">Back to Table of Contents</a>
            </div>

            <div class="tutorial-step" id="privacy">
                <h5>5. Privacy</h5>
                <ol>
                    <li>
                        <p>The OCLM Manager is only available for the Overseers and their assistants, 
                            so for publishers using the app they can only view their assigned parts and nothing else.</p>
                        <figure>
                            <img src="../tutorials/images/reminder.png" class="tutorial-image">
                            <figcaption>Fig 5.1 - Parts reminder.</figcaption>
                        </figure>

                        <figure>
                            <img src="../tutorials/images/public_view.png" class="tutorial-image">
                            <figcaption>Fig 5.2 - Public view if not an overseer.</figcaption>
                        </figure>
                    </li>
                </ol>
                <a href="#toc">Back to Table of Contents</a>
            </div>

            <!-- You can continue adding steps as necessary -->

        </div>

    </section>
</header>


<footer>
    <!-- Start: Footer Basic -->
    <footer class="text-center">
        <div class="container  py-4 py-lg-5">
            <p class="mb-0" style="color: black;">
                &copy; <?php echo '2022 - ' . date('Y'); ?> Khronos Pro 2 by 
                <a href="https://gudeprojects.be" target="_blank" style="color: black;"> GudeProjects </a>
            </p>
        </div>
    </footer>
    <!-- End: Footer Basic -->
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
function openDonationWindow() {
    var url = "donate";
    var width = 600;
    var height = 400;
    
    // Open the new window with specified width and height
    var newWindow = window.open ( url, "_blank", "width=" + width + ",height=" + height );
    
    // Focus the new window (optional)
    if ( newWindow ) {
    newWindow.focus();
    }
} 

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

</body>
</html>