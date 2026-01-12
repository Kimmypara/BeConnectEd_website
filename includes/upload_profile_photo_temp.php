<?php
require_once "dbh.php";
require_once "functions.php";

header('Content-Type: application/json');

if (session_status() === PHP_SESSION_NONE) session_start();
if (empty($_SESSION["user_id"])) {
  echo json_encode(["ok" => false, "error" => "Not logged in"]);
  exit();
}

if (empty($_FILES["userFile"])) {
  echo json_encode(["ok" => false, "error" => "No file"]);
  exit();
}

$file = $_FILES["userFile"];

if ($file["error"] !== 0) {
  echo json_encode(["ok" => false, "error" => "Upload error"]);
  exit();
}

$allowed = ["jpg","jpeg","png","webp"];
$ext = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));

if (!in_array($ext, $allowed)) {
  echo json_encode(["ok" => false, "error" => "Invalid file type"]);
  exit();
}

if ($file["size"] > 5 * 1024 * 1024) {
  echo json_encode(["ok" => false, "error" => "File too large (max 5MB)"]);
  exit();
}

$tmpDir = __DIR__ . "/../assets/upload_tmp/";
if (!is_dir($tmpDir)) {
  echo json_encode(["ok" => false, "error" => "upload_tmp folder missing"]);
  exit();
}
if (!is_writable($tmpDir)) {
  echo json_encode(["ok" => false, "error" => "upload_tmp not writable"]);
  exit();
}

$user_id = (int)$_SESSION["user_id"];
$newName = "tmp-" . $user_id . "-" . uniqid("", true) . "." . $ext;
$target = $tmpDir . $newName;

if (!move_uploaded_file($file["tmp_name"], $target)) {
  echo json_encode(["ok" => false, "error" => "Could not move file"]);
  exit();
}

// Optional: remember pending temp file in session
$_SESSION["pending_profile_photo"] = $newName;

echo json_encode([
  "ok" => true,
  "filename" => $newName,
  "url" => "upload_tmp/" . $newName
]);
