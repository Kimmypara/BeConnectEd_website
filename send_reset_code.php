
<?php
session_start();
include("includes/dbh.php");

// PHPMailer 
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';
require 'PHPMailer-master/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// 1. Get email from form
$email = $_POST['email'];

// 2. Check if user exists
$sql = "SELECT user_id FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows == 0){
    echo "Email not found";
    exit();
}

$user = $result->fetch_assoc();
$user_id = $user['user_id'];

// 3. Generate 6-digit code
$code = rand(100000, 999999);

// 4. Set expiry (10 minutes)
$expires_at = date('Y-m-d H:i:s', strtotime('+10 minutes'));

// 5. Insert into reset_password table
$sql = "INSERT INTO reset_password (user_id, reset_token, expires_at)
        VALUES (?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("iss", $user_id, $code, $expires_at);
$stmt->execute();

// 6. Send email using PHPMailer
$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'beconnected.website@gmail.com';
    $mail->Password = 'uxnngbaikngzmujt'; // app password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    $mail->setFrom('beconnected.website@gmail.com', 'BeConnectEd');
    $mail->addAddress($email);

    $mail->Subject = 'Password Reset Code';
    $mail->Body = "Your verification code is: $code\nThis code will expire in 10 minutes.";

    $mail->send();

    // 7. Save user in session 
    $_SESSION['reset_email'] = $email;

    // Redirect to verify page
    header("Location: verify_code.php");
    exit();

} catch (Exception $e) {
    echo "Email failed: " . $mail->ErrorInfo;
}
?>