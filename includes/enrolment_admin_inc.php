<?php
require_once "dbh.php";
require_once "functions.php";

// Must be POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  header("Location: ../enrolment_admin.php");
  exit();
}


$isAdd  = isset($_POST['add_student']);


$course_id  = (int)($_POST['course_id'] ?? 0);
$student_id = (int)($_POST['student_id'] ?? 0);

if ($course_id <= 0 || $student_id <= 0) {
  header("Location: ../enrolment_admin.php?error=missingdata");
  exit();
}


if (enrolmentExists($conn, $student_id, $course_id)) {
  header("Location: ../enrolment_admin.php?error=alreadyenrolled");
  exit();
}


$sql = "INSERT INTO enrolment (student_id, course_id) VALUES (?, ?)";
$stmt = mysqli_stmt_init($conn);

if (!mysqli_stmt_prepare($stmt, $sql)) {
  header("Location: ../enrolment_admin.php?error=stmtfailed");
  exit();
}

mysqli_stmt_bind_param($stmt, "ii", $student_id, $course_id);
mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

// Redirect back
header("Location: ../enrolment_admin.php?success=added&course_id=" . $course_id);
exit();
