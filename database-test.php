<style>
table, td, th {
    border: 1px solid black;
    border-collapse: collapse;
}
</style>

<?php
    // Prints out usernames, names, and emails or users
    // 08/04/23 - Carla Hernandez

    //include('../public/debug.php');
    session_start();      
    //include('db_config.php'); 

   $host        = "localhost";  
   $user        = "root";  
   $password    = "root";  
   $db_name     = "service_record";
   $con         = mysqli_connect($host, $user, $password, $db_name);

   if ($con->connect_error) {
        die("Connection failed: " . $con->connect_error);
   }

   //Step 2: Run a SQL query to fetch the data
   $sql = "SELECT username, name, email FROM logins";
   $result = $con->query($sql);

   if ($result->num_rows > 0) {
        //Step 3: Loop through the data and print each row
        echo "<table>";
        echo "<tr>";
        echo "<th>Username</th><th>Name</th><th>Email</th>";
        echo "</tr>";
        while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["username"] . "</td>";
        echo "<td>" . $row["name"] . "</td>";
        echo "<td>" . $row["email"] . "</td>";
        echo "</tr>";        
        }
    } else {
        echo "0 results";
    }

    $con->close();
?>