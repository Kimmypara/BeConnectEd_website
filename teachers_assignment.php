<?php
session_start();
include "includes/conditions.php";   
include "includes/nav.php";
require_once "includes/dbh.php";     



$unit_id = (int)($_GET['unit_id'] ?? 0);

$assignment_id = (int)($_GET['assignment_id'] ?? 0);
$class_id      = (int)($_GET['class_id'] ?? 0); // optional, only for back button
$teacher_id    = (int)($_SESSION['user_id'] ?? 0);

if ($teacher_id <= 0) {
  exit("<div class='alert alert-warning'>Not authorised.</div>");
}

if ($assignment_id <= 0 || $teacher_id <= 0) {
  echo "<div class='alert alert-warning'>Please select an assignment.</div>";
}


$success = isset($_GET['success']) ? $_GET['success'] : null;
$error   = isset($_GET['error']) ? $_GET['error'] : null;

$rows = [];

$sql = "SELECT
          u.user_id AS student_id,
          u.first_name,
          u.last_name,
          u.email,
          s.submission_id,
          s.file_path,
          s.submitted_at
        FROM submission s
        JOIN users u ON u.user_id = s.student_id
        JOIN assignment a ON a.assignment_id = s.assignment_id
        WHERE s.assignment_id = ?
          AND a.teacher_id = ?
        ORDER BY s.submitted_at DESC";




$stmt = mysqli_stmt_init($conn);
if (mysqli_stmt_prepare($stmt, $sql)) {
 mysqli_stmt_bind_param($stmt, "ii", $assignment_id, $teacher_id);
  mysqli_stmt_execute($stmt);
  $res = mysqli_stmt_get_result($stmt);
  while ($r = mysqli_fetch_assoc($res)) $rows[] = $r;
  mysqli_stmt_close($stmt);
}

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
      <?php include 'includes/menuteacher.php'; ?>
    </div>

    <div class="col-1"></div>

    <div class="col-lg-9 col-md-8">
      <div class="row">
        <div class="col-12">
          <div class="form_bg">
            <div class="row mt-2"> 
                <div class="col-3"></div>
                <div class="col-lg-6">
            <h2 class="form_title">Submission list for <?php echo '&nbsp;' .htmlspecialchars($unit['unit_name']); ?></h2>
</div>
<div class="col-3">
<a href="teacher_open_submissions.php?unit_id=<?php echo $unit_id; ?>&class_id=<?php echo $class_id;?> &teacher_id=<?php echo $teacher_id;?>" class="btn button9">
  
  Open submission
</a>
</div>

           <div class="table-responsive mt-4">
  <table class="table table-striped align-middle">
    <thead>
      <tr>
        <th>Student Name</th>
        <th>Email</th>
        <th>Student ID</th>
        <th>File</th>
        <th>Submitted At</th>
        <th>Grade</th>
        <th>Action</th>
      </tr>
    </thead>

    <tbody>
      <?php if (empty($rows)): ?>
        <tr>
          <td colspan="7" class="text-center text-muted py-4">
            No students have submitted yet.
          </td>
        </tr>
      <?php else: ?>
        <?php foreach ($rows as $r): ?>
          <tr>
            <td>
              <?php echo htmlspecialchars(trim(($r['first_name'] ?? '').' '.($r['last_name'] ?? ''))); ?>
            </td>
            <td><?php echo htmlspecialchars($r['email'] ?? ''); ?></td>
            <td><?php echo (int)$r['student_id']; ?></td>

            <td>
              <?php if (!empty($r['file_path'])): ?>
                <a class="btn btn-sm button-icon"
                   href="<?php echo 'fileUploads/' . rawurlencode(basename($r['file_path'])); ?>"
                   download>
                  Download
                </a>
                <div class="small text-muted mt-1">
                  <?php echo htmlspecialchars(basename($r['file_path'])); ?>
                </div>
              <?php else: ?>
                <span class="text-muted">—</span>
              <?php endif; ?>
            </td>

            <td>
              <?php echo !empty($r['submitted_at']) ? htmlspecialchars($r['submitted_at']) : '—'; ?>
            </td>

            <td>
              <?php echo ($r['grade'] !== null && $r['grade'] !== '') ? htmlspecialchars($r['grade']) : '—'; ?>
            </td>

            <td>
              <a class="btn btn-sm button"
                 href="teacher_grade_submission.php?submission_id=<?php echo (int)$r['submission_id']; ?>">
                Grade
              </a>
            </td>
          </tr>
        <?php endforeach; ?>
      <?php endif; ?>
    </tbody>
  </table>
</div>


                   
                        

                       

                        </form>

                      </div>
                    </div>
                  </div>
              

             

            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>
