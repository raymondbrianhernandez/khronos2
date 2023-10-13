<div class="card-header d-flex justify-content-between align-items-center">
    <h5 class="text-primary fw-bold m-0"> <?= $_SESSION['service_year'] ?> Service Year Hours</h5>
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
                <td style="--size:<?= $_SESSION['9_hrs'] ?>/100;">
                    <span class="data"> <?= round( $_SESSION['9_hrs'] ) ?> </span>
                </td>    
            </tr> 
            <tr>
                <th scope="row"> Oct </th> 
                <td style="--size:<?= $_SESSION['10_hrs'] ?>/100;">
                    <span class="data"> <?= round( $_SESSION['10_hrs'] ) ?> </span>
                </td>
            </tr> 
            <tr>
                <th scope="row"> Nov </th> 
                <td style="--size:<?= $_SESSION['11_hrs'] ?>/100;">
                    <span class="data"> <?= round( $_SESSION['11_hrs'] ) ?> </span>
                </td>
            </tr> 
            <tr>
                <th scope="row"> Dec </th> 
                <td style="--size:<?= $_SESSION['12_hrs'] ?>/100;">
                    <span class="data"> <?= round( $_SESSION['12_hrs'] ) ?> </span>
                </td>
            </tr> 
            <tr>
                <th scope="row"> Jan </th> 
                <td style="--size:<?= $_SESSION['1_hrs'] ?>/100;">
                    <span class="data"> <?= round( $_SESSION['1_hrs'] ) ?> </span>
                </td>
            </tr>
            <tr>
                <th scope="row"> Feb </th> 
                <td style="--size:<?= $_SESSION['2_hrs'] ?>/100;">
                    <span class="data"> <?= round( $_SESSION['2_hrs'] ) ?> </span>
                </td>
            </tr> 
            <tr>
                <th scope="row"> Mar </th> 
                <td style="--size:<?= $_SESSION['3_hrs'] ?>/100;">
                    <span class="data"> <?= round( $_SESSION['3_hrs'] ) ?> </span>
                </td>
            </tr> 
            <tr>
                <th scope="row"> Apr </th> 
                <td style="--size:<?= $_SESSION['4_hrs'] ?>/100;">
                    <span class="data"> <?= round( $_SESSION['4_hrs'] ) ?> </span>
                </td>
            </tr> 
            <tr>
                <th scope="row"> May </th> 
                <td style="--size:<?= $_SESSION['5_hrs'] ?>/100;">
                    <span class="data"> <?= round( $_SESSION['5_hrs'] ) ?> </span>
                </td>
            </tr> 
            <tr>
                <th scope="row"> Jun </th> 
                <td style="--size:<?= $_SESSION['6_hrs'] ?>/100;">
                    <span class="data"> <?= round( $_SESSION['6_hrs'] ) ?> </span>
                </td>
            </tr>
            <tr>
                <th scope="row"> Jul </th> 
                <td style="--size:<?= $_SESSION['7_hrs'] ?>/100;">
                    <span class="data"> <?= round( $_SESSION['7_hrs'] ) ?> </span>
                </td>
            </tr> 
            <tr>
                <th scope="row"> Aug </th> 
                <td style="--size:<?= $_SESSION['8_hrs'] ?>/100;">
                    <span class="data"> <?= round( $_SESSION['8_hrs'] ) ?> </span>
                </td>
            </tr>
        </tbody>
    </table>
</div>