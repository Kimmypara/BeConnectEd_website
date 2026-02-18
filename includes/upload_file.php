<?php
require_once "dbh.php";
require_once "functions.php";

if (!isset($_POST["uploadFile"]) || $_POST["uploadFile"] !== "upload") {
  header("location: ../students_assignments.php");
  exit();
}

session_start();

$student_id    = (int)($_SESSION["user_id"] ?? 0);
$assignment_id = (int)($_POST["assignment_id"] ?? 0);

if ($student_id <= 0 || $assignment_id <= 0) {
  header("location: ../students_assignments.php?error=missingdata");
  exit();
}

if (!isset($_FILES["userFile"]) || $_FILES["userFile"]["error"] === UPLOAD_ERR_NO_FILE) {
  header("location: ../students_assignments.php?error=nofile");
  exit();
}

$fileName    = $_FILES["userFile"]["name"];
$fileTmpName = $_FILES["userFile"]["tmp_name"];
$fileSize    = $_FILES["userFile"]["size"];
$fileError   = $_FILES["userFile"]["error"];

$allowed = ["pdf","pptx","docx","xlsx"];
$fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

if (!in_array($fileExt, $allowed, true)) {
  header("location: ../students_assignments.php?error=filetype");
  exit();
}

if ($fileError !== UPLOAD_ERR_OK) {
  header("location: ../students_assignments.php?error=fileUpload");
  exit();
}

if ($fileSize > 10000000) { 
  header("location: ../students_assignments.php?error=fileSize");
  exit();
}

$newFileName = uniqid($student_id . "-" . $assignment_id . "-", true) . "." . $fileExt;
$uploadDir = "../fileUploads/" . $newFileName;

if (!is_dir("../fileUploads/")) {
  mkdir("../fileUploads/", 0755, true);
}

if (!move_uploaded_file($fileTmpName, $uploadDir)) {
  header("location: ../students_assignments.php?error=movfailed");
  exit();
}

/*Save submission */
$checkSql = "SELECT submission_id FROM submission WHERE assignment_id=? AND student_id=? LIMIT 1";
$checkStmt = mysqli_stmt_init($conn);
mysqli_stmt_prepare($checkStmt, $checkSql);
mysqli_stmt_bind_param($checkStmt, "ii", $assignment_id, $student_id);
mysqli_stmt_execute($checkStmt);
$checkRes = mysqli_stmt_get_result($checkStmt);
$existing = mysqli_fetch_assoc($checkRes);
mysqli_stmt_close($checkStmt);

if ($existing) {
  $sql = "UPDATE submission SET file_path=?, submitted_at=NOW() WHERE submission_id=?";
  $stmt = mysqli_stmt_init($conn);
  mysqli_stmt_prepare($stmt, $sql);
  mysqli_stmt_bind_param($stmt, "si", $newFileName, $existing["submission_id"]);
  mysqli_stmt_execute($stmt);
  mysqli_stmt_close($stmt);
} else {
  $sql = "INSERT INTO submission (assignment_id, student_id, file_path, submitted_at)
          VALUES (?, ?, ?, NOW())";
  $stmt = mysqli_stmt_init($conn);
  mysqli_stmt_prepare($stmt, $sql);
  mysqli_stmt_bind_param($stmt, "iis", $assignment_id, $student_id, $newFileName);
  mysqli_stmt_execute($stmt);
  mysqli_stmt_close($stmt);
}

header("location: ../students_assignments.php?success=1&aid=" . $assignment_id);
exit();
