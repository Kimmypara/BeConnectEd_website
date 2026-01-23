<?php
require_once "dbh.php";
require_once "functions.php";

if (session_status() === PHP_SESSION_NONE) session_start();

if (empty($_SESSION["user_id"])) {
  header("Location: ../login.php");
  exit();
}

$user_id = (int)$_SESSION["user_id"];

// redirect target
$redirectPage = $_POST["redirect_to"] ?? "index.php";
$redirectPage = basename($redirectPage);

 
$sql = "SELECT profile_photo FROM users WHERE user_id = ?";
$stmt = mysqli_stmt_init($conn);

if (!mysqli_stmt_prepare($stmt, $sql)) {
  $_SESSION["profile_error"] = "Database error (select).";
  header("Location: ../" . $redirectPage);
  exit();
}

mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($res);
mysqli_stmt_close($stmt);

$filename = $row["profile_photo"] ?? "";

// set profile_photo to NULL
$sql2 = "UPDATE users SET profile_photo = NULL WHERE user_id = ?";
$stmt2 = mysqli_stmt_init($conn);

if (!mysqli_stmt_prepare($stmt2, $sql2)) {
  $_SESSION["profile_error"] = "Database error (update).";
  header("Location: ../" . $redirectPage);
  exit();
}

mysqli_stmt_bind_param($stmt2, "i", $user_id);
mysqli_stmt_execute($stmt2);
mysqli_stmt_close($stmt2);

//  delete file from folder
if (!empty($filename)) {
  $path = __DIR__ . "/../upload_images/" . $filename;
  if (is_file($path)) {
    @unlink($path);
  }
}


$_SESSION["profile_photo"] = "";
$_SESSION["profile_success"] = "Profile photo removed.";

header("Location: ../" . $redirectPage);
exit();
