
<?php
session_start();
include "includes/conditions.php";
include "includes/nav.php";
require_once "includes/dbh.php";
require_once "includes/functions.php";

$student_id = (int)($_SESSION['user_id'] ?? 0);
if ($student_id <= 0) {
    die("Not logged in.");
}

$res = getStudentEnrolmentWithUnits($conn, $student_id);

$hasRows = false;
$message = "";

if ($res === false) {
  $message = "Error loading enrolment.";
}


$current_course_id = null;
$current_class_id = null;
?>



<div class="container-fluid">
  <div class="row">

      <div class="col-lg-2 col-md-3 p-0">
          <?php include 'includes/menustudent.php'; ?>
      </div>
     

    <div class="col-1"></div>
  <div class="col-lg-9 col-md-8">
      <div class="row">  
        <div class="col-12">  
            <div class="form_bg">
            
            <div class="row">
              <div class="col-lg-12">

<?php while ($row = mysqli_fetch_assoc($res)): ?>
  <?php $hasRows = true; ?>

  <div class="course-section mb-3">
     <hr class="divider">

    <div class="course-col">
      <div class="title">Course Title:
        <p class="label"><?php echo '&nbsp;&nbsp;' . htmlspecialchars($row['course_name']); ?></p>
      </div>

      <div class="title">Course Code:
        <p class="label"><?php echo '&nbsp;&nbsp;' . htmlspecialchars($row['course_code']); ?></p>
      </div>
    </div>

   

    <?php if (!empty($row['unit_id'])): ?>
      <div class="unit-block">
        <div class="line">
          <div class="title">Class Name:
            <p class="label"><?php echo '&nbsp;&nbsp;' . htmlspecialchars($row['class_name'] ?? 'Not assigned'); ?></p>
          </div>

          <div class="title">Unit Name:
            <p class="label"><?php echo '&nbsp;&nbsp;' . htmlspecialchars($row['unit_name']); ?></p>
          </div>

          <div class="title">Unit Code:
            <p class="label"><?php echo '&nbsp;&nbsp;' . htmlspecialchars($row['unit_code']); ?></p>
          </div>

          <div class="title">Lecturer:
            <p class="label"><?php echo '&nbsp;&nbsp;' . htmlspecialchars($row['teacher_names'] ?: 'Not assigned'); ?></p>
          </div>
        </div>
      </div>
    <?php else: ?>
      <p class="sub-value">No units found for this course.</p>
    <?php endif; ?>

  </div>
<?php endwhile; ?>

<?php if (!$hasRows): ?>
  <p class="sub-value">No enrolments found.</p>
<?php endif; ?>


</div>



              </div>
            </div>

            </div>
         </div>
      </div>
   </div>





</div>
</div>