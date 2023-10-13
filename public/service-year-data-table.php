<div class="card-header d-flex justify-content-between align-items-center">
    <h5 class="text-primary fw-bold m-0"> <?= $_SESSION['service_year'] ?> Service Year Data</h5>
</div>

<div class="card-body"> 
    <table id="ytd"> 
        <tr style="width:303px">
            <th> Mon    </th>  
            <th> Hrs    </th>
            <th> Plc    </th> 
            <th> Vids   </th>
            <th> RVs    </th> 
            <th> BS     </th>
            <th> LDC    </th>
        </tr>
        <tr><td><hr></td></tr>
        <tr>
            <td><b>Sep<b></td>
            <td><?= $_SESSION['9_hrs'] ?></td>
            <td><?= $_SESSION['9_plc'] ?></td>
            <td><?= $_SESSION['9_vid'] ?></td>
            <td><?= $_SESSION['9_rvs'] ?></td>
            <td><?= $_SESSION['9_bss'] ?></td>
            <td><?= $_SESSION['9_ldc'] ?></td>    
        </tr> 
        <tr>
            <td><b>Oct<b></td>
            <td><?= $_SESSION['10_hrs'] ?></td>
            <td><?= $_SESSION['10_plc'] ?></td>
            <td><?= $_SESSION['10_vid'] ?></td>
            <td><?= $_SESSION['10_rvs'] ?></td>
            <td><?= $_SESSION['10_bss'] ?></td>
            <td><?= $_SESSION['10_ldc'] ?></td>    
        </tr> 
        <tr>
            <td><b>Nov<b></td>
            <td><?= $_SESSION['11_hrs'] ?></td>
            <td><?= $_SESSION['11_plc'] ?></td>
            <td><?= $_SESSION['11_vid'] ?></td>
            <td><?= $_SESSION['11_rvs'] ?></td>
            <td><?= $_SESSION['11_bss'] ?></td>
            <td><?= $_SESSION['11_ldc'] ?></td>    
        </tr> 
        <tr>
            <td><b>Dec<b></td>
            <td><?= $_SESSION['12_hrs'] ?></td>
            <td><?= $_SESSION['12_plc'] ?></td>
            <td><?= $_SESSION['12_vid'] ?></td>
            <td><?= $_SESSION['12_rvs'] ?></td>
            <td><?= $_SESSION['12_bss'] ?></td>
            <td><?= $_SESSION['12_ldc'] ?></td>    
        </tr> 
        <tr>
            <td><b>Jan<b></td>
            <td><?= $_SESSION['1_hrs'] ?></td>
            <td><?= $_SESSION['1_plc'] ?></td>
            <td><?= $_SESSION['1_vid'] ?></td>
            <td><?= $_SESSION['1_rvs'] ?></td>
            <td><?= $_SESSION['1_bss'] ?></td>
            <td><?= $_SESSION['1_ldc'] ?></td>    
        </tr> 
        <tr>
            <td><b>Feb<b></td>
            <td><?= $_SESSION['2_hrs'] ?></td>
            <td><?= $_SESSION['2_plc'] ?></td>
            <td><?= $_SESSION['2_vid'] ?></td>
            <td><?= $_SESSION['2_rvs'] ?></td>
            <td><?= $_SESSION['2_bss'] ?></td>
            <td><?= $_SESSION['2_ldc'] ?></td>    
        </tr> 
        <tr>
            <td><b>Mar<b></td>
            <td><?= $_SESSION['3_hrs'] ?></td>
            <td><?= $_SESSION['3_plc'] ?></td>
            <td><?= $_SESSION['3_vid'] ?></td>
            <td><?= $_SESSION['3_rvs'] ?></td>
            <td><?= $_SESSION['3_bss'] ?></td>
            <td><?= $_SESSION['3_ldc'] ?></td>    
        </tr> 
        <tr>
            <td><b>Apr<b></td>
            <td><?= $_SESSION['4_hrs'] ?></td>
            <td><?= $_SESSION['4_plc'] ?></td>
            <td><?= $_SESSION['4_vid'] ?></td>
            <td><?= $_SESSION['4_rvs'] ?></td>
            <td><?= $_SESSION['4_bss'] ?></td>
            <td><?= $_SESSION['4_ldc'] ?></td>    
        </tr> 
        <tr>
            <td><b>May<b></td>
            <td><?= $_SESSION['5_hrs'] ?></td>
            <td><?= $_SESSION['5_plc'] ?></td>
            <td><?= $_SESSION['5_vid'] ?></td>
            <td><?= $_SESSION['5_rvs'] ?></td>
            <td><?= $_SESSION['5_bss'] ?></td>
            <td><?= $_SESSION['5_ldc'] ?></td>    
        </tr> 
        <tr>
            <td><b>Jun<b></td>
            <td><?= $_SESSION['6_hrs'] ?></td>
            <td><?= $_SESSION['6_plc'] ?></td>
            <td><?= $_SESSION['6_vid'] ?></td>
            <td><?= $_SESSION['6_rvs'] ?></td>
            <td><?= $_SESSION['6_bss'] ?></td>
            <td><?= $_SESSION['6_ldc'] ?></td>    
        </tr> 
        <tr>
            <td><b>Jul<b></td>
            <td><?= $_SESSION['7_hrs'] ?></td>
            <td><?= $_SESSION['7_plc'] ?></td>
            <td><?= $_SESSION['7_vid'] ?></td>
            <td><?= $_SESSION['7_rvs'] ?></td>
            <td><?= $_SESSION['7_bss'] ?></td>
            <td><?= $_SESSION['7_ldc'] ?></td>    
        </tr> 
        <tr>
            <td><b>Aug<b></td>
            <td><?= $_SESSION['8_hrs'] ?></td>
            <td><?= $_SESSION['8_plc'] ?></td>
            <td><?= $_SESSION['8_vid'] ?></td>
            <td><?= $_SESSION['8_rvs'] ?></td>
            <td><?= $_SESSION['8_bss'] ?></td>
            <td><?= $_SESSION['8_ldc'] ?></td>    
        </tr> 
        <tr style="background-color:gold">
            <td><b>TOTAL<b></td>
            <td><b><?= $ytd     ?>    </b></td>
            <td><b><?= $aug_plc ?></b></td>
            <td><b><?= $aug_vid ?></b></td>
            <td><b><?= $aug_rvs ?></b></td>
            <td><b><?= $aug_bss ?></b></td>
            <td><b><?= $aug_ldc ?></b></td>    
        </tr>  
    </table>
<div>