<?php
require_once "dbh.php";
session_start();

if (!isset($_POST["submit"])) {
  header("Location: ../teacher_open_submissions.php");
  exit();
}

$teacher_id = (int)($_SESSION["user_id"] ?? 0);
$unit_id    = (int)($_POST["unit_id"] ?? 0);
$class_id   = (int)($_POST["class_id"] ?? 0);

$task_title  = trim($_POST["task_title"] ?? "");
$due_date    = trim($_POST["due_date"] ?? "");
$description = trim($_POST["description"] ?? "");

if ($teacher_id <= 0 || $unit_id <= 0 || $class_id <= 0 || $task_title === "") {
  header("Location: ../teacher_open_submissions.php?unit_id=$unit_id&class_id=$class_id&error=create_failed");
  exit();
}

/* 1. Insert assignment ONCE */
$sql = "
  INSERT INTO assignment 
  (unit_id, class_id, teacher_id, task_title, due_date, description)
  VALUES (?, ?, ?, ?, NULLIF(?, ''), NULLIF(?, ''))
";

$stmt = mysqli_stmt_init($conn);

if (!mysqli_stmt_prepare($stmt, $sql)) {
  header("Location: ../teacher_open_submissions.php?unit_id=$unit_id&class_id=$class_id&error=create_failed");
  exit();
}

mysqli_stmt_bind_param($stmt, "iiisss", $unit_id, $class_id, $teacher_id, $task_title, $due_date, $description);
mysqli_stmt_execute($stmt);

/* 2. Get new assignment ID */
$assignment_id = mysqli_insert_id($conn);

mysqli_stmt_close($stmt);

/* 3. Create notifications for students */
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
    $student_id = (int)$student["student_id"];

    $sqlNotif = "
      INSERT INTO assignment_notifications
      (student_id, unit_id, class_id, assignment_id, is_read)
      VALUES (?, ?, ?, ?, 0)
    ";

    $stmtNotif = mysqli_stmt_init($conn);

    if (mysqli_stmt_prepare($stmtNotif, $sqlNotif)) {
      mysqli_stmt_bind_param($stmtNotif, "iiii", $student_id, $unit_id, $class_id, $assignment_id);
      mysqli_stmt_execute($stmtNotif);
      mysqli_stmt_close($stmtNotif);
    }
  }

  mysqli_stmt_close($stmtStudents);
}

header("Location: ../teacher_open_submissions.php?unit_id=$unit_id&class_id=$class_id&success=assignment_created");
exit();