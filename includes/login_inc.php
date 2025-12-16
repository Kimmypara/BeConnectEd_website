<?php
require_once "dbh.php";
require_once "functions.php";

if (!isset($_POST["submit"])) {
    header("location: ../login_institute.php");
    exit();
}

$email = $_POST["email"];
$password = $_POST["password"];

if (empty($email) || empty($password)) {
    header("location: ../login_institute.php?error=emptyinput");
    exit();
}

// Get user by email
$sql = "SELECT * FROM users WHERE email = ?";
$stmt = mysqli_stmt_init($conn);

if (!mysqli_stmt_prepare($stmt, $sql)) {
    header("location: ../login_institute.php?error=stmtfailed");
    exit();
}

mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$user = mysqli_fetch_assoc($result);

if (!$user) {
    header("location: ../login_institute.php?error=incorrectlogin");
    exit();
}

// Verify password
if (!password_verify($password, $user["password_hash"])) {
    header("location: ../login_institute.php?error=incorrectlogin");
    exit();
}

// Login success
session_start();
session_regenerate_id(true);

$_SESSION["user_id"] = $user["user_id"];
$_SESSION["email"] = $user["email"];
$_SESSION["role_id"] = $user["role_id"];
$_SESSION["first_name"] = $user["first_name"];
$_SESSION["last_name"] = $user["last_name"];



// 🚦 Role-based redirect
    switch ($user['role_id']) {

        case 1: // Admin
            header("Location: ../teacher_index.php");
            break;

        case 2: // Teacher
            header("Location: ../student_index.php");
            break;

        case 3: // Student
            header("Location: ../parent_index.php");
            break;

        case 4: // Parent
            header("Location: ../admin_index.php");
            break;

             case 5: // Parent
            header("Location: ../independent_index.php");
            break;

        default:
            // Safety fallback
            header("Location: ../login_institute.php?error=invalidrole");
            break;
    }

    exit(); 


