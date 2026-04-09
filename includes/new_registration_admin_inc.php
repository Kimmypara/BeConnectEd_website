<?php
session_start();
require_once "dbh.php";
require_once "functions.php";

$success_to = $_POST['success_to'] ?? '/BeConnectEd_website/login_independent.php?success=registered';
$error_to   = $_POST['error_to']   ?? '/BeConnectEd_website/create_account.php';

$is_independent = isset($_POST["is_independent"]) ? (int)$_POST["is_independent"] : 0;

if (!isset($_POST["submit"])) {
    header("location: ../create_account.php");
    exit();
}

$role_id          = $_POST["role_id"] ?? "";
$first_name       = $_POST["first_name"] ?? "";
$last_name        = $_POST["last_name"] ?? "";
$email            = $_POST["email"] ?? "";
$date_of_birth    = $_POST["date_of_birth"] ?? "";
$password         = $_POST["password"] ?? "";
$confirm_password = $_POST["confirm_password"] ?? "";
$institute_id     = $_POST["institute_id"] ?? 0;

// For independent users: inactive until verified
if ($is_independent === 1) {
    $is_active = 0;
    $institute_id = 0;
} else {
    $is_active = $_POST["is_active"] ?? 0;
}

$error = "";

if (
    empty($role_id) || empty($first_name) || empty($last_name) ||
    empty($email) || empty($date_of_birth) || empty($password) || empty($confirm_password)
) {
    $error .= "emptyinput=true&";
}

if (invalidFirst_name($first_name)) {
    $error .= "invalidFirst_name=true&";
}

if (invalidLast_name($last_name)) {
    $error .= "invalidLast_name=true&";
}

if (invalidEmail($email)) {
    $error .= "invalidEmail=true&";
}

if (emailExists($conn, $email)) {
    $error .= "emailExists=true&";
}

if (invalidDate_of_birth($date_of_birth)) {
    $error .= "invalidDate_of_birth=true&";
}

if ($password !== $confirm_password) {
    $error .= "passwordmismatch=true&";
}

if ($error != "") {
    $error = rtrim($error, "&");
    header("Location: " . $error_to . "?error=1&" . $error);
    exit();
}

// Hash the password the user entered
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// No forced password change needed
$must_change_password = 0;

// Register user
registerUser(
    $conn,
    $role_id,
    $first_name,
    $last_name,
    $email,
    $hashedPassword,
    $date_of_birth,
    $is_active,
    $must_change_password,
    $institute_id,
    $is_independent
);

$user_id = mysqli_insert_id($conn);

// Generate 6-digit code
$code = rand(100000, 999999);
$expires = date("Y-m-d H:i:s", strtotime("+10 minutes"));

$sql = "INSERT INTO reset_password (user_id, reset_token, expires_at)
        VALUES (?, ?, ?)";

$stmt = mysqli_stmt_init($conn);
mysqli_stmt_prepare($stmt, $sql);
mysqli_stmt_bind_param($stmt, "iss", $user_id, $code, $expires);
mysqli_stmt_execute($stmt);

// Save for verification
$_SESSION['reset_email'] = $email;
$_SESSION['reset_login_type'] = 'independent';

// Send email here with PHPMailer
// mail body: Your verification code is: $code





header("Location: ../verify_code.php");
exit();
?>