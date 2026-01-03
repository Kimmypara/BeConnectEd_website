<?php
require_once "dbh.php";
require_once "functions.php";

if (!isset($_POST["submit"])) {
    header("location: ../courses_admin.php");
    exit();
}

$course_id = (int)($_GET["course_id"] ?? 0);
if ($course_id <= 0) {
    header("location: ../courses_admin.php?error=missingcourseid");
    exit();
}

$course_name = $_POST['course_name'] ?? "";
$course_code = $_POST['course_code'] ?? "";
$institute_id = $_POST['institute_id'] ?? "";
$is_active = $_POST['is_active'] ?? "";
$MQF_level = $_POST['MQF_Level'] ?? "";         
$duration = $_POST['duration'] ?? "";
$credits = $_POST['credits'] ?? "";
$course_description = $_POST['course_description'] ?? "";



editCourse($conn, $course_id, $course_name,  $course_code, $institute_id, $is_active,  $MQF_level,  $duration, $credits, $course_description  );

header("location: ../courses_admin.php?success=updated");
exit();
