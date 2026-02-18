
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

$result = getTeacherEnrolmentWithUnit($conn, $teacher_id);

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
              <h2 class=" form_title">Teaching Units</h2>
 <div class="row">
     <?php if (mysqli_num_rows($result) === 0): ?>
              <div class="alert alert-info">There are no teaching units assigned yet.</div>
            <?php else: ?>

              <div class="row g-3">
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                  <div class="col-12">
                    <div class="card mb-3">
                      <div class="card-body">

                        <!--Unit Code -->
                        <div class="title">
                          Unit Code:
                          <span class="label"><?php echo '&nbsp;' . htmlspecialchars($row['unit_code']); ?></span>
                        </div>

                        <!-- Unit Name -->
                        <div class="title mt-2">
                           Unit Name:
                          <span class="label"><?php echo '&nbsp;' . htmlspecialchars($row['unit_name']); ?></span>
                        </div>

                        <!-- Class Name  -->
                        <div class="title mt-2">
                          Class:
                          <?php if (!empty($row['class_id'])): ?>
                            
                              <span class="label"><?php echo '&nbsp;' . htmlspecialchars($row['class_name']); ?></span>
                           
                          <?php else: ?>
                            <span class="label"><?php echo '&nbsp;Not assigned'; ?></span>
                          <?php endif; ?>
                        </div>
                       
                          <div class="row g-3 justify-content-center mt-2">
                          <div class="col-sm-8 col-md-4 col-lg-3 d-grid ">
                          <a href="teachers_files.php?unit_id=<?php echo (int)$row['unit_id']; ?>&class_id=<?php echo (int)($row['class_id'] ?? 0); ?>"
   class="btn button9 w-100">Files</a>


                          </div>

                          <div class="col-sm-8 col-md-4 col-lg-3 d-grid">
                          <a href="teacher_open_submissions.php?unit_id=<?php echo (int)$row['unit_id']; ?>&class_id=<?php echo (int)$row['class_id']; ?>"
   class="btn button9">
   Submissions
</a>


                          </div>

                          <div class="col-sm-8 col-md-4 col-lg-3 d-grid">
                            <a href="" class="btn button9 w-100">Grades</a>
                          </div>
                        </div>

                      </div>
                    </div>
                  </div>
                <?php endwhile; ?>
              </div>

            <?php endif; ?>

          </div>
        </div>
      </div>
    </div>

  </div>
</div>