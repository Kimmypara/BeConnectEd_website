<?php

require_once "dbh.php";
require_once "functions.php";

// Check if form submitted
if (!isset($_POST["submit"])) {
    header("location: ../new_registration_admin.php");
    exit();
}

// Get form data correctly named
$role_id = $_POST["role_id"] ?? "";
$first_name = $_POST["first_name"];
$last_name = $_POST["last_name"];
$email = $_POST["email"];
$date_of_birth = $_POST["date_of_birth"];
$is_active = $_POST["is_active"] ?? "";
$must_change_password = $_POST["must_change_password"] ?? "";
$institute_id = $_POST["institute_id"] ?? "";
//$qualifications = $_POST["qualifications"];

$error = "";

// Run validation
if (emptyRegistrationInput($role_id, $first_name, $last_name, $email, $date_of_birth, $is_active, $must_change_password, $institute_id)) {
   

    $error = $error."emptyinput=true&";
}

 if(invalidFirst_name($first_name)){
            $error = $error."invalidFirst_name=true&";
        }

        if(invalidLast_name($last_name)){
            $error = $error."invalidLast_name=true&";
        }

        if(invalidEmail($email)){
            $error = $error."invalidEmail=true&";
        }

          if(emailExists($conn,$email)){
            $error = $error."emailExists=true&";
        }

           if(invalidDate_of_birth($date_of_birth)){
            $error = $error."invalidDate_of_birth=true&";
        }

            if ($error != "") {
    header("location: ../new_registration_admin.php?error=true&$error");
    exit();
}


// Register user
registerUser($conn, $role_id, $first_name, $last_name, $email, $date_of_birth, $is_active, $must_change_password, $institute_id );

header("location: ../registration_admin.php?success=true");
exit();
?>







