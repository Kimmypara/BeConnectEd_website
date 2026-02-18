<?php
require_once "dbh.php";

if (session_status() === PHP_SESSION_NONE) session_start();

if (!isset($_POST["uploadFile"]) || $_POST["uploadFile"] !== "upload") {
  header("Location: ../teaching_units_teacher.php");
  exit();
}

$teacher_id = (int)($_SESSION['user_id'] ?? 0);
$unit_id    = (int)($_POST['unit_id'] ?? 0);
$class_id   = (int)($_POST['class_id'] ?? 0);
$category   = trim($_POST['category'] ?? '');
$notes      = trim($_POST['notes'] ?? '');

if ($teacher_id <= 0 || $unit_id <= 0 || $class_id <= 0 || $category === '') {
  header("Location: ../teacher_upload_file.php?unit_id=$unit_id&class_id=$class_id&error=missingdata");
  exit();
}

if (!isset($_FILES["userFile"]) || $_FILES["userFile"]["error"] === UPLOAD_ERR_NO_FILE) {
  header("Location: ../teacher_upload_file.php?unit_id=$unit_id&class_id=$class_id&error=nofile");
  exit();
}

$fileName    = $_FILES["userFile"]["name"];
$fileTmpName = $_FILES["userFile"]["tmp_name"];
$fileSize    = $_FILES["userFile"]["size"];
$fileError   = $_FILES["userFile"]["error"];

$allowed = ["pdf","pptx","docx","xlsx"];
$fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

if (!in_array($fileExt, $allowed, true)) {
  header("Location: ../teacher_upload_file.php?unit_id=$unit_id&class_id=$class_id&error=filetype");
  exit();
}
if ($fileError !== UPLOAD_ERR_OK) {
  header("Location: ../teacher_upload_file.php?unit_id=$unit_id&class_id=$class_id&error=fileUpload");
  exit();
}
if ($fileSize > 10000000) {
  header("Location: ../teacher_upload_file.php?unit_id=$unit_id&class_id=$class_id&error=fileSize");
  exit();
}

$newFileName = uniqid($teacher_id . "-" . $unit_id . "-" . $class_id . "-", true) . "." . $fileExt;
$uploadDir   = "../fileUploads/" . $newFileName;

if (!is_dir("../fileUploads/")) {
  mkdir("../fileUploads/", 0755, true);
}

if (!move_uploaded_file($fileTmpName, $uploadDir)) {
  header("Location: ../teacher_upload_file.php?unit_id=$unit_id&class_id=$class_id&error=movfailed");
  exit();
}

$sql = "INSERT INTO file (unit_id, class_id, uploaded_by, file_name, category, file_path, notes)
        VALUES (?, ?, ?, ?, ?, ?, ?)";
$stmt = mysqli_stmt_init($conn);
if (!mysqli_stmt_prepare($stmt, $sql)) {
  @unlink($uploadDir);
  die("SQL prepare failed: " . mysqli_error($conn));
}

mysqli_stmt_bind_param($stmt, "iiissss",
  $unit_id, $class_id, $teacher_id, $fileName, $category, $newFileName, $notes
);
mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

header("Location: ../teachers_files.php?unit_id=$unit_id&class_id=$class_id&success=1");
exit();
