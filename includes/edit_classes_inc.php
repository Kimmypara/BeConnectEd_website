<?php
require_once "dbh.php";
require_once "functions.php";

if (!isset($_POST["submit"])) {
  header("Location: ../classes_admin.php");
  exit();
}

$class_id   = (int)($_POST["class_id"] ?? 0);
$class_name = trim($_POST["class_name"] ?? "");
$course_id  = (int)($_POST["course_id"] ?? 0);

if ($class_id <= 0) {
  header("Location: ../classes_admin.php?error=missingclassid");
  exit();
}

// validation (optional but recommended)
$error = "";
if (emptyClassInput($class_name, $course_id)) $error .= "emptyinput=true&";
if (invalidClass_name($class_name)) $error .= "invalidClass_name=true&";

if ($error !== "") {
  header("Location: ../edit_class.php?class_id={$class_id}&error=true&{$error}");
  exit();
}

editClass($conn, $class_id, $class_name, $course_id);

header("Location: ../classes_admin.php?success=updated");
exit();
