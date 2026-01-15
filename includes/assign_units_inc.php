<?php
require_once "dbh.php";
require_once "functions.php";

if (!isset($_POST['submit'])) {
  header("Location: ../courses_admin.php");
  exit();
}

$course_id = (int)($_POST['course_id'] ?? 0);
$unit_ids  = $_POST['unit_ids'] ?? [];

if ($course_id <= 0 || !is_array($unit_ids)) {
  header("Location: ../courses_admin.php?error=missingdata");
  exit();
}


$clean = [];
foreach ($unit_ids as $uid) {
  $id = (int)$uid;
  if ($id > 0) $clean[] = $id;
}
$clean = array_values(array_unique($clean));

//  delete all current assignments for this course
$sqlDel = "DELETE FROM course_units WHERE course_id = ?";
$stmtDel = mysqli_stmt_init($conn);
if (!mysqli_stmt_prepare($stmtDel, $sqlDel)) {
  header("Location: ../courses_admin.php?error=stmtfailed");
  exit();
}
mysqli_stmt_bind_param($stmtDel, "i", $course_id);
mysqli_stmt_execute($stmtDel);
mysqli_stmt_close($stmtDel);

// 2) insert the remaining ones (if any)
if (count($clean) > 0) {
  $sqlIns = "INSERT INTO course_units (course_id, unit_id) VALUES (?, ?)";
  $stmtIns = mysqli_stmt_init($conn);

  if (!mysqli_stmt_prepare($stmtIns, $sqlIns)) {
    header("Location: ../courses_admin.php?error=stmtfailed");
    exit();
  }

  foreach ($clean as $unit_id) {
    mysqli_stmt_bind_param($stmtIns, "ii", $course_id, $unit_id);
    mysqli_stmt_execute($stmtIns);
  }

  mysqli_stmt_close($stmtIns);
}

header("Location: ../courses_admin.php?success=units_updated");
exit();
