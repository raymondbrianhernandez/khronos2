<?php if (ceil($total_pages / $num_results_on_page) > 0): ?>
    <ul class="pagination">
    <?php if ($page > 1): ?>
    <li class="prev"><a href="territories.php?page=<?php echo $page-1 ?>">Prev</a></li>
    <?php endif; ?>

    <?php if ($page > 3): ?>
    <li class="start"><a href="territories.php?page=1">1</a></li>
    <li class="dots" style="color:black">. . .</li>
    <?php endif; ?>

    <?php if ($page-2 > 0): ?><li class="page"><a href="territories.php?page=<?php echo $page-2 ?>"><?php echo $page-2 ?></a></li><?php endif; ?>
    <?php if ($page-1 > 0): ?><li class="page"><a href="territories.php?page=<?php echo $page-1 ?>"><?php echo $page-1 ?></a></li><?php endif; ?>

    <li class="currentpage"><a href="territories.php?page=<?php echo $page ?>"><?php echo $page ?></a></li>

    <?php if ($page+1 < ceil($total_pages / $num_results_on_page)+1): ?><li class="page"><a href="territories.php?page=<?php echo $page+1 ?>"><?php echo $page+1 ?></a></li><?php endif; ?>
    <?php if ($page+2 < ceil($total_pages / $num_results_on_page)+1): ?><li class="page"><a href="territories.php?page=<?php echo $page+2 ?>"><?php echo $page+2 ?></a></li><?php endif; ?>

    <?php if ($page < ceil($total_pages / $num_results_on_page)-2): ?>
    <li class="dots" style="color:black">. . .</li>
    <li class="end"><a href="territories.php?page=<?php echo ceil($total_pages / $num_results_on_page) ?>"><?php echo ceil($total_pages / $num_results_on_page) ?></a></li>
    <?php endif; ?>

    <?php if ($page < ceil($total_pages / $num_results_on_page)): ?>
    <li class="next"><a href="territories.php?page=<?php echo $page+1 ?>">Next</a></li>
    <?php endif; ?>
    </ul>
<?php endif; ?>



<!-- THESE VARIABLES ARE USED ON PAGES NEEDED A PAGINATION 
$total_pages = $total_pages = $con->query('SELECT COUNT(*) FROM householders')->fetch_row()[0];
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
$num_results_on_page = 20; 
-->