<?php
session_start();
include 'includes/users.php';

if (!isset($_POST['code']) || empty(trim($_POST['code']))) {
    header("Location: verify_code.php?error=emptyinput");
    exit();
}

if (!isset($_SESSION['reset_email']) || empty($_SESSION['reset_email'])) {
    header("Location: forgot_password.php?error=stmtfailed");
    exit();
}

$code = trim($_POST['code']);
$login_type = $_POST['login_type'] ?? '';
$email = $_SESSION['reset_email'];

// 1. Get user by email
$sql = "SELECT user_id, is_independent FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    header("Location: verify_code.php?error=stmtfailed");
    exit();
}

$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header("Location: verify_code.php?error=invalidcode");
    exit();
}

$user = $result->fetch_assoc();
$user_id = $user['user_id'];
$is_independent = (int)$user['is_independent'];

// 2. Check correct login path
if ($login_type === 'independent' && $is_independent !== 1) {
    header("Location: verify_code.php?error=invalidcode");
    exit();
}

if ($login_type === 'institute' && $is_independent !== 0) {
    header("Location: verify_code.php?error=invalidcode");
    exit();
}

// 3. Check latest valid code
$sql = "SELECT reset_password_id, reset_token, expires_at
        FROM reset_password
        WHERE user_id = ?
          AND reset_token = ?
          AND expires_at > NOW()
        ORDER BY reset_password_id DESC
        LIMIT 1";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    header("Location: verify_code.php?error=stmtfailed");
    exit();
}

$stmt->bind_param("is", $user_id, $code);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header("Location: verify_code.php?error=invalidcode");
    exit();
}

$reset_row = $result->fetch_assoc();

// Save verified user in session
$_SESSION['reset_user_id'] = $user_id;
$_SESSION['verified_reset_code'] = $code;
$_SESSION['reset_login_type'] = $login_type;

$sql = "UPDATE users SET is_active = 1 WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();

header("Location: login_independent.php?success=verified");
exit();
?>