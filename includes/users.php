<?php
// access for dbh 
require_once "dbh.php";
require_once "functions.php";

$result = getUsers($conn);

while($row = mysqli_fetch_assoc($result)){
    //print_r($row);
   // echo"<br/>";

    $user_id =$row['user_id'];
    $email =$row['email'];
    $password_hash =$row['password_hash'];
    $first_name =$row['first_name'];
    $last_name =$row['last_name'];
    $date_of_birth =$row['date_of_birth'];
    $is_active = $row['is_active'];
    $created_at = $row['created_at'];
    $profile_photo = $row['profile_photo'];
    $role_id = $row['role_id'];
    $institute_id = $row['institute_id'];
    $must_change_password = $row['must_change_password'];

  // echo "<div class='col'>";
  //echo "<h2>{$email}</h2><h4>{$first_name} {$date_of_birth}<h/4> <p>{$role_id}</p>";
   //echo "</div>";
}

?>