<?php
session_start();
require_once "dbh.php";

// show errors while developing
error_reporting(E_ALL);
ini_set('display_errors', 1);

function back($code) {
  header("Location: ../reset_password.php?error=" . urlencode($code));
  exit();
}

if (!isset($_POST['submit'])) {
  header("Location: ../reset_password.php");
  exit();
}

$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$confirm  = $_POST['confirm_password'] ?? '';

if ($email === '' || $password === '' || $confirm === '') {
  back("emptyinput");
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  back("invalidemail");
}

if ($password !== $confirm) {
  back("passwordmismatch");
}

// Check if user exists & is active
$sql = "SELECT user_id FROM users WHERE email = ? AND is_active = 1";
$stmt = mysqli_stmt_init($conn);

if (!mysqli_stmt_prepare($stmt, $sql)) {
  back("stmtfailed");
}

mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

if (!$user) {
  back("noactiveaccount");
}

// Update password + must_change_password
$hashed = password_hash($password, PASSWORD_DEFAULT);

$updateSql = "UPDATE users SET password_hash = ?, must_change_password = 0 WHERE user_id = ?";
$stmt2 = mysqli_stmt_init($conn);

if (!mysqli_stmt_prepare($stmt2, $updateSql)) {
  back("stmtfailed");
}

mysqli_stmt_bind_param($stmt2, "si", $hashed, $user['user_id']);
mysqli_stmt_execute($stmt2);
mysqli_stmt_close($stmt2);

// Success -> go to login page
header("Location: ../login_institute.php?reset=success");
exit();
