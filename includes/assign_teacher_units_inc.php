<?php
require_once "dbh.php";
require_once "functions.php";

if (!isset($_POST['submit'])) {
  header("Location: ../assign_teachers_admin.php");
  exit();
}

$user_ids  = $_POST['user_ids'] ?? [];
$unit_ids   = $_POST['unit_ids'] ?? [];

$teacher_id = (int)($user_ids[0] ?? 0);

if ($teacher_id <= 0 || !is_array($unit_ids)) {
  header("Location: ../assign_teachers_admin.php?error=missingdata");
  exit();
}


$clean = [];
foreach ($unit_ids as $uid) {
  $id = (int)$uid;
  if ($id > 0) $clean[] = $id;
}
$clean = array_values(array_unique($clean));

/*delete ONLY unit-level assignments for this teacher */
$sqlDel = "DELETE FROM unit_teacher WHERE teacher_id = ? AND class_id IS NULL";
$stmtDel = mysqli_stmt_init($conn);

if (!mysqli_stmt_prepare($stmtDel, $sqlDel)) {
  header("Location: ../assign_teachers_admin.php?error=stmtfailed");
  exit();
}

mysqli_stmt_bind_param($stmtDel, "i", $teacher_id);
mysqli_stmt_execute($stmtDel);
mysqli_stmt_close($stmtDel);

/* insert selected units*/
if (count($clean) > 0) {
  $sqlIns = "INSERT INTO unit_teacher (unit_id, teacher_id, class_id) VALUES (?, ?, NULL)";
  $stmtIns = mysqli_stmt_init($conn);

  if (!mysqli_stmt_prepare($stmtIns, $sqlIns)) {
    header("Location: ../assign_teachers_admin.php?error=stmtfailed");
    exit();
  }

   foreach ($clean as $unit_id) {
    mysqli_stmt_bind_param($stmtIns, "ii", $unit_id, $teacher_id);
    mysqli_stmt_execute($stmtIns);
  }
  mysqli_stmt_close($stmtIns);
}

header("Location: ../assign_teachers_admin.php?success=assigned");
exit();