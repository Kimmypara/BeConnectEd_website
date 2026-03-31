<?php
session_start();
require_once "dbh.php";

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

if (!isset($_SESSION['reset_user_id'])) {
    back("stmtfailed");
}

$user_id = $_SESSION['reset_user_id'];

$password = $_POST['password'] ?? '';
$confirm  = $_POST['confirm_password'] ?? '';

if ($password === '' || $confirm === '') {
    back("emptyinput");
}

if ($password !== $confirm) {
    back("passwordmismatch");
}

$hashed = password_hash($password, PASSWORD_DEFAULT);

$updateSql = "UPDATE users 
              SET password_hash = ?, must_change_password = 0 
              WHERE user_id = ? AND is_active = 1";

$stmt = mysqli_stmt_init($conn);

if (!mysqli_stmt_prepare($stmt, $updateSql)) {
    back("stmtfailed");
}

mysqli_stmt_bind_param($stmt, "si", $hashed, $user_id);
mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

// delete used reset codes
$deleteSql = "DELETE FROM reset_password WHERE user_id = ?";
$stmt2 = mysqli_stmt_init($conn);

if (mysqli_stmt_prepare($stmt2, $deleteSql)) {
    mysqli_stmt_bind_param($stmt2, "i", $user_id);
    mysqli_stmt_execute($stmt2);
    mysqli_stmt_close($stmt2);
}

// clear session reset values
unset($_SESSION['reset_user_id']);
unset($_SESSION['reset_email']);
unset($_SESSION['verified_reset_code']);
unset($_SESSION['reset_login_type']);

header("Location: ../password_updated.php?reset=success");
exit();
?>