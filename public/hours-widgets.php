<!-- ROW WIDGETS -->
<div class="row">    
    <div class="card shadow mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="text-primary fw-bold m-0"> My Reports </h5>
        </div>
    </div>
</div>
<div class="row">
    <!-- MY GOAL -->
    <div class="col-md-6 col-xl-3 mb-4">
        <article class="card shadow border-start-primary py-2">
            <div class="card-body">
                <div class="row align-items-center no-gutters">
                    <div class="col me-2">
                        <div class="text-uppercase text-primary fw-bold text-xs mb-1">
                            <span> My Goal </span>
                        </div>
                        <div class="text-dark fw-bold h5 mb-0">
                            <span> <?= $_SESSION['goal'] ?> </span>
                        </div>
                        <div>
                            <span> Change goal from the <a href="dashboard.php#update-info"> dashboard </a> page </span>
                        </div>
                    </div>
                    <div class="col-auto">
                        <img src="../img/goal.png" width="30px" alt="Goal Icon">
                    </div>
                </div>
            </div>
        </article>
    </div>

    <!-- YEAR TO DATE -->
    <div class="col-md-6 col-xl-3 mb-4">
        <article class="card shadow border-start-primary py-2">
            <div class="card-body">
                <div class="row align-items-center no-gutters">
                    <div class="col me-2">
                        <div class="text-uppercase text-primary fw-bold text-xs mb-1">
                            <span> Year-to-date </span>
                        </div>
                        <div class="text-dark fw-bold h5 mb-0">
                            <span> <?= $_SESSION['ytd'] ?> </span> hours
                        </div>
                        <div>
                            <span> View your monthly summary <a href="hours#ytd"> here </a></span>
                        </div>
                    </div>
                    <div class="col-auto">
                        <img src="../img/clock.png" width="30px" alt="Clock Icon">
                    </div>
                </div>
            </div>
        </article>
    </div>

    <!-- CURRENT HOURS -->
    <div class="col-md-6 col-xl-3 mb-4">
        <article class="card shadow border-start-primary py-2">
            <div class="card-body">
                <div class="row align-items-center no-gutters">
                    <div class="col me-2">
                        <div class="text-uppercase text-primary fw-bold text-xs mb-1">
                            <span> Hours for <?= date ( 'F' ) ?> </span>
                        </div>
                        <div class="text-dark fw-bold h5 mb-0">
                            <span> <?= $_SESSION['curr_hrs'] ?> </span> hours
                        </div>
                        <div>
                            <span> Log your time <a href="hours#analog-clock"> here </a></span>
                        </div>
                        <div class="text-uppercase text-primary fw-bold text-xs mb-1">
                            <span> LDC Credits for <?= date ( 'F' ) ?> </span>
                        </div>
                        <div class="text-dark fw-bold h5 mb-0">
                            <span> <?= $_SESSION['curr_ldc'] ?> </span> hours
                        </div>  
                    </div>
                    <div class="col-auto">
                        <img src="../img/clock.png" width="30px" alt="Clock Icon">
                    </div>
                </div>
            </div>
        </article>
    </div>

    <!-- RVS -->
    <div class="col-md-6 col-xl-3 mb-4">
        <article class="card shadow border-start-success py-2">
            <div class="card-body">
                <div class="row align-items-center no-gutters">
                    <div class="col me-2">
                        <div class="text-uppercase text-primary fw-bold text-xs mb-1">
                            <span> Return Visits </span>
                        </div>
                        <div class="text-dark fw-bold h5 mb-0">
                            <span> <?= $_SESSION['curr_rvs'] ?> </span>
                        </div>
                        <div>
                            <span><a href="territories">View your records</a></span>
                        </div>
                    </div>
                    <div class="col-auto">
                        <img src="../img/house.png" width="30px" alt="House Icon">
                    </div>
                </div>
            </div>
        </article>
    </div>

    <!-- BS -->
    <div class="col-md-6 col-xl-3 mb-4">
        <article class="card shadow border-start-info py-2">
            <div class="card-body">
                <div class="row align-items-center no-gutters">
                    <div class="col me-2">
                        <div class="text-uppercase text-info fw-bold text-xs mb-1">
                            <span> Bible Studies </span>
                        </div>
                        <div class="text-dark fw-bold h5 mb-0">
                            <span> <?= $_SESSION['curr_bss'] ?> </span>
                        </div>
                    </div>
                    <div>
                        <span><a href="territories">View your records</a></span>
                    </div>
                    <div class="col-auto">
                        <img src="../img/book.png" width="30px" alt="Book Icon">
                    </div>
                </div>
            </div>
        </article>
    </div>

    <!-- PLACEMENTS -->
    <div class="col-md-6 col-xl-3 mb-4">
        <div class="card shadow border-start-warning py-2">
            <div class="card-body">
                <div class="row align-items-center no-gutters">
                    <div class="col me-2">
                        <div class="text-uppercase text-warning fw-bold text-xs mb-1"><span> Placements </span></div>
                        <div class="text-dark fw-bold h5 mb-0"><span> <?= $_SESSION['curr_plc'] ?> </span></div>
                    </div>
                    <div class="col-auto"><img src="../img/magazine.png" width="30px"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- VIDEOS SHOWN -->
    <div class="col-md-6 col-xl-3 mb-4">
        <div class="card shadow border-start-warning py-2">
            <div class="card-body">
                <div class="row align-items-center no-gutters">
                    <div class="col me-2">
                        <div class="text-uppercase text-warning fw-bold text-xs mb-1"><span> Videos Shown </span></div>
                        <div class="text-dark fw-bold h5 mb-0"><span> <?= $_SESSION['curr_vid'] ?> </span></div>
                    </div>
                    <div class="col-auto"><img src="../img/multimedia.png" width="30px"></div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- LDC HOURS -->
    <div class="col-md-6 col-xl-3 mb-4">
        <div class="card shadow border-start-warning py-2">
            <div class="card-body">
                <div class="row align-items-center no-gutters">
                    <div class="col me-2">
                        <div class="text-uppercase text-warning fw-bold text-xs mb-1"><span> LDC Credit </span></div>
                        <div class="text-dark fw-bold h5 mb-0"><span> <?= $_SESSION['curr_ldc'] ?> </span></div>
                    </div>
                    <div class="col-auto"><img src="../img/worker.png" width="30px"></div>
                </div>
            </div>
        </div>
    </div>

</div> 
<!-- END ROW WIDGETS -->