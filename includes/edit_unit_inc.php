<?php
require_once "dbh.php";
require_once "functions.php";

if (!isset($_POST["submit"])) {
    header("location: ../courses_admin.php");
    exit();
}

$unit_id = (int)($_GET["unit_id"] ?? 0);
if ($unit_id <= 0) {
    header("location: ../courses_admin.php?error=missingcourseid");
    exit();
}

$unit_name = trim($_POST['unit_name'] ?? "");
$unit_code = trim($_POST['unit_code'] ?? "");
$ects_credits = trim($_POST['ects_credits'] ?? "");
$unit_description = trim($_POST['unit_description'] ?? "");
$is_active = $_POST['is_active'] ?? "";
$unit_duration = trim($_POST['unit_duration'] ?? "");



editUnit($conn, $unit_id, $unit_name,  $unit_code, $ects_credits, $unit_description,  $is_active,  $unit_duration );

header("location: ../courses_admin.php?success=updated");
exit();
