<?php
   require("../private/secure.php");
   require_once("../private/db_config.php");
   session_start();
   
   $query = 'SELECT @i:=@i+1 AS num, householders.* FROM householders, (SELECT @i:=0) i WHERE owner="'.$_SESSION['owner']. '" ORDER BY Address_ID LIMIT ?,?';
   
   // Google Maps API
   // $googlemap = "https://www.google.com/maps/search/?api=1&query=";
   $googlemap = "https://www.google.com/maps/dir//";
   
   // Pagination
   $total_pages = $total_pages = $con->query('SELECT COUNT(*) FROM householders')->fetch_row()[0];
   $page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
   $num_results_on_page = 20;
   $_SESSION['offset'] = $num_results_on_page;
   
   if ($stmt = $con->prepare($query)) {
      // Calculate the page to get the results we need from our table.
      $calc_page = ($page - 1) * $num_results_on_page;
      $stmt->bind_param('ii', $calc_page, $num_results_on_page);
      $stmt->execute();
      
      // Get the results...
      $result = $stmt->get_result();
      
      include('../private/shared/header.php'); ?><br><br>
      
      <article>
      <table>
         <tr>
            <th>#</th>
            <th>Name</th>
            <th>Address</th>
            <th>Map</th>
            <th>Telephone</th>
            <th>Notes</th>
            <th>Actions</th>
         </tr>
         
         <?php while ($row = $result->fetch_assoc()):
            $tempAddr = $row['Address'].' '.$row['Suite'].' '.$row['City'].' '.$row['Province'].' '.$row['Postal_code'];?>
            <tr>
               <td style="word-wrap:break-word; text-align:center; width:2%">
                  <?php echo $row['num'] + ($page-1) * $num_results_on_page;; ?></td>
               <td style="word-wrap:break-word; width:18%">
                  <b><?php echo $row['Name']; ?></b></td>
               <td style="word-wrap:break-word; width:25%">
                  <?php echo $tempAddr; ?></td>
               <td style="word-wrap:break-word; width:5%; text-align:center">
                  <a href="<?= $googlemap.$tempAddr?>" target="_blank">Directions</a></td>
               <td style="word-wrap:break-word; width:7%; text-align:center">
                  <?php echo $row['Telephone']; ?></td>
               <td style="word-wrap:break-word; width:35%">
                  <?php echo $row['Notes']; ?></td>
               <td style="word-wrap:break-word; width:13%; text-align:center">
                  <?php echo "Edit | Delete"; ?></td>
            </tr>
         <?php endwhile;  ?>
      </table>
      </article>
      
      <?php include('../private/shared/pagination.php'); ?>
      
      </body>
   </html>
<?php $stmt->close(); } ?>