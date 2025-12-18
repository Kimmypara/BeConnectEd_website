<?php
require_once "dbh.php";

if (isset($_GET['course_id'], $_GET['action'])) {

    $course_id = (int) $_GET['course_id'];
    $action = $_GET['action'];

    if ($action === 'activate') {
        $status = 1;
    } elseif ($action === 'deactivate') {
        $status = 0;
    } else {
        die("Invalid action");
    }

    $sql = "UPDATE course SET is_active = ? WHERE course_id = ?";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        die("SQL error");
    }

    mysqli_stmt_bind_param($stmt, "ii", $status, $course_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("Location: ../courses_admin.php");
    exit();
}

die("Missing parameters");
