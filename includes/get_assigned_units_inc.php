<?php
require_once "dbh.php";

header('Content-Type: application/json');

$course_id = (int)($_GET['course_id'] ?? 0);
if ($course_id <= 0) {
  echo json_encode([]);
  exit();
}

$sql = "SELECT unit.unit_id, unit.unit_code, unit.unit_name, unit.ects_credits, unit.is_active
        FROM course_units 
        INNER JOIN unit  ON course_units.unit_id = unit.unit_id
        WHERE course_units.course_id = ?
        ORDER BY unit.unit_code";

$stmt = mysqli_stmt_init($conn);
if (!mysqli_stmt_prepare($stmt, $sql)) {
  http_response_code(500);
  echo json_encode(["error" => "stmtfailed"]);
  exit();
}

mysqli_stmt_bind_param($stmt, "i", $course_id);
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);

$units = [];
while ($row = mysqli_fetch_assoc($res)) {
  $units[] = $row;
}

mysqli_stmt_close($stmt);

echo json_encode($units);
