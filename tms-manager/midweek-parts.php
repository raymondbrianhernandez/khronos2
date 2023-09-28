<table class="report">
    <tr>    
        <td style="width:80%; text-align:right"><b>Chairman: </b></td>
        <td style="width:20%"><?php echo $row['assignee']; ?></td>
    </tr>
    <tr>
        <?php if ($isTagalog) { ?>
            <td style="width:80%"><?= "7:00 &nbsp;&nbsp;&bull;&nbsp;&nbsp;" . $commonData['song_open'] . " at Pambukas na Panalangin"; ?></td>
        <?php } else { ?>
            <td style="width:80%"><?= "7:00 &nbsp;&nbsp;&bull;&nbsp;&nbsp;" . $commonData['song_open'] . " and Opening Prayer"; ?></td>
        <?php } ?>  
        <td style="width:20%"><?php echo $assignees[$i]; ?></td>
    </tr>
    <tr>    
        <td style="width:80%">< ?= "7:05 &nbsp;&nbsp;&bull;&nbsp;&nbsp;" . $intro1; ?></td>
        <td style="width:20%">< ?= $intro2; ?></td>
    </tr>
    <tr>
        <?php if ($isTagalog) { ?>
            <td style="width:80%; background-color: blue; color: white;">&nbsp;&nbsp;KAYAMANAN MULA SA SALITA NG DIYOS</td>
        <?php } else { ?>
            <td style="width:80%; background-color: blue; color: white;">&nbsp;&nbsp;TREASURES FROM GOD'S WORD</td>
        <?php } ?>
        <td style="width:20%"></td>
    </tr>
    <tr>    
        <td style="width:80%">< ?= "7:06 &nbsp;&nbsp;&bull;&nbsp;&nbsp;" . $treasures1; ?></td>
        <td style="width:20%">< ?= $treasures2; ?></td>
    </tr>
    <tr>    
        <td style="width:80%">< ?= "7:16 &nbsp;&nbsp;&bull;&nbsp;&nbsp;" . $digging1; ?></td>
        <td style="width:20%">< ?= $digging2; ?></td>
    </tr>
    <tr>   
        <td style="width:80%">< ?= "7:26 &nbsp;&nbsp;&bull;&nbsp;&nbsp;" . $reading1; ?></td>
        <td style="width:20%">< ?= $reading2; ?></td>
    </tr>
    <tr>
        <?php if ($isTagalog) { ?>
            <td style="width:80%; background-color: gold; color: white;">&nbsp;&nbsp;MAGING MAHUSAY SA MINISTERYO</td>
        <?php } else { ?>
            <td style="width:80%; background-color: gold; color: white;">&nbsp;&nbsp;APPLY YOURSELF TO THE FIELD MINISTRY</td>
        <?php } ?>
        <td style="width:20%"></td>
    </tr>
    <tr>    
        <td style="width:80%">< ?= "7:31 &nbsp;&nbsp;&bull;&nbsp;&nbsp;" . $initial1; ?></td>
        <td style="width:20%">< ?= $initial2 . " / " . $initial3; ?></td>
    </tr>
    <tr>    
        <td style="width:80%">< ?= "7:35 &nbsp;&nbsp;&bull;&nbsp;&nbsp;" . $rv1; ?></td>
        <td style="width:20%">< ?= $rv2 . " / " . $rv3; ?></td>
    </tr>
    <tr>
        <td style="width:80%">< ?= "7:40 &nbsp;&nbsp;&bull;&nbsp;&nbsp;" . $bs1; ?></td>
        <td style="width:20%">< ?= $bs2 . " / " . $bs3; ?></td>
    </tr>
    <tr>
        <?php if ($isTagalog) { ?>
            <td style="width:80%; background-color: red; color: white;">&nbsp;&nbsp;PAMUMUHAY BILANG KRISTIYANO</td>
        <?php } else { ?>
            <td style="width:80%; background-color: red; color: white;">&nbsp;&nbsp;LIVING AS CHRISTIANS</td>
        <?php } ?>
        <td style="width:20%"></td>
    </tr>
    <tr>
        <td style="width:80%">< ?= "7:46 &nbsp;&nbsp;&bull;&nbsp;&nbsp;" . $song_mid; ?></td>
        <td style="width:20%"></td>
    </tr>
    <tr>
        <td style="width:80%">< ?= "7:50 &nbsp;&nbsp;&bull;&nbsp;&nbsp;" . $service1A; ?></td>
        <td style="width:20%">< ?= $service2A; ?></td>
    </tr>
    
    <?php if ( $total_arr == 13 ) { ?>
        <tr>
            <td style="width:80%">< ?= "7:55 &nbsp;&nbsp;&bull;&nbsp;&nbsp;" . $service1B; ?></td>
            <td style="width:20%">< ?= $service2B; ?></td>
        </tr>
    <?php } ?>

    <tr>
        <td style="width:80%">< ?= "8:05 &nbsp;&nbsp;&bull;&nbsp;&nbsp;" . $cbs1; ?></td>
        <td style="width:20%">< ?= $cbs2 . " / " . $cbs3; ?></td>
    </tr>

    <tr>
        <td style="width:80%">< ?= "8:35 &nbsp;&nbsp;&bull;&nbsp;&nbsp;" . $outro1; ?></td>
        <td style="width:20%">< ?= $outro2; ?></td>
    </tr>

    <tr>
        <td style="width:80%">< ?= "8:38 &nbsp;&nbsp;&bull;&nbsp;&nbsp;" . $song_close . " at Pansarang Panalangin"; ?></td>
        <td style="width:20%">< ?= $pray_close; ?></td>
    </tr>
</table>