<?php
require_once "dbh.php";
require_once "functions.php";

if (session_status() === PHP_SESSION_NONE) session_start();
if (empty($_SESSION["user_id"])) {
  header("Location: ../login.php");
  exit();
}

$user_id = (int)$_SESSION["user_id"];
$redirect = $_POST["redirect_to"] ?? "/BeConnectEd_website/index.php";
if (strpos($redirect, "/") !== 0) $redirect = "/BeConnectEd_website/index.php";

$temp = $_POST["temp_photo"] ?? "";
if ($temp === "") {
  header("Location: " . $redirect);
  exit();
}

$tmpPath = __DIR__ . "/../upload_tmp/" . basename($temp);
if (!file_exists($tmpPath)) {
  header("Location: " . $redirect);
  exit();
}

$finalDir = __DIR__ . "/../upload_images/";
if (!is_dir($finalDir)) mkdir($finalDir, 0777, true);

$ext = strtolower(pathinfo($temp, PATHINFO_EXTENSION));
$finalName = $user_id . "-" . uniqid("", true) . "." . $ext;
$finalPath = $finalDir . $finalName;

rename($tmpPath, $finalPath);

// Update DB
$sql = "UPDATE users SET profile_photo = ? WHERE user_id = ?";
$stmt = mysqli_stmt_init($conn);
mysqli_stmt_prepare($stmt, $sql);
mysqli_stmt_bind_param($stmt, "si", $finalName, $user_id);
mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

unset($_SESSION["pending_profile_photo"]);

header("Location: " . $redirect);
exit();
