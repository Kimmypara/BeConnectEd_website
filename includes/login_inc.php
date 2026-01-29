<?php
require_once "dbh.php";
require_once "functions.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
  header("Location: ../login_institute.php");
  exit();
}

$login_type = $_POST["login_type"] ?? "institute"; // "institute" or "independent"
$back = ($login_type === "independent") ? "../login_independent.php" : "../login_institute.php";

$email = $_POST["email"] ?? "";
$password = $_POST["password"] ?? "";

if (trim($email) === "" || trim($password) === "") {
  header("Location: $back?error=emptyinput");
  exit();
}

// Get user by email
$sql = "SELECT * FROM users WHERE email = ?";
$stmt = mysqli_stmt_init($conn);

if (!mysqli_stmt_prepare($stmt, $sql)) {
  header("Location: $back?error=stmtfailed");
  exit();
}

mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

if (!$user) {
  header("Location: $back?error=emailnotfound");
  exit();
}

/*
  Enforce correct login route:
  - Independent login page: must be is_independent = 1
  - Institute login page: must be is_independent = 0
*/
if ($login_type === "independent" && (int)$user["is_independent"] !== 1) {
  header("Location: ../login_independent.php?error=notIndependentUser");
  exit();
}

if ($login_type === "institute" && (int)$user["is_independent"] === 1) {
  header("Location: ../login_institute.php?error=independentUser");
  exit();
}

// first time login (must change password)
if ((int)$user["must_change_password"] === 1) {
  header("Location: $back?error=mustchangepassword");
  exit();
}

// inactive user
if (isset($user["is_active"]) && (int)$user["is_active"] === 0) {
  header("Location: $back?error=inactive");
  exit();
}

// Verify password
if (!password_verify($password, $user["password_hash"])) {
  header("Location: $back?error=wrongpassword");
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




// Role-based redirect 
if ((int)$user["is_independent"] === 1) {

  // Independent dashboards
  switch ((int)$user["role_id"]) {
    case 1:
      header("Location: ../ind_teacher_index.php");
      break;

    case 2:
      header("Location: ../ind_student_index.php");
      break;

    default:
      header("Location: $back?error=invalidrole");
      break;
  }

} else {

  // Institute dashboards
  switch ((int)$user["role_id"]) {
    case 1:
      header("Location: ../teacher_index.php");
      break;

    case 2:
      header("Location: ../student_index.php");
      break;

    case 3:
      header("Location: ../parent_index.php");
      break;

    case 4:
      header("Location: ../admin_index.php");
      break;

    default:
      header("Location: $back?error=invalidrole");
      break;
  }
}

exit();
