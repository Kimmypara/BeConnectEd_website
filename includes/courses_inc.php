<?php

require_once "dbh.php";
require_once "functions.php";

// Check if form submitted
if (!isset($_POST["submit"])) {
    header("location: ../add_course.php");
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

   $error = "";

// Run validation
if (emptyCourseInput($course_name,  $course_code, $institute_id, $is_active,  $MQF_level,  $duration,$credits,$course_description  )) {
   

    $error = $error."emptyinput=true&";
}

 if(invalidCourse_name($course_name)){
            $error = $error."invalidCourse_name=true&";
        }

        if(invalidCourse_code($course_code)){
            $error = $error."invalidCourse_code=true&";
        }

        if (courseCodeExists($conn, $course_code)) {
    $error .= "courseCodeExists=true&";
}

        if(invalidMQF_Level($MQF_level)){
            $error = $error."invalidMQF_Level=true&";
        }

          if(invalidCredits($credits)){
            $error = $error."invalidCredits=true&";
        }

           if(invalidDuration($duration)){
            $error = $error."invalidDuration=true&";
        }

            if ($error != "") {
    header("location: ../add_course.php?error=true&$error");
    exit();
}




?>

