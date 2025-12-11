<?php

require_once "dbh.php";
require_once "functions.php";

// Check if form submitted
if (!isset($_POST["submit"])) {
    header("location: ../new_registration_admin.php");
    exit();
}

// Get form data correctly named
$role_id = $_POST["role_id"];
$first_name = $_POST["first_name"];
$last_name = $_POST["last_name"];
$email = $_POST["email"];
$date_of_birth = $_POST["date_of_birth"];
$is_active = $_POST["is_active"];
$must_change_password = $_POST["must_change_password"];
$institute_id = $_POST["institute_id"];
//$qualifications = $_POST["qualifications"];


// Run validation
if (emptyRegistrationInput($role_id, $first_name, $last_name, $email, $date_of_birth, $is_active, $must_change_password, $institute_id)) {
    header("location: ../new_registration_admin.php?error=emptyinput");
    exit();
}

// Register user
registerUser($conn, $role_id, $first_name, $last_name, $email, $date_of_birth, $is_active, $must_change_password, $institute_id );

header("location: ../registration_admin.php?success=true");
exit();
?>







