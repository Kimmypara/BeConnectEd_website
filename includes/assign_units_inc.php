<?php
require_once "dbh.php";

if (!isset($_POST['submit'])) {
  header("Location: ../courses_admin.php");
  exit();
}

$course_id = (int)($_POST['course_id'] ?? 0);
$unit_ids  = $_POST['unit_ids'] ?? [];

if ($course_id <= 0 || !is_array($unit_ids) || count($unit_ids) === 0) {
  header("Location: ../courses_admin.php?error=missingdata");
  exit();
}

$sql = "INSERT IGNORE INTO course_units (course_id, unit_id) VALUES (?, ?)";
$stmt = mysqli_stmt_init($conn);

if (!mysqli_stmt_prepare($stmt, $sql)) {
  header("Location: ../courses_admin.php?error=stmtfailed");
  exit();
}

foreach ($unit_ids as $uid) {
  $unit_id = (int)$uid;
  if ($unit_id > 0) {
    mysqli_stmt_bind_param($stmt, "ii", $course_id, $unit_id);
    mysqli_stmt_execute($stmt);
  }
}

mysqli_stmt_close($stmt);

header("Location: ../courses_admin.php?success=units_assigned");
exit();
