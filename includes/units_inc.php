<?php
require_once "dbh.php";
require_once "functions.php";

// Only run if form submitted
if (!isset($_POST["submit"])) {
    header("Location: ../add_unit.php");
    exit();
}

$unit_name = trim($_POST['unit_name'] ?? "");
$unit_code = trim($_POST['unit_code'] ?? "");
$ects_credits = trim($_POST['ects_credits'] ?? "");
$unit_description = trim($_POST['unit_description'] ?? "");
$is_active = $_POST['is_active'] ?? "";
$unit_duration = trim($_POST['unit_duration'] ?? "");

$error = "";

// Validation
if (emptyUnitInput($unit_name, $unit_code, $ects_credits, $is_active, $unit_description, $unit_duration)) {
    $error .= "emptyinput=true&";
}

if (invalidUnit_name($unit_name)) {
    $error .= "invalidUnit_name=true&";
}

if (invalidUnit_code($unit_code)) {
    $error .= "invalidUnit_code=true&";
}

if (unitCodeExists($conn, $unit_code)) {
    $error .= "unitCodeExists=true&";
}

if (invalidEcts_credits($ects_credits)) {
    $error .= "invalidEcts_credits=true&";
}

if (invalidUnit_duration($unit_duration)) {
    $error .= "invalidUnit_duration=true&";
}

// If any error -> go back
if ($error !== "") {
    header("Location: ../add_unit.php?error=true&" . $error);
    exit();
}

// insert into db
registerUnit(
    $conn,
    $unit_name,
    $unit_code,
    (int)$ects_credits,
    $unit_description,
    (int)$is_active,
    $unit_duration
);

// success redirect
header("Location: ../add_unit.php?success=true");
exit();
