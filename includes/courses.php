<?php
// access for dbh 
require_once "dbh.php";
require_once "functions.php";

$result = getCourses($conn);

while($row = mysqli_fetch_assoc($result)){
    //print_r($row);
   // echo"<br/>";

    $course_id =$row['course_id'];
    $course_name =$row['course_name'];
    $course_code =$row['course_code'];
    $institute_id =$row['institute_id'];
    $is_active = $row['is_active'];
    $MQF_level = $row['MQF_Level'];
   

   //echo "<div >";
  //echo "<td>{$email}</td><td>{$first_name} {$last_name}<td> <td>{$role_id}</td>";
   //echo "</div>";

   
}

?>

