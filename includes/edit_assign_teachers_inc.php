<?php
require_once "dbh.php";
require_once "functions.php";

if (!isset($_POST["submit"])) {
  header("Location: ../assign_teachers_admin.php");
  exit();
}

$teacher_id = (int)($_POST["teacher_id"] ?? 0);
$class_id   = (int)($_POST["class_id"] ?? 0);
$unit_ids   = $_POST["unit_ids"] ?? [];

if ($teacher_id <= 0 || $class_id <= 0 || !is_array($unit_ids)) {
  header("Location: ../assign_teachers_admin.php?error=missingdata");
  exit();
}

// clean unit ids
$clean = [];
foreach ($unit_ids as $uid) {
  $id = (int)$uid;
  if ($id > 0) $clean[] = $id;
}
$clean = array_values(array_unique($clean));

if (count($clean) === 0) {
  header("Location: ../edit_assign_teachers_admin.php?teacher_id=$teacher_id&class_id=$class_id&error=nouunits");
  exit();
}

// delete existing for that teacher+class
$sqlDel = "DELETE FROM unit_teacher WHERE teacher_id = ? AND class_id = ?";
$stmtDel = mysqli_stmt_init($conn);
if (!mysqli_stmt_prepare($stmtDel, $sqlDel)) {
  header("Location: ../edit_assign_teachers_admin.php?teacher_id=$teacher_id&class_id=$class_id&error=stmtfailed");
  exit();
}
mysqli_stmt_bind_param($stmtDel, "ii", $teacher_id, $class_id);
mysqli_stmt_execute($stmtDel);
mysqli_stmt_close($stmtDel);

// insert new
$sqlIns = "INSERT INTO unit_teacher (unit_id, class_id, teacher_id) VALUES (?, ?, ?)";
$stmtIns = mysqli_stmt_init($conn);
if (!mysqli_stmt_prepare($stmtIns, $sqlIns)) {
  header("Location: ../edit_assign_teachers_admin.php?teacher_id=$teacher_id&class_id=$class_id&error=stmtfailed");
  exit();
}

foreach ($clean as $unit_id) {
  mysqli_stmt_bind_param($stmtIns, "iii", $unit_id, $class_id, $teacher_id);
  mysqli_stmt_execute($stmtIns);
}
mysqli_stmt_close($stmtIns);

header("Location: ../edit_assign_teachers_admin.php?teacher_id=$teacher_id&class_id=$class_id&success=1");
exit();
