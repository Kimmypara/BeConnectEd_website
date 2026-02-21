
<?php
session_start();
include "includes/conditions.php";
include "includes/nav.php";
require_once "includes/dbh.php";

$student_id   = (int)($_SESSION['user_id'] ?? 0);
$unit_id      = (int)($_GET['unit_id'] ?? 0);

if ($student_id <= 0) {
    exit("<div class='alert alert-warning text-center'>Not logged in.</div>");
}
if ($unit_id <= 0) {
    exit("<div class='alert alert-warning text-center'>Invalid unit.</div>");
}

$success = $_GET['success'] ?? null;
$error   = $_GET['error']   ?? null;

$grades = [];

$sql = "
    SELECT
        a.assignment_id,
        a.task_title,
        a.due_date,
        u.unit_name,
        u.unit_code,
        g.grade,
        g.mark,
        g.comments
    FROM assignment a
    JOIN unit u
      ON u.unit_id = a.unit_id
    LEFT JOIN submission s
      ON s.assignment_id = a.assignment_id
     AND s.student_id   = ?
    LEFT JOIN grade g
      ON g.submission_id = s.submission_id
     AND g.teacher_id    = a.teacher_id
    WHERE a.unit_id = ?
    ORDER BY a.due_date ASC, a.assignment_id ASC
";

$stmt = mysqli_stmt_init($conn);
if (!mysqli_stmt_prepare($stmt, $sql)) {
    die("SQL error: " . mysqli_error($conn));
}
mysqli_stmt_bind_param($stmt, "ii", $student_id, $unit_id);
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);
while ($row = mysqli_fetch_assoc($res)) {
    $grades[] = $row;
}
mysqli_stmt_close($stmt);

// unit title 
$sqlUnit = "SELECT unit_name, unit_code FROM unit WHERE unit_id = ? LIMIT 1";
$stmtUnit = mysqli_stmt_init($conn);
mysqli_stmt_prepare($stmtUnit, $sqlUnit);
mysqli_stmt_bind_param($stmtUnit, "i", $unit_id);
mysqli_stmt_execute($stmtUnit);
$resUnit = mysqli_stmt_get_result($stmtUnit);
$unit = mysqli_fetch_assoc($resUnit);
mysqli_stmt_close($stmtUnit);

if (!$unit) {
    exit("<div class='alert alert-danger'>Unit not found.</div>");
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
            <h2 class="form_title">
              Grades for <?php echo '&nbsp;' . htmlspecialchars($unit['unit_name']); ?>
            </h2>

            <div class="row">
              <?php if (empty($grades)): ?>
                <div class="col-12">
                  <div class="alert alert-info">
                    There are no grades uploaded yet for this unit.
                  </div>
                </div>
              <?php else: ?>
                <div class="row g-2">
                  <?php foreach ($grades as $g): ?>
                    <div class="col-12 col-md-6 col-lg-4">
                      <div class="card h-100 mb-0">
                        <div class="card-body d-flex flex-column">

                          <div class="title">
                            Unit Name:
                            <p class="label">
                              <?php echo '&nbsp;' . htmlspecialchars($g['unit_name']); ?>
                            </p>
                          </div>

                          <div class="title">
                            Unit Code:
                            <p class="label">
                              <?php echo '&nbsp;' . htmlspecialchars($g['unit_code']); ?>
                            </p>
                          </div>

                          <div class="title">
                            Task Title:
                            <p class="label">
                              <?php echo '&nbsp;' . htmlspecialchars($g['task_title']); ?>
                            </p>
                          </div>

                          <div class="title">
                            Mark:
                            <p class="label">
                              <?php echo '&nbsp;' . ($g['mark'] !== null ? htmlspecialchars($g['mark']) : '—'); ?>
                            </p>
                          </div>

                          <div class="title">
                            Grade:
                            <p class="label">
                              <?php echo '&nbsp;' . ($g['grade'] !== null ? htmlspecialchars($g['grade']) : '—'); ?>
                            </p>
                          </div>

                       

                          <!-- View Details button opens read-only modal -->
                          <button type="button"
                                  class="btn btn-sm button mt-auto"
                                  data-bs-toggle="modal"
                                  data-bs-target="#viewGrade"
                                  data-unit-name="<?php echo htmlspecialchars($g['unit_name'], ENT_QUOTES); ?>"
                                  data-unit-code="<?php echo htmlspecialchars($g['unit_code'], ENT_QUOTES); ?>"
                                  data-task-title="<?php echo htmlspecialchars($g['task_title'], ENT_QUOTES); ?>"
                                  data-mark="<?php echo htmlspecialchars($g['mark'] ?? '', ENT_QUOTES); ?>"
                                  data-grade="<?php echo htmlspecialchars($g['grade'] ?? '', ENT_QUOTES); ?>"
                                  data-comments="<?php echo htmlspecialchars($g['comments'] ?? '', ENT_QUOTES); ?>">
                            View Details
                          </button>

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
</div>
<!-- Grade Modal -->
<div class="modal fade" id="viewGrade" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-md">
    <div class="modal-content form_bg3">

      <div class="modal-header">
        <h5 class="modal-title">View Grade</h5>
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
       
            <div class="col-md-12 mt-1">
              <div class="title">Unit Name:&nbsp <span class="label" id="m_unit_name"></span></div>
            </div>
            <div class="col-md-12 mt-1">
              <div class="title">Unit Code:&nbsp <span class="label" id="m_unit_code"></span> </div>
            </div>
     
            <div class="col-12 mt-1">
              <div class="title">Task Title:&nbsp <span class="label" id="m_task_title"></span></div>
            </div>
      
            <div class="col-12 mt-1">
               <div class="title">Mark:&nbsp <span class="label" id="m_mark"></span></div>
              
            </div>
       

          
            <div class="col-12 mt-1">
              <div class="title">Grade:&nbsp <span class="label" id="m_grade"></span></div>
              
            </div>
        

          
           <div class="title">
  Comments:
  <div class="label comment-box">
    <?php echo '&nbsp;' . nl2br(htmlspecialchars($g['comments'])); ?>
  </div>
</div>
         

        </div>
<script>
document.addEventListener('show.bs.modal', function (event) {
  const button = event.relatedTarget;
  if (!button) return;

  const modal = document.getElementById('viewGrade');

  modal.querySelector('#m_unit_name').textContent  = button.getAttribute('data-unit-name')  || '';
  modal.querySelector('#m_unit_code').textContent  = button.getAttribute('data-unit-code')  || '';
  modal.querySelector('#m_task_title').textContent = button.getAttribute('data-task-title') || '';
  modal.querySelector('#m_mark').textContent       = button.getAttribute('data-mark')       || '—';
  modal.querySelector('#m_grade').textContent      = button.getAttribute('data-grade')      || '—';
  modal.querySelector('#m_comments').textContent   = button.getAttribute('data-comments')   || '';
});
</script>
        