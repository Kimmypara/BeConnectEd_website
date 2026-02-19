<?php
session_start();
require_once "dbh.php";

$submission_file_id = (int)($_POST["submission_file_id"] ?? 0);
$unit_id = (int)($_POST["unit_id"] ?? 0);
$student_id = (int)($_SESSION["user_id"] ?? 0);

if ($submission_file_id <= 0 || $student_id <= 0 || $unit_id <= 0) {
  header("Location: ../students_assignments.php?unit_id={$unit_id}&error=missingdata");
  exit();
}

$sql = "SELECT sf.file_path, s.student_id
        FROM submission_files sf
        JOIN submission s ON s.submission_id = sf.submission_id
        WHERE sf.submission_file_id = ?
        LIMIT 1";

$stmt = mysqli_stmt_init($conn);
if (!mysqli_stmt_prepare($stmt, $sql)) {
  header("Location: ../students_assignments.php?unit_id={$unit_id}&error=fileUpload");
  exit();
}
mysqli_stmt_bind_param($stmt, "i", $submission_file_id);
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($res);
mysqli_stmt_close($stmt);

if (!$row || (int)$row["student_id"] !== $student_id) {
  header("Location: ../students_assignments.php?unit_id={$unit_id}&error=notallowed");
  exit();
}

$fileFs = __DIR__ . "/../fileUploads/" . basename($row["file_path"]);

$del = mysqli_stmt_init($conn);
mysqli_stmt_prepare($del, "DELETE FROM submission_files WHERE submission_file_id = ?");
mysqli_stmt_bind_param($del, "i", $submission_file_id);
mysqli_stmt_execute($del);
mysqli_stmt_close($del);

if (is_file($fileFs)) unlink($fileFs);

header("Location: ../students_assignments.php?unit_id={$unit_id}&success=1");
exit();
