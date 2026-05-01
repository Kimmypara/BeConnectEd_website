<?php
require_once "dbh.php";
session_start();

$teacher_id    = (int)($_SESSION['user_id'] ?? 0);
$submission_id = (int)($_POST['submission_id'] ?? 0);

$assignment_id = (int)($_POST['assignment_id'] ?? 0);
$unit_id       = (int)($_POST['unit_id'] ?? 0);
$class_id      = (int)($_POST['class_id'] ?? 0);

$mark     = ($_POST['mark'] !== '' ? (int)$_POST['mark'] : null);
$grade    = trim($_POST['grade'] ?? '');
$comments = trim($_POST['comments'] ?? '');

if ($teacher_id <= 0 || $submission_id <= 0) {
  header("Location: ../teachers_view_submissions.php?assignment_id={$assignment_id}&unit_id={$unit_id}&class_id={$class_id}&error=missingdata");
  exit();
}

$sqlStudent = "
  SELECT student_id
  FROM submission
  WHERE submission_id = ?
  LIMIT 1
";

$stmtStudent = mysqli_prepare($conn, $sqlStudent);
mysqli_stmt_bind_param($stmtStudent, "i", $submission_id);
mysqli_stmt_execute($stmtStudent);
$resultStudent = mysqli_stmt_get_result($stmtStudent);
$rowStudent = mysqli_fetch_assoc($resultStudent);

$student_id = (int)($rowStudent['student_id'] ?? 0);

mysqli_stmt_close($stmtStudent);

if ($student_id <= 0) {
  die("Student not found for this submission.");
}

// if empty grade, store NULL instead of empty string
$grade = ($grade === '') ? null : $grade;
$comments = ($comments === '') ? null : $comments;

// check existing
$check = mysqli_stmt_init($conn);
mysqli_stmt_prepare($check, "SELECT grade_id FROM grade WHERE submission_id=? AND teacher_id=? LIMIT 1");
mysqli_stmt_bind_param($check, "ii", $submission_id, $teacher_id);
mysqli_stmt_execute($check);
$res = mysqli_stmt_get_result($check);
$existing = mysqli_fetch_assoc($res);
mysqli_stmt_close($check);

if ($existing) {
  $grade_id = (int)$existing['grade_id'];
  $upd = mysqli_stmt_init($conn);
  mysqli_stmt_prepare($upd, "UPDATE grade SET mark=?, grade=?, comments=? WHERE grade_id=?");
  mysqli_stmt_bind_param($upd, "issi", $mark, $grade, $comments, $grade_id);
  mysqli_stmt_execute($upd);
  mysqli_stmt_close($upd);
}  else {
  $ins = mysqli_stmt_init($conn);
  mysqli_stmt_prepare($ins, "INSERT INTO grade (submission_id, teacher_id, mark, grade, comments) VALUES (?, ?, ?, ?, ?)");
  mysqli_stmt_bind_param($ins, "iiiss", $submission_id, $teacher_id, $mark, $grade, $comments);
  mysqli_stmt_execute($ins);

  // Get new grade ID
  $grade_id = mysqli_insert_id($conn);

  mysqli_stmt_close($ins);
}

//nitification
$sqlNotif = "
  INSERT INTO grade_notifications (student_id, unit_id, grade_id, is_read)
  VALUES (?, ?, ?, 0)
";

$stmtNotif = mysqli_prepare($conn, $sqlNotif);
mysqli_stmt_bind_param($stmtNotif, "iii", $student_id, $unit_id, $grade_id);
mysqli_stmt_execute($stmtNotif);
mysqli_stmt_close($stmtNotif);

header("Location: ../teachers_view_submissions.php?assignment_id={$assignment_id}&unit_id={$unit_id}&class_id={$class_id}&success=1");
exit();
