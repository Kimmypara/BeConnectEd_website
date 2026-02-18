
<?php
session_start();
include "includes/conditions.php";
include "includes/nav.php";
require_once "includes/dbh.php";
require_once "includes/functions.php";

$teacher_id = (int)($_SESSION['user_id'] ?? 0);
if ($teacher_id <= 0) {
    die("Not logged in.");
}

$res = getTeacherEnrolmentWithUnit($conn, $teacher_id);

$hasRows = false;
$message = "";

if ($res === false) {
  $message = "Error loading enrolment.";
}


$current_course_id = null;
?>



<div class="container-fluid">
  <div class="row">

      <div class="col-lg-2 col-md-3 p-0">
          <?php include 'includes/menuteacher.php'; ?>
      </div>
     

    <div class="col-1"></div>
  <div class="col-lg-9 col-md-8">
      <div class="row">  
        <div class="col-12">  
            <div class="form_bg">
            
            <div class="row">
              <div class="col-lg-12">
<h2 class=" form_title" >Enrolment</h2>
<?php while ($row = mysqli_fetch_assoc($res)): ?>
  <?php $hasRows = true; ?>

  <?php if ($current_course_id !== $row['course_id']): ?>

    <?php if ($current_course_id !== null): ?>
        </div> 
    <?php endif; ?>

    <?php $current_course_id = $row['course_id']; ?>

    <div class="course-section">
      <hr class="divider">
        <div class="course-col">
          <div class="title">Course Title: <p class="label"><?php echo'&nbsp;' .'&nbsp;' . htmlspecialchars($row['course_name']); ?></p></div>
          
       

        <div class="course-col">
          <div class="title">Course Code: <p class="label"><?php echo '&nbsp;' .'&nbsp;' . htmlspecialchars($row['course_code']); ?></p></div>
          
        </div>
      </div>

      <hr class="divider">

  <?php endif; ?>

  <?php if (!empty($row['unit_id'])): ?>
    <div class="unit-block">
      <div class="line">
       
        <div class="title">Unit Name: <p class="label"><?php echo '&nbsp;' .'&nbsp;' . htmlspecialchars($row['unit_name']); ?></p></div>
       
     
     <div class="title">Unit Code: <p class="label"><?php echo '&nbsp;' .'&nbsp;' . htmlspecialchars($row['unit_code']); ?></p></div>

      <div class="line mt">
  <div class="title">
    Class: 
    <a class="links" 
       href="class_attendance.php?class_id=<?php echo $row['class_id']; ?>">
       <?php echo '&nbsp;&nbsp;' . htmlspecialchars($row['class_name'] ?: 'Not assigned'); ?>
    </a>
  </div>
</div>

     

    </div>

    <hr class="divider">
    
  <?php else: ?>
    <p class="sub-value">No units found for this course.</p>
  <?php endif; ?>

<?php endwhile; ?>

<?php if ($hasRows === false): ?>
  <p class="sub-value">No enrolments found.</p>
<?php endif; ?>

<?php if ($current_course_id !== null): ?>
  </div> 
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