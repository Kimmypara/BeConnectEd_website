<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
require_once "dbh.php";

$file_id = (int)($_GET['file_id'] ?? 0);
$student_id = (int)($_SESSION['user_id'] ?? 0);

if ($student_id <= 0 || $file_id <= 0) {
  http_response_code(400);
  exit("Invalid request.");
}

// Get file record only if student is enrolled in the unit's course
$sql = "
  SELECT f.file_name, f.file_path, f.unit_id
  FROM file f
  INNER JOIN course_units cu ON cu.unit_id = f.unit_id
  INNER JOIN enrolment e ON e.course_id = cu.course_id
  WHERE f.file_id = ?
    AND e.student_id = ?
  LIMIT 1
";

$stmt = mysqli_stmt_init($conn);
mysqli_stmt_prepare($stmt, $sql);
mysqli_stmt_bind_param($stmt, "ii", $file_id, $student_id);
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);
$file = mysqli_fetch_assoc($res);
mysqli_stmt_close($stmt);

if (!$file) {
  http_response_code(403);
  exit("Not allowed or file not found.");
}

$stored = basename($file['file_path']);
$path = "../fileUploads/" . $stored; 

if (!file_exists($path)) {
  http_response_code(404);
  exit("File missing.");
}

header("Content-Type: application/octet-stream");
header("Content-Disposition: attachment; filename=\"" . basename($file['file_name']) . "\"");
header("Content-Length: " . filesize($path));
readfile($path);
exit();
