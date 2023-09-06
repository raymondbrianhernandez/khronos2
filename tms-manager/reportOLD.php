<?php
echo "<a href=\"index.php\" target=\"blank\">Home</a>";
session_start();
if(isset($_SESSION['posts'])){
    foreach($_SESSION['posts'] as $post){
        echo $post;
    }
}
?>
