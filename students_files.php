<?php
include "includes/conditions.php";
include "includes/nav.php";
require_once "includes/dbh.php";

if (session_status() === PHP_SESSION_NONE) session_start();

$student_id = (int)($_SESSION['user_id'] ?? 0);
$unit_id    = (int)($_GET['unit_id'] ?? 0);

if ($student_id <= 0) { header("Location: login.php"); exit(); }
if ($unit_id <= 0) { exit("<div class='alert alert-warning text-center'>Invalid or missing unit ID.</div>"); }

$files = [];

// Student’s class for THIS unit (via enrolment -> course_units)
$sql = "
SELECT
  f.file_id, f.unit_id, f.class_id, f.uploaded_by,
  f.file_name, f.category, f.file_path, f.uploaded_at, f.notes,
  CONCAT(t.first_name,' ',t.last_name) AS teacher_name
FROM enrolment e
JOIN course_units cu ON cu.course_id = e.course_id
JOIN unit_teacher ut ON ut.unit_id = cu.unit_id AND ut.class_id = e.class_id
JOIN file f ON f.unit_id = ut.unit_id AND f.class_id = ut.class_id AND f.uploaded_by = ut.teacher_id
JOIN users t ON t.user_id = ut.teacher_id
WHERE e.student_id = ?
  AND cu.unit_id = ?
ORDER BY f.uploaded_at DESC
";

$stmt = mysqli_stmt_init($conn);
if (!mysqli_stmt_prepare($stmt, $sql)) {
  die("SQL prepare failed: " . mysqli_error($conn));
}
mysqli_stmt_bind_param($stmt, "ii", $student_id, $unit_id);
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);
while ($row = mysqli_fetch_assoc($res)) {
  $files[] = $row;
}
mysqli_stmt_close($stmt);

// unit title
$sqlUnit = "SELECT unit_name FROM unit WHERE unit_id = ? LIMIT 1";
$stmtUnit = mysqli_stmt_init($conn);
mysqli_stmt_prepare($stmtUnit, $sqlUnit);
mysqli_stmt_bind_param($stmtUnit, "i", $unit_id);
mysqli_stmt_execute($stmtUnit);
$resUnit = mysqli_stmt_get_result($stmtUnit);
$unit = mysqli_fetch_assoc($resUnit);
mysqli_stmt_close($stmtUnit);

if (!$unit) exit("<div class='alert alert-danger'>Unit not found.</div>");
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
              <h2 class=" form_title" >Files for<?php echo '&nbsp;' .htmlspecialchars($unit['unit_name']); ?></h2>

              <!--unit cards-->
 <div class="row">
     <?php if (empty($files)): ?>
      <div class="col-12">
                  <div class="alert alert-info">There are no files uploaded yet. </div>
                </div>
           

    <?php else: ?>
              <div class="row g-2">
                <?php foreach ($files as $f): ?>
                  <div class="col-12 col-md-6 col-lg-4">
                    <div class="card h-100 mb-0">
                      <div class="card-body d-flex flex-column">

                        <div class="title">
                          File Name:
                          <p class="label"><?php echo '&nbsp;' . htmlspecialchars($f['file_name']); ?></p>
                        </div>

                          <div class="title">
                          Lecturer Name:
                           <p class="label"><?php echo '&nbsp;' .htmlspecialchars($f['teacher_name'] ?? 'Not assigned'); ?></p>
                        </div>

                       

                        <div class="title">
                          Category:
                          <p class="label"><?php echo '&nbsp;' . htmlspecialchars($f['category']); ?></p>
                        </div>

                        <div class="title">
                          Date:
                          <p class="label"><?php echo '&nbsp;' . htmlspecialchars($f['uploaded_at']); ?></p>
                        </div>

                    <div class="title">
                      Notes:
                        <?php if (!empty($f['notes'])): ?>
                          <div class="label "><?php echo '&nbsp;' .nl2br(htmlspecialchars($f['notes'])); ?></div>
                        <?php endif; ?>
                            </div>

                        <div class="mt-auto d-flex justify-content-end">
                          <a class="button-icon btn"
                             href="includes/download_file_inc.php?file_id=<?php echo (int)$f['file_id']; ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                 class="bi bi-download" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
                              <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5"/>
                              <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708z"/>
                            </svg>
                            <span>Download</span>
                          </a>
                        </div>

                      </div>
                    </div>
                  </div>
                <?php endforeach; ?>
              </div>
            <?php endif; ?>

          </div>
        </div>
      </div>
    </div>

  </div>
</div>