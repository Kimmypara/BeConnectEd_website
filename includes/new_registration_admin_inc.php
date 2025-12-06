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
$must_change_password = $_POST["must_change_password"];
$qualifications = $_POST["qualifications"];
$relationship = $_POST["relationship"];

// Run validation
if (emptyRegistrationInput($role_id, $first_name, $last_name, $email, $date_of_birth,  $must_change_password, $qualifications, $relationship)) {
    header("location: ../new_registration_admin.php?error=emptyinput");
    exit();
}

// Register user
registerUser($conn, $role_id, $first_name, $last_name, $email, $date_of_birth, $must_change_password, $qualifications, $relationship);

header("location: ../registration_admin.php?success=true");
exit();
?>







