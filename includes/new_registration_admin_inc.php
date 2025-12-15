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


// Generate temporary password (not used for login)
$plainPassword = random_password();

// Hash password before saving
$hashedPassword = password_hash($plainPassword, PASSWORD_DEFAULT);

// Force password change
$must_change_password = 1;



// Register user
registerUser($conn, $role_id, $first_name, $last_name, $email, $hashedPassword, $date_of_birth, $is_active, $must_change_password, $institute_id );


$user_id = mysqli_insert_id($conn);

$token = bin2hex(random_bytes(32));
$expires = date("Y-m-d H:i:s", strtotime("+1 hour"));

$sql = "INSERT INTO reset_password (user_id, reset_token, expires_at)
        VALUES (?, ?, ?)";

$stmt = mysqli_stmt_init($conn);
mysqli_stmt_prepare($stmt, $sql);
mysqli_stmt_bind_param($stmt, "iss", $user_id, $token, $expires);
mysqli_stmt_execute($stmt);

$resetLink = "http://localhost/BeConnectEd_website/reset_password.php?token=$token";


//Send email to new user with password
$to = $email;
$subject = "Set your BeConnectEd password";

$message = "
Hello $first_name,

Your account has been created.

Please set your password using the secure link below:
$resetLink

This link will expire in 1 hour.

If you did not request this, please ignore this email.

Regards,
BeConnectEd Team
";

$headers  = "From: beconnected.system@gmail.com\r\n";
$headers .= "Reply-To: beconnected.system@gmail.com\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

mail($to, $subject, $message, $headers);


session_start();
$_SESSION['reset_link'] = $resetLink;

header("location: ../registration_admin.php?success=true");
exit();


?>







