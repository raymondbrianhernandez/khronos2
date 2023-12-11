<div class="row d-flex justify-content-center">
    <!-- SERVICE RECORDS -->
    <h4><b> Service Reports Summary for <?php echo date ( 'F Y' ) ?></b></h4>    
    
    <!-- MY GOAL -->
    <div class="col-md-6 col-xl-3 mb-4">
        <div class="card shadow border-start-primary py-2">
            <div class="card-body">
                <div class="row align-items-center no-gutters">
                    <div class="col me-2">
                        <div class="text-uppercase text-primary fw-bold text-xs mb-1">
                            <span> My Task/Goal </span>
                        </div>
                        <div class="text-dark fw-bold h5 mb-0">
                            <span> <?= $_SESSION['goal'] ?> </span>
                        </div>
                        <div>
                        <span> Change goal from the <a href="dashboard.php#update-info"> account settings </a></span>
                        </div>
                        
                    </div>
                    <div class="col-auto"><img src="../img/goal.png" width="30px"></img></div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- CURRENT HOURS -->
    <div class="col-md-6 col-xl-3 mb-4">
        <div class="card shadow border-start-primary py-2">
            <div class="card-body">
                <div class="row align-items-center no-gutters">
                    <div class="col me-2">
                        <div class="text-uppercase text-primary fw-bold text-xs mb-1"><span> Year-to-date Hours</span></div>
                        <div class="text-dark fw-bold h5 mb-0"><span> <?= $_SESSION['ytd'] ?> </span></div>
                        <div class="text-uppercase text-primary fw-bold text-xs mb-1"><span> Current Hours This Month </span></div>
                        <div class="text-dark fw-bold h5 mb-0"><span> <?=  $_SESSION['curr_hrs'] ?> </span></div>
                    </div>
                    <div class="col-auto"><img src="../img/clock.png" width="30px"></img></div>
                </div>
            </div>
        </div>
    </div>
    
    <p style="text-align:center;">
        View more at <a href="hours">Service Records</a> Page
    </p>
    <!-- END SERVICE RECORDS -->

    <hr>

    <!-- QUICK CLOCK-IN -->
    <h4><b> Quick Clock-in / Clock-out </b></h4>  
    <div class="col-md-6 col-xl-3 mb-4">
        <div class="card shadow border-start-primary py-2">
            <div class="card-body">
                <div class="row align-items-center no-gutters">
                    <div class="col me-2">
                        <div class="text-uppercase text-primary fw-bold text-xs mb-1"><span> Service Timer </span></div>
                        <div>
                            <?php include ( 'calculate-time-v2.php' ); ?>
                        </div>
                    </div>
                    <!-- <div class="col-auto"><img src="../img/stop-watch.png" width="30px"></img></div> -->
                </div>
            </div>
        </div>
    </div>

    <hr>

    <!-- UPCOMING ASSIGNMENTS -->
    <div style="display: flex; align-items: center; justify-content: center;">
        <h4 style="margin-right: 10px;"><b>Assignments</b></h4>
        <img src="../img/assignment.png" style="width: 3%">
    </div>

    <div class="col-md-6 col-xl-3 mb-4">
        <div class="card shadow border-start-primary py-2">
            <div class="card-body">
                <div class="row align-items-center no-gutters">
                    <div>
                        <?php include ( '../tms-manager/assignments.php' ) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <hr>
    
    <!-- PIE CHART -->
    <h4><b> House to House Records Summary </b></h4>    
    <div class="piechart">
        <style>
            .piechart {
                margin-top: 0px;
                display: block;
                width: 200px;
                height: 200px;
                border-bottom: 10px;
                border-radius: 50%;
                box-shadow: 0px 4px 30px rgba(0,0,0,0.2);

                <?php if ( $total == 0 ) { ?>
                    background-image: conic-gradient(
                        purple 0 90deg
                    );
                <?php } else { ?>
                    background-image: conic-gradient(
                        lightblue   <?= ( $newAddr/$total ) * 100 ?>%, 
                        lightgreen  <?= ( $newAddr/$total ) * 100 ?>% <?= ( ( $newAddr + $validAddr ) / $total) * 100 ?>%, 
                        orange      <?= ( ( $newAddr + $validAddr ) / $total ) * 100 ?>% <?= ( ( $newAddr + $validAddr + $invalidAddr) / $total) * 100 ?>%,
                        red         <?= ( ( $newAddr + $validAddr + $invalidAddr ) / $total ) * 100 ?>% <?= ( ( $newAddr + $validAddr + $invalidAddr + $blockedAddr) / $total ) * 100 ?>%
                    );
                <?php } ?>
            }
        </style>    
    </div>
    <div style="text-align:center; padding: 10px">
        <span style="color:lightblue"><b> New: <?php echo $newAddr; ?></b></span><br>
        <span style="color:lightgreen"><b> Valid: <?php echo $validAddr; ?></b> </span><br>
        <span style="color:orange"><b> Invalid: <?php echo $invalidAddr; ?></b></span><br>
        <span style="color:red"><b> Do not call: <?php echo $blockedAddr; ?></b></span><br>
    </div>
    <!-- END PIE CHART -->

    <hr>

    <!-- ACCOUNT INFORMATION -->
    <div style="text-align: center;" id="update-info">
        <button type="button" class="collapsible" style="width: 80%; margin: 0 auto 20px auto; display: block;">
            <h5><b> Click to view/edit your account information </b></h5>
        </button>
        <div class="content" style="width: 85%; margin: 0 auto 20px auto; display: block;">
            <br>
            <form action="account.php" method="post"> 
                <p style="text-align:center"><b> Account Information </b></p>
                <hr>
                <div class="row">
                    <div class="col-25" style="text-align:center">
                        <label for="name"><b> Name: </b></label>
                    </div>
                    <div class="col-75" style="text-align:left">
                        <?= $_SESSION['owner']; ?>
                    </div>
                    <hr>
                    <div class="col-25" style="text-align:center">
                        <label for="name"><b> Username: </b></label>
                    </div>
                    <div class="col-75" style="text-align:left">
                        <?= $_SESSION['username']; ?>
                    </div>
                    <hr>
                    <div class="col-25" style="text-align:center">
                        <label for="name"><b> E-mail: </b></label>
                    </div>
                    <div class="col-75" style="text-align:left">
                        <input type="text" name="email" value=<?= $_SESSION['email']; ?> >
                    </div>
                    <hr>
                    <div class="col-25" style="text-align:center">
                        <label for="name"><b> Congregation: </b></label>
                    </div>
                    <div class="col-75" style="text-align:left">
                        <?= $_SESSION['congregation']; ?>
                        <span style="font-size: 12px; font-style: italic"><br>
                            If you change your congregation, please notify the <a href="javascript:void(0);" onclick="openContactUsWindow()">admins</a>.<br>
                            *<i>Changing congregation can't be changed in Account Settings due to Master Territory and TMS Manager privacy.</i>
                        </span>
                    </div>
                    <hr>
                    <div class="col-25" style="text-align:center">
                        <label for="name"><b> Admin Status: </b></label>
                    </div>
                    <div class="col-75" style="text-align:left">
                        <?php echo empty ( $_SESSION['admin'] ) ? 'User' : $_SESSION['admin']; ?><br>
                        <span style="font-size: 12px; font-style: italic">
                            If you need elevated access for more features, please notify the <a href="javascript:void(0);" onclick="openContactUsWindow()">admins</a>.
                        </span>
                    </div>
                    <hr>
                    <div class="col-25" style="text-align:center">
                        <label for="name"><b> Password: </b></label>
                    </div>
                    <div class="col-75" style="text-align:left">
                        <?php
                        if ( isset ( $_SESSION['demo_mode'] ) && $_SESSION['demo_mode'] == FALSE ) {
                            echo '<a href="javascript:void(0);" onclick="openChangePasswordWindow()">Change Password</a>'; 
                        } else {
                            echo '<i>Password can\'t be changed on demo mode</i>';
                        }
                        ?>
                    </div>
                    <hr>
                    <div class="col-25" style="text-align:center">
                        <label for="name"><b> Current Task / Goal: </b></label>
                    </div>
                    <div class="col-75" style="width:50%">
                        <?php include('goals.php'); ?>
                    </div>
                    <div class="row" style="justify-content:center;">
                        <br>
                            <button id="greenbutton" type="submit" style="width:50%"> Update Changes </button>
                        <br>
                    </div>
                </div>

                <hr>
                
                <p style="text-align:center"><b> Secretary or Group Overseer Contact Information </b></p>
                <div class="row">
                    <div class="col-25">
                        <label for="elder-name"> Overseer's name: </label>
                    </div>
                    <div class="col-75">
                        <input type="text" name="elder_name" value="<?= $_SESSION['elder_name']; ?>" >
                    </div>
                    <div class="col-25">
                        <label for="elder-email"> Overseer's Email: </label>
                    </div>
                    <div class="col-75">
                        <input type="email" name="elder_email" value="<?= $_SESSION['elder_email']; ?>" >
                    </div>
                    <div class="col-25">
                        <label for="elder-phone"> Overseer's Phone: </label>
                    </div>
                    <div class="col-75">
                        <input type="tel" name="elder_phone" value="<?= $_SESSION['elder_phone']; ?>" >
                    </div>
                    <div class="col-25">
                        <label for="carrier"> Phone Carrier: </label>
                    </div>
                    <div class="col-75">
                        <select name="carrier">
                            <option value="" <?= $currentCarrier == '' ? 'selected' : ''; ?>></option>    
                            <option value="@msg.fi.google.com" <?= $currentCarrier == '@msg.fi.google.com' ? 'selected' : ''; ?>>Google Fi</option>
                            <option value="@vtext.com" <?= $currentCarrier == '@vtext.com' ? 'selected' : ''; ?>>Verizon</option>
                            <option value="@txt.att.net" <?= $currentCarrier == '@txt.att.net' ? 'selected' : ''; ?>>AT&T/Cingular</option>
                            <option value="@tmomail.net" <?= $currentCarrier == '@tmomail.net' ? 'selected' : ''; ?>>T-Mobile</option>
                            <option value="@messaging.sprintpcs.com" <?= $currentCarrier == '@messaging.sprintpcs.com' ? 'selected' : ''; ?>>Sprint</option>
                        </select>
                        <p style="color:red;font-size:14px;text-align:left"><b>NOTE:</b><i> Verizon might have delays in SMS messages. </i></p>
                    </div>
                    
                </div>
                
                <div class="row" style="justify-content:center;">
                    <br>
                        <button id="greenbutton" type="submit" style="width:50%"> Update Changes </button>
                    <br>
                </div>

            </form>
            <br>
        </div>
    </div>
    <!-- END ACCOUNT INFORMATION -->

</div>