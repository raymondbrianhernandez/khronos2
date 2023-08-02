<?php ?>

<div class="card shadow mb-4">

    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="text-primary fw-bold m-0"> <?= date( "Y ") ?> Service Year Hours</h5>
    </div>
    
    <div class="card-body"> 
        <table id="service-year" class="charts-css column show-labels"> 
            <thead>
                <tr>
                    <th scope="col"> Year </th> 
                    <th scope="col"> Progress </th>
                </tr>
            </thead> 
                
            <tbody>
                <tr>
                    <th scope="row"> Sep </th> 
                    <td style="--size:<?= $sep_hrs ?>/100;">
                        <span class="data"> <?= round( $sep_hrs ) ?> </span>
                    </td>    
                </tr> 
                <tr>
                    <th scope="row"> Oct </th> 
                    <td style="--size:<?= $oct_hrs ?>/100;">
                        <span class="data"> <?= round( $oct_hrs ) ?> </span>
                    </td>
                </tr> 
                <tr>
                    <th scope="row"> Nov </th> 
                    <td style="--size:<?= $nov_hrs ?>/100;">
                        <span class="data"> <?= round( $nov_hrs ) ?> </span>
                    </td>
                </tr> 
                <tr>
                    <th scope="row"> Dec </th> 
                    <td style="--size:<?= $dec_hrs ?>/100;">
                        <span class="data"> <?= round( $dec_hrs ) ?> </span>
                    </td>
                </tr> 
                <tr>
                    <th scope="row"> Jan </th> 
                    <td style="--size:<?= $jan_hrs ?>/100;">
                        <span class="data"> <?= round( $jan_hrs ) ?> </span>
                    </td>
                </tr>
                <tr>
                    <th scope="row"> Feb </th> 
                    <td style="--size:<?= $feb_hrs ?>/100;">
                        <span class="data"> <?= round( $feb_hrs ) ?> </span>
                    </td>
                </tr> 
                <tr>
                    <th scope="row"> Mar </th> 
                    <td style="--size:<?= $mar_hrs ?>/100;">
                        <span class="data"> <?= round( $mar_hrs ) ?> </span>
                    </td>
                </tr> 
                <tr>
                    <th scope="row"> Apr </th> 
                    <td style="--size:<?= $apr_hrs ?>/100;">
                        <span class="data"> <?= round( $apr_hrs ) ?> </span>
                    </td>
                </tr> 
                <tr>
                    <th scope="row"> May </th> 
                    <td style="--size:<?= $may_hrs ?>/100;">
                        <span class="data"> <?= round( $may_hrs ) ?> </span>
                    </td>
                </tr> 
                <tr>
                    <th scope="row"> Jun </th> 
                    <td style="--size:<?= $jun_hrs ?>/100;">
                        <span class="data"> <?= round( $jun_hrs ) ?> </span>
                    </td>
                </tr>
                <tr>
                    <th scope="row"> Jul </th> 
                    <td style="--size:<?= $jul_hrs ?>/100;">
                        <span class="data"> <?= round( $jul_hrs ) ?> </span>
                    </td>
                </tr> 
                <tr>
                    <th scope="row"> Aug </th> 
                    <td style="--size:<?= $aug_hrs ?>/100;">
                        <span class="data"> <?= round( $aug_hrs ) ?> </span>
                    </td>
                </tr>
            </tbody>
        </table>
    <div>
</div>