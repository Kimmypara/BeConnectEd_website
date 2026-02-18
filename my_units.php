<?php
include "includes/conditions.php";
include "includes/nav.php";
require_once "includes/dbh.php";

$student_id = (int)($_SESSION['user_id'] ?? 0);
$units = [];
$classes = [];

$sql = "
SELECT DISTINCT
  u.unit_id,
  u.unit_name,
  u.unit_code,
  u.ects_credits,
  u.unit_duration,
  e.class_id,
  cl.class_name,
 
  GROUP_CONCAT(DISTINCT CONCAT(t.first_name,' ',t.last_name) SEPARATOR ', ') AS teacher_names
FROM enrolment e
INNER JOIN course_units cu ON cu.course_id = e.course_id
INNER JOIN unit u ON u.unit_id = cu.unit_id
LEFT JOIN classes cl ON cl.class_id = e.class_id
LEFT JOIN unit_teacher ut ON ut.unit_id = u.unit_id AND ut.class_id = e.class_id
LEFT JOIN users t ON t.user_id = ut.teacher_id AND t.role_id = 1
WHERE e.student_id = ?
GROUP BY
  u.unit_id, u.unit_name, u.unit_code, u.ects_credits, u.unit_duration,
  e.class_id, cl.class_name
ORDER BY u.unit_name ASC
";




$stmt = mysqli_stmt_init($conn);
if (mysqli_stmt_prepare($stmt, $sql)) {
  mysqli_stmt_bind_param($stmt, "i", $student_id);
  mysqli_stmt_execute($stmt);
  $res = mysqli_stmt_get_result($stmt);
  while ($row = mysqli_fetch_assoc($res)) {
    $units[] = $row;
  }
  mysqli_stmt_close($stmt);
}
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
              <h2 class=" form_title" >My Units</h2>

              <!--unit cards-->
 <div class="row">
     <?php if (empty($units)): ?>
      <div class="col-12">
                  <div class="alert alert-info">You are not enrolled in any units yet.</div>
                </div>
              <?php else: ?>

    <?php foreach ($units as $u): ?>            
  <div class="col-12 mb-3 mb-sm-0">
    <div class="card mb-3">
      <div  class="card-body ">
    <div class="row my-3" >
      <div class=" col-lg-6 col-md-6 col-sm-12">
            <div class="title">Unit Name:<p class="label"> <?php echo '&nbsp;' .htmlspecialchars($u['unit_name']); ?></p></div>
            <div class="title">Unit Code:<p class="label"> <?php echo '&nbsp;' .htmlspecialchars($u['unit_code']); ?></p></div>
            <div class="title">Class Name:<p class="label">
  <?php echo '&nbsp;' . htmlspecialchars($u['class_name'] ?? 'Not assigned'); ?>
</p></div>

      </div>
           <div class="col-lg-6 col-md-6 col-sm-12">
            <div class="title">Duration:<p class="label"> <?php echo '&nbsp;' .htmlspecialchars($u['unit_duration']); ?></p></div>
             <div class="title">Credits:<p class="label"> <?php echo '&nbsp;' .htmlspecialchars($u['ects_credits']); ?></p></div>
            <div class="title">Lecturer:
            <p class="label">
  <?php echo '&nbsp;&nbsp;' . htmlspecialchars(($u['teacher_names'] ?? '') ?: 'Not assigned'); ?>
</p>


          </div>              
            </div>
                        </div>

                        <div class="row g-3 justify-content-center">
                          <div class="col-sm-8 col-md-4 col-lg-3 d-grid">
                           <a href="students_files.php?unit_id=<?php echo (int)$u['unit_id']; ?>"
   class="btn button9 w-100">Files</a>


                          </div>

                          <div class="col-sm-8 col-md-4 col-lg-3 d-grid">
                            <a href="students_assignments.php?unit_id=<?php echo (int)$u['unit_id']; ?>" class="btn button9 w-100">Assignments</a>
                          </div>

                          <div class="col-sm-8 col-md-4 col-lg-3 d-grid">
                            <a href="students_grades.php?unit_id=<?php echo (int)$u['unit_id']; ?>" class="btn button9 w-100">Grades</a>
                          </div>
                        </div>

                      </div>
                    </div>
                  </div>
                <?php endforeach; ?>

              <?php endif; ?>
            </div>

          </div>
        </div>
      </div>
    </div>

  </div>
</div>