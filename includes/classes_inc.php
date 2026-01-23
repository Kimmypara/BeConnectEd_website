<?php
require_once "dbh.php";
require_once "functions.php";

if (!isset($_POST["submit"])) {
  header("location: ../classes_admin.php");
  exit();
}

$class_name = trim($_POST['class_name'] ?? "");
$course_id  = (int)($_POST['course_id'] ?? 0);

$error = "";

// Validation
if (emptyClassInput($class_name, $course_id)) {
  $error .= "emptyinput=true&";
}

if (invalidClass_name($class_name)) {
  $error .= "invalidClass_name=true&";
}

if ($course_id <= 0) {
  $error .= "invalidCourse=true&";
}

if ($error !== "") {
 
  $error = rtrim($error, "&");
  header("location: ../classes_admin.php?error=true&$error");
  exit();
}

// INSERT into DB
$sql = "INSERT INTO classes (class_name, course_id) VALUES (?, ?)";
$stmt = mysqli_stmt_init($conn);

if (!mysqli_stmt_prepare($stmt, $sql)) {
  header("location: ../classes_admin.php?error=true&stmtfailed=true");
  exit();
}

mysqli_stmt_bind_param($stmt, "si", $class_name, $course_id);
mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

// Success
header("location: ../classes_admin.php?success=class_added");
exit();
