<?php
// access for dbh 
require_once "dbh.php";
require_once "functions.php";

$result = getRole($conn);

while($row = mysqli_fetch_assoc($result)){
    //print_r($row);
   // echo"<br/>";

    $role_id = $row['role_id'];
    $role_name = $row['role_name'];

    

   echo "<div >";
  echo "<td>{$role_name} <td> ";
   echo "</div>";

   
}

?>

