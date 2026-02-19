<?php
require_once "dbh.php";
require_once "functions.php";
session_start();

if (!isset($_POST["uploadFile"]) || $_POST["uploadFile"] !== "upload") {
  header("Location: ../students_assignments.php");
  exit();
}

$student_id    = (int)($_SESSION["user_id"] ?? 0);
$assignment_id = (int)($_POST["assignment_id"] ?? 0);
$unit_id       = (int)($_POST["unit_id"] ?? 0);

if ($student_id <= 0 || $assignment_id <= 0 || $unit_id <= 0) {
  header("Location: ../students_assignments.php?unit_id={$unit_id}&error=missingdata");
  exit();
}

/* Expect multiple files */
if (!isset($_FILES["userFiles"]) || empty($_FILES["userFiles"]["name"][0])) {
  header("Location: ../students_assignments.php?unit_id={$unit_id}&error=nofile");
  exit();
}

$allowed = ["pdf","pptx","docx","xlsx"];
$maxSize = 10000000; // 10MB per file

$uploadDirFs = __DIR__ . "/../fileUploads/";
$uploadDirUrl = "../fileUploads/";

if (!is_dir($uploadDirFs)) {
  mkdir($uploadDirFs, 0755, true);
}

/* 1) Get or create submission row (one per student per assignment) */
$submission_id = 0;

$checkSql = "SELECT submission_id
             FROM submission
             WHERE assignment_id = ? AND student_id = ?
             LIMIT 1";
$st = mysqli_stmt_init($conn);
if (mysqli_stmt_prepare($st, $checkSql)) {
  mysqli_stmt_bind_param($st, "ii", $assignment_id, $student_id);
  mysqli_stmt_execute($st);
  $rs = mysqli_stmt_get_result($st);
  $existing = mysqli_fetch_assoc($rs);
  mysqli_stmt_close($st);

  if ($existing) {
    $submission_id = (int)$existing["submission_id"];
    // update timestamp to latest activity (optional)
    $up = mysqli_stmt_init($conn);
    if (mysqli_stmt_prepare($up, "UPDATE submission SET submitted_at = NOW() WHERE submission_id = ?")) {
      mysqli_stmt_bind_param($up, "i", $submission_id);
      mysqli_stmt_execute($up);
      mysqli_stmt_close($up);
    }
  }
}

if ($submission_id <= 0) {
  $ins = mysqli_stmt_init($conn);
  if (!mysqli_stmt_prepare($ins, "INSERT INTO submission (assignment_id, student_id, submitted_at) VALUES (?, ?, NOW())")) {
    header("Location: ../students_assignments.php?unit_id={$unit_id}&error=fileUpload");
    exit();
  }
  mysqli_stmt_bind_param($ins, "ii", $assignment_id, $student_id);
  mysqli_stmt_execute($ins);
  $submission_id = mysqli_insert_id($conn);
  mysqli_stmt_close($ins);
}

/* 2) Loop each file and insert into submission_files */
$uploadedAny = false;

for ($i = 0; $i < count($_FILES["userFiles"]["name"]); $i++) {

  $name = $_FILES["userFiles"]["name"][$i] ?? "";
  $tmp  = $_FILES["userFiles"]["tmp_name"][$i] ?? "";
  $size = (int)($_FILES["userFiles"]["size"][$i] ?? 0);
  $err  = (int)($_FILES["userFiles"]["error"][$i] ?? UPLOAD_ERR_NO_FILE);

  if ($err === UPLOAD_ERR_NO_FILE) continue;
  if ($err !== UPLOAD_ERR_OK) continue;
  if ($size <= 0 || $size > $maxSize) continue;

  $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
  if (!in_array($ext, $allowed, true)) continue;

  $newFileName = $submission_id . "-" . bin2hex(random_bytes(8)) . "." . $ext;
  $destFs = $uploadDirFs . $newFileName;

  if (!move_uploaded_file($tmp, $destFs)) continue;

  $uploadedAny = true;

  $sqlFile = "INSERT INTO submission_files (submission_id, file_path, original_name)
              VALUES (?, ?, ?)";
  $sf = mysqli_stmt_init($conn);
  if (mysqli_stmt_prepare($sf, $sqlFile)) {
    mysqli_stmt_bind_param($sf, "iss", $submission_id, $newFileName, $name);
    mysqli_stmt_execute($sf);
    mysqli_stmt_close($sf);
  }
}

if (!$uploadedAny) {
  // nothing valid uploaded (wrong type/too big/etc.)
  header("Location: ../students_assignments.php?unit_id={$unit_id}&error=filetype");
  exit();
}

header("Location: ../students_assignments.php?unit_id={$unit_id}&success=1");
exit();
