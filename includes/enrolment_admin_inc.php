<?php
session_start();
require_once "dbh.php";

$course_id  = (int)($_POST['course_id'] ?? 0);
$class_id   = (int)($_POST['class_id'] ?? 0);
$student_id = (int)($_POST['student_id'] ?? 0);

function goBack($course_id, $class_id, $extra = "") {
    $url = "../enrolment_admin.php";
    if ($course_id > 0) {
        $url .= "?course_id=" . $course_id;
        if ($class_id > 0) $url .= "&class_id=" . $class_id;
    }
    if ($extra) $url .= ($course_id > 0 ? "&" : "?") . $extra;
    header("Location: " . $url);
    exit();
}

if (isset($_POST['add'])) {

    if ($course_id <= 0 || $class_id <= 0 || $student_id <= 0) {
        goBack($course_id, $class_id, "error=missing");
    }

    // Prevent duplicates student in same class
    $checkSql = "SELECT enrolment_id
                FROM enrolment
                WHERE student_id = ? AND course_id = ? AND class_id = ?";

    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $checkSql)) {
        die("Prepare failed: " . mysqli_error($conn));
    }

    mysqli_stmt_bind_param($stmt, "iii", $student_id, $course_id, $class_id);
    mysqli_stmt_execute($stmt);
    $checkRes = mysqli_stmt_get_result($stmt);

    if ($checkRes && mysqli_num_rows($checkRes) > 0) {
        mysqli_stmt_close($stmt);
        goBack($course_id, $class_id, "error=already_enrolled");
    }
    mysqli_stmt_close($stmt);

    // Insert
    $insertSql = "INSERT INTO enrolment (student_id, course_id, class_id) VALUES (?, ?, ?)";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $insertSql)) {
        die("Prepare failed: " . mysqli_error($conn));
    }

    mysqli_stmt_bind_param($stmt, "iii", $student_id, $course_id, $class_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    goBack($course_id, $class_id, "success=added");
}

if (isset($_POST['remove'])) {

    if ($class_id <= 0 || $student_id <= 0) {
        goBack($course_id, $class_id, "error=missing");
    }

    // Delete based on class + student only
    $deleteSql = "DELETE FROM enrolment
                  WHERE student_id = ? AND class_id = ?
                  LIMIT 1";

    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $deleteSql)) {
        die("Prepare failed: " . mysqli_error($conn));
    }

    mysqli_stmt_bind_param($stmt, "ii", $student_id, $class_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    goBack($course_id, $class_id, "success=removed");
}


goBack($course_id, $class_id);
