<?php
session_start();
include "includes/conditions.php";   
include "includes/nav.php";
require_once "includes/dbh.php";     

$assignment_id = (int)($_GET['assignment_id'] ?? 0);
$unit_id       = (int)($_GET['unit_id'] ?? 0);
$class_id      = (int)($_GET['class_id'] ?? 0);
$teacher_id    = (int)($_SESSION['user_id'] ?? 0);

if ($assignment_id <= 0) {
    exit("<div class='alert alert-warning'>Invalid assignment.</div>");
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
          s.submitted_at,
          a.task_title,
          g.grade AS grade,
          g.mark  AS mark,
          g.comments AS comments
        FROM submission s
        JOIN users u ON u.user_id = s.student_id
        JOIN assignment a ON a.assignment_id = s.assignment_id
        LEFT JOIN grade g 
          ON g.submission_id = s.submission_id
         AND g.teacher_id = a.teacher_id
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
               
                <div class="col-lg-12">
            <h2 class="form_title">Submission list for <?php echo '&nbsp;' .htmlspecialchars($unit['unit_name']); ?></h2>
</div>

</div>

           <div class="table-responsive mt-1">
  <table class="table_admin">
    <thead>
      <tr>
        <th>Student Name</th>
        <th>Email</th>
        <th>Student ID</th>
        <th>File</th>
        <th>Submitted At</th>
        <th>Grade</th>
        <th>Mark</th>
        <th>Action</th>
      </tr>
    </thead>

    <tbody>
      <?php if (empty($rows)): ?>
        <tr>
          <td colspan="8" class="text-center text-muted py-4">
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
          <?php
$files = [];
$q = "SELECT submission_file_id, file_path, original_name
      FROM submission_files
      WHERE submission_id = ?
      ORDER BY uploaded_at DESC";

$st2 = mysqli_stmt_init($conn);
if (mysqli_stmt_prepare($st2, $q)) {
    mysqli_stmt_bind_param($st2, "i", $r['submission_id']);
    mysqli_stmt_execute($st2);
    $rs2 = mysqli_stmt_get_result($st2);
    while ($f = mysqli_fetch_assoc($rs2)) {
        $files[] = $f;
    }
    mysqli_stmt_close($st2);
}
?>

<?php if (!empty($files)): ?>
    <?php foreach ($files as $f): ?>
        <div class="mb-1 text-start">
            <a href="<?php echo 'fileUploads/' . rawurlencode($f['file_path']); ?>" download>
                <?php echo htmlspecialchars($f['original_name']); ?>
            </a>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <span class="text-muted">—</span>
<?php endif; ?>

            </td>

            <td>
              <?php echo !empty($r['submitted_at']) ? htmlspecialchars($r['submitted_at']) : '—'; ?>
            </td>

           <td><?php echo !empty($r['grade']) ? htmlspecialchars($r['grade']) : '—'; ?></td>
<td><?php echo !empty($r['mark'])  ? htmlspecialchars($r['mark'])  : '—'; ?></td>


            <td>
           <button type="button"
        class="btn btn-sm button"
        data-bs-toggle="modal"
        data-bs-target="#gradeModal"
        data-submission-id="<?php echo (int)$r['submission_id']; ?>"
        data-student-name="<?php echo htmlspecialchars(trim(($r['first_name'] ?? '').' '.($r['last_name'] ?? '')), ENT_QUOTES); ?>"
        data-student-id="<?php echo (int)$r['student_id']; ?>"
        data-unit-name="<?php echo htmlspecialchars($unit['unit_name'], ENT_QUOTES); ?>"
        data-task-title="<?php echo htmlspecialchars($task_title ?? 'Assignment', ENT_QUOTES); ?>"
        data-mark="<?php echo htmlspecialchars($r['mark'] ?? '', ENT_QUOTES); ?>"
        data-grade="<?php echo htmlspecialchars($r['grade'] ?? '', ENT_QUOTES); ?>"
        data-comments="<?php echo htmlspecialchars($r['comments'] ?? '', ENT_QUOTES); ?>">
  Grading
</button>


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
<!-- Grade Modal -->
<div class="modal fade" id="gradeModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-md">
    <div class="modal-content form_bg3">

      <div class="modal-header">
        <h5 class="modal-title">Grade Submission</h5>
          <button type="button" class="btn close2" data-bs-dismiss="modal" aria-label="Close">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
            <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"/>
          </svg>
        </button>
      </div>

      <form action="includes/save_grade.php" method="post">
        <div class="modal-body">

          <!-- hidden ids -->
          <input type="hidden" name="submission_id" id="m_submission_id">
          <input type="hidden" name="assignment_id" value="<?php echo (int)$assignment_id; ?>">
          <input type="hidden" name="unit_id" value="<?php echo (int)$unit_id; ?>">
          <input type="hidden" name="class_id" value="<?php echo (int)$class_id; ?>">

          <!-- top info row -->
          <div class="row mb-3">
            <div class="col-md-6">
              <div class="title">Unit:&nbsp <span class="label" id="m_unit_name"></span></div>
            </div>
            <div class="col-md-6">
              <div class="title">Student:&nbsp <span class="label" id="m_student_name"></span> (<span id="m_student_id"></span>)</div>
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-12">
              <div class="title">Task Title:&nbsp <span class="label" id="m_task_title"></span></div>
            </div>
          </div>

          <!-- inputs -->
          <div class="row align-items-center mt-1">
            <div class="col-3"><label class="formFields mb-0">Mark</label></div>
            <div class="col-9">
              <input type="number" name="mark" id="m_mark" class="form-control placeholder_style" min="0" max="100" step="1">
            </div>
          </div>

          <div class="row align-items-center mt-1">
            <div class="col-3"><label class="formFields mb-0">Grade</label></div>
            <div class="col-9">
              <input type="text" name="grade" id="m_grade" class="form-control placeholder_style" maxlength="10" placeholder="e.g. A, B+, Pass">
            </div>
          </div>

          <div class="row align-items-start mt-1">
            <div class="col-3"><label class="formFields mb-0">Comments</label></div>
            <div class="col-9">
              <textarea name="comments" id="m_comments" class="form-control placeholder_style" rows="6" placeholder="Write feedback..."></textarea>
            </div>
          </div>

        </div>

        <div class="row mt-1">
            <div class="col-lg-6">
              <button type="submit" name="submit" class="button btn w-100">Save</button>
            </div>
            <div class="col-lg-6">
              <button type="button" class="button btn w-100" data-bs-dismiss="modal">Cancel</button>
            </div>
          </div>


       

      </form>
    </div>
  </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {
  const gradeModal = document.getElementById('gradeModal');

  gradeModal.addEventListener('show.bs.modal', function (event) {
    const btn = event.relatedTarget;

    document.getElementById('m_submission_id').value = btn.getAttribute('data-submission-id');

    document.getElementById('m_unit_name').textContent = btn.getAttribute('data-unit-name') || '';
    document.getElementById('m_student_name').textContent = btn.getAttribute('data-student-name') || '';
    document.getElementById('m_student_id').textContent = btn.getAttribute('data-student-id') || '';
    document.getElementById('m_task_title').textContent = btn.getAttribute('data-task-title') || '';

    document.getElementById('m_mark').value = btn.getAttribute('data-mark') || '';
    document.getElementById('m_grade').value = btn.getAttribute('data-grade') || '';
    document.getElementById('m_comments').value = btn.getAttribute('data-comments') || '';
  });
});
</script>
