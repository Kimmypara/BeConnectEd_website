<?php
require_once "dbh.php";
require_once "functions.php";

error_reporting(E_ALL);
ini_set('display_errors', 1);

if (session_status() === PHP_SESSION_NONE) session_start();

if (!isset($_SESSION["user_id"])) {
  header("Location: ../login.php");
  exit();
}

$user_id = (int)$_SESSION["user_id"];

// Where to go back
$redirect = $_POST['redirect_to'] ?? '/BeConnectEd_website/index.php';
if (strpos($redirect, '/') !== 0) {
  $redirect = '/BeConnectEd_website/index.php';
}

// Validate the submit + file
if (!isset($_POST["uploadFile"]) || $_POST["uploadFile"] !== "upload") {
  header("Location: ../" . ltrim($redirect, "/"));
  exit();
}

if (!isset($_FILES["userFile"]) || $_FILES["userFile"]["error"] === UPLOAD_ERR_NO_FILE) {
  header("Location: ../" . ltrim($redirect, "/"));
  exit();
}

$fileName = $_FILES["userFile"]["name"];
$fileTmp  = $_FILES["userFile"]["tmp_name"];
$fileSize = $_FILES["userFile"]["size"];
$fileErr  = $_FILES["userFile"]["error"];

if ($fileErr !== UPLOAD_ERR_OK) {
  header("Location: ../" . ltrim($redirect, "/"));
  exit();
}

$allowed = ["jpg","jpeg","png","webp"];
$ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

if (!in_array($ext, $allowed)) {
  header("Location: ../" . ltrim($redirect, "/"));
  exit();
}

if ($fileSize > 5 * 1024 * 1024) { // 5MB
  header("Location: ../" . ltrim($redirect, "/"));
  exit();
}

// Ensure folder exists
$uploadDir = __DIR__ . "/../upload_images/";
if (!is_dir($uploadDir)) {
  mkdir($uploadDir, 0777, true);
}

if (!is_writable($uploadDir)) {
  die("upload_images folder is not writable");
}

$newFileName = $user_id . "-" . uniqid("", true) . "." . $ext;
$targetPath  = $uploadDir . $newFileName;

if (!move_uploaded_file($fileTmp, $targetPath)) {
  die("move_uploaded_file failed");
}

// Save filename in DB
$sql = "UPDATE users SET profile_photo = ? WHERE user_id = ?";
$stmt = mysqli_stmt_init($conn);

if (!mysqli_stmt_prepare($stmt, $sql)) {
  die("SQL prepare failed");
}

mysqli_stmt_bind_param($stmt, "si", $newFileName, $user_id);
mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

// ✅ redirect ONLY AFTER successful upload
header("Location: " . $redirect);
exit();



