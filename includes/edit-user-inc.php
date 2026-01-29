<?php
require_once "dbh.php";
require_once "functions.php";

if (!isset($_POST["submit"])) {
    header("location: ../registration_admin.php");
    exit();
}

$user_id = (int)($_GET["user_id"] ?? 0);
if ($user_id <= 0) {
    header("location: ../registration_admin.php?error=missinguserid");
    exit();
}

$role_id       = (int)($_POST["role_id"] ?? 0);
$first_name    = trim($_POST["first_name"] ?? "");
$last_name     = trim($_POST["last_name"] ?? "");
$email         = trim($_POST["email"] ?? "");
$date_of_birth = $_POST["date_of_birth"] ?? "";
$is_active     = $_POST["is_active"] ?? "";
$institute_id  = $_POST["institute_id"] ?? "";


$must_change_password = $_POST["must_change_password"] ?? 0;

$error = "";

if ($role_id <= 0 || $first_name === "" || $last_name === "" || $email === "" || $date_of_birth === "" || $is_active === "" || $institute_id === "") {
    $error .= "emptyinput=true&";
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



editUser($conn, $user_id, $role_id, $first_name, $last_name, $email, $date_of_birth, $is_active, $must_change_password, $institute_id);

header("location: ../registration_admin.php?success=updated");
exit();



