<?php
session_start();
include 'includes/users.php';

if (!isset($_POST['email']) || empty(trim($_POST['email']))) {
    header("Location: forgot_password.php?error=emptyinput");
    exit();
}

$email = trim($_POST['email']);
$login_type = $_POST['login_type'] ?? '';

require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';
require 'PHPMailer-master/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Get user
$sql = "SELECT user_id, is_independent FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    header("Location: forgot_password.php?error=stmtfailed");
    exit();
}

$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    header("Location: forgot_password.php?error=emailnotfound");
    exit();
}

$user = $result->fetch_assoc();
$user_id = $user['user_id'];
$is_independent = (int)$user['is_independent'];

// STOP HERE if wrong login path
if ($login_type === 'independent' && $is_independent !== 1) {
    header("Location: forgot_password.php?error=wronglogintype");
    exit();
}

if ($login_type === 'institute' && $is_independent !== 0) {
    header("Location: forgot_password.php?error=wronglogintype");
    exit();
}

// Generate code only AFTER checks
$code = rand(100000, 999999);
$expires_at = date('Y-m-d H:i:s', strtotime('+10 minutes'));

// Delete old reset codes
$sql = "DELETE FROM reset_password WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();

// Insert new reset code
$sql = "INSERT INTO reset_password (user_id, reset_token, expires_at)
        VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    header("Location: forgot_password.php?error=stmtfailed");
    exit();
}

$stmt->bind_param("iss", $user_id, $code, $expires_at);
$stmt->execute();

// Send email
$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'beconnected.website@gmail.com';
    $mail->Password = 'uxnngbaikngzmujt';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    $mail->setFrom('beconnected.website@gmail.com', 'BeConnectEd');
    $mail->addAddress($email);

    $mail->Subject = 'Password Reset Code';
 $mail->isHTML(true);
$mail->Subject = 'BeConnectEd Password Reset Code';
$mail->Body = "
<p>Hello,</p>
<p>Your <strong>BeConnectEd</strong> password reset code is:</p>
<h2>$code</h2>
<p>This code expires in 10 minutes.</p>
<p>If you did not request this, please ignore this email.</p>
";
$mail->AltBody = "Your BeConnectEd password reset code is: $code. This code expires in 10 minutes.";
    $mail->send();

    $_SESSION['reset_email'] = $email;
    $_SESSION['reset_login_type'] = $login_type;

    header("Location: verify_code.php");
    exit();

} catch (Exception $e) {
    echo "Email failed: " . $mail->ErrorInfo;
}
?>