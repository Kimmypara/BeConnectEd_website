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
$sqlCheck = "
  SELECT file_id
  FROM file
  WHERE unit_id = ?
  AND class_id = ?
  AND file_name = ?
  LIMIT 1
";

$stmtCheck = mysqli_prepare($conn, $sqlCheck);
mysqli_stmt_bind_param($stmtCheck, "iis", $unit_id, $class_id, $fileName);
mysqli_stmt_execute($stmtCheck);
$resultCheck = mysqli_stmt_get_result($stmtCheck);

if (mysqli_num_rows($resultCheck) > 0) {
  header("Location: ../teacher_upload_file.php?unit_id=$unit_id&class_id=$class_id&error=duplicate");
  exit();
}

mysqli_stmt_close($stmtCheck);


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



// Get the uploaded file ID
$file_id = mysqli_insert_id($conn);

mysqli_stmt_close($stmt);

// Create notifications for students in this class/unit
$sqlStudents = "
  SELECT DISTINCT student_id
  FROM enrolment
  WHERE class_id = ?
";

$stmtStudents = mysqli_stmt_init($conn);

if (mysqli_stmt_prepare($stmtStudents, $sqlStudents)) {
  mysqli_stmt_bind_param($stmtStudents, "i", $class_id);
  mysqli_stmt_execute($stmtStudents);
  $resultStudents = mysqli_stmt_get_result($stmtStudents);

  while ($student = mysqli_fetch_assoc($resultStudents)) {
    $student_id = $student['student_id'];

    $sqlNotif = "
      INSERT INTO file_notifications (student_id, unit_id, class_id, file_id, is_read)
      VALUES (?, ?, ?, ?, 0)
    ";

    $stmtNotif = mysqli_stmt_init($conn);

    if (mysqli_stmt_prepare($stmtNotif, $sqlNotif)) {
      mysqli_stmt_bind_param($stmtNotif, "iiii", $student_id, $unit_id, $class_id, $file_id);
      mysqli_stmt_execute($stmtNotif);
      mysqli_stmt_close($stmtNotif);
    }
  }

  mysqli_stmt_close($stmtStudents);
}

header("Location: ../teachers_files.php?unit_id=$unit_id&class_id=$class_id&success=1");
exit();
