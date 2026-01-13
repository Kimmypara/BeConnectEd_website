<?php
require_once "dbh.php";
require_once "functions.php";



error_reporting(E_ALL);
ini_set('display_errors', 1);

if (session_status() === PHP_SESSION_NONE) session_start();

if (empty($_SESSION["user_id"])) {
  header("Location: ../login.php");
  exit();
}

$user_id = (int)$_SESSION["user_id"];


//Redirect helper+ message
 
function back($redirectPage, $type, $msg) {
  if ($type === "error") $_SESSION["profile_error"] = $msg;
  if ($type === "success") $_SESSION["profile_success"] = $msg;
  header("Location: ../" . $redirectPage);
  exit();
}

/**
 * ✅ Redirect target (SAFE)
 * Expecting redirect_to like "admin_index.php" (NOT full path)
 */
$redirectPage = $_POST["redirect_to"] ?? "index.php";
$redirectPage = basename($redirectPage); // prevents /BeConnectEd_website/BeConnectEd_website/...

// Validate submit
if (!isset($_POST["uploadFile"]) || $_POST["uploadFile"] !== "upload") {
  back($redirectPage, "error", "Invalid upload request.");
}

// Validate file presence
if (!isset($_FILES["userFile"])) {
  back($redirectPage, "error", "No file received.");
}

$f = $_FILES["userFile"];

// Handle PHP upload errors (this is what happens with large files)
if ($f["error"] !== UPLOAD_ERR_OK) {
  if ($f["error"] === UPLOAD_ERR_INI_SIZE || $f["error"] === UPLOAD_ERR_FORM_SIZE) {
    back($redirectPage, "error", "File too large. Please choose an image under 5MB.");
  }
  if ($f["error"] === UPLOAD_ERR_NO_FILE) {
    back($redirectPage, "error", "No file selected.");
  }
  back($redirectPage, "error", "Upload failed (error code: {$f['error']}).");
}

// Basic file info
$fileName = $f["name"];
$fileTmp  = $f["tmp_name"];
$fileSize = $f["size"];

// Validate extension
$allowed = ["jpg", "jpeg", "png", "webp"];
$ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

if (!in_array($ext, $allowed, true)) {
  back($redirectPage, "error", "Invalid file type. Please upload JPG, PNG, or WEBP.");
}

// Validate size (your own limit)
$maxBytes = 5 * 1024 * 1024; // 5MB
if ($fileSize > $maxBytes) {
  back($redirectPage, "error", "File too large. Please choose an image under 5MB.");
}

// Ensure folder exists
$uploadDir = __DIR__ . "/../upload_images/";
if (!is_dir($uploadDir)) {
  mkdir($uploadDir, 0777, true);
}

if (!is_writable($uploadDir)) {
  back($redirectPage, "error", "Server error: upload_images folder is not writable.");
}

// Move file
$newFileName = $user_id . "-" . uniqid("", true) . "." . $ext;
$targetPath  = $uploadDir . $newFileName;

if (!move_uploaded_file($fileTmp, $targetPath)) {
  back($redirectPage, "error", "Server error: could not save the uploaded file.");
}

// Save filename in DB
$sql = "UPDATE users SET profile_photo = ? WHERE user_id = ?";
$stmt = mysqli_stmt_init($conn);

if (!mysqli_stmt_prepare($stmt, $sql)) {
  back($redirectPage, "error", "Database error: could not update profile photo.");
}

mysqli_stmt_bind_param($stmt, "si", $newFileName, $user_id);
mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

back($redirectPage, "success", "Profile photo updated.");
