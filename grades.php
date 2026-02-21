
<?php
session_start();
include "includes/conditions.php";
include "includes/nav.php";
require_once "includes/dbh.php";

$student_id = (int)($_SESSION['user_id'] ?? 0);

if ($student_id <= 0) {
    exit("<div class='alert alert-warning text-center'>Not logged in.</div>");
}

$success = $_GET['success'] ?? null;
$error   = $_GET['error']   ?? null;

$grades = [];

$sql = "
    SELECT
        a.assignment_id,
        a.task_title,
        a.due_date,
        u.unit_id,
        u.unit_name,
        u.unit_code,
        g.grade,
        g.mark,
        g.comments
    FROM enrolment e
    JOIN course_units cu
      ON cu.course_id = e.course_id
    JOIN unit u
      ON u.unit_id = cu.unit_id
    JOIN assignment a
      ON a.unit_id  = u.unit_id
     AND a.class_id = e.class_id
    LEFT JOIN submission s
      ON s.assignment_id = a.assignment_id
     AND s.student_id   = e.student_id
    LEFT JOIN grade g
      ON g.submission_id = s.submission_id
     AND g.teacher_id    = a.teacher_id
    WHERE e.student_id = ?
    ORDER BY u.unit_name ASC, a.due_date ASC, a.assignment_id ASC
";

$stmt = mysqli_stmt_init($conn);
if (!mysqli_stmt_prepare($stmt, $sql)) {
    die("SQL error: " . mysqli_error($conn));
}
mysqli_stmt_bind_param($stmt, "i", $student_id);
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);
while ($row = mysqli_fetch_assoc($res)) {
    $grades[] = $row;
}
mysqli_stmt_close($stmt);
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
     <div class="col-2"></div>
<div class="col-8">
                  <h2 class=" form_title">Grades</h2>
              </div>
 
      <!--card/list mode -->
      
      <div class="col-2 mt-3" >
        
    <a href="" id="cardListSwitch" alt="view grades as grid or table mode button">
<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-card-list listmode" viewBox="0 0 16 16">
  <path d="M14.5 3a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2z"/>
  <path d="M5 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 5 8m0-2.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5m0 5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5m-1-5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0M4 8a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0m0 2.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0"/>
</svg>
<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-grid-fill cardmode" viewBox="0 0 16 16">
  <path d="M1 2.5A1.5 1.5 0 0 1 2.5 1h3A1.5 1.5 0 0 1 7 2.5v3A1.5 1.5 0 0 1 5.5 7h-3A1.5 1.5 0 0 1 1 5.5zm8 0A1.5 1.5 0 0 1 10.5 1h3A1.5 1.5 0 0 1 15 2.5v3A1.5 1.5 0 0 1 13.5 7h-3A1.5 1.5 0 0 1 9 5.5zm-8 8A1.5 1.5 0 0 1 2.5 9h3A1.5 1.5 0 0 1 7 10.5v3A1.5 1.5 0 0 1 5.5 15h-3A1.5 1.5 0 0 1 1 13.5zm8 0A1.5 1.5 0 0 1 10.5 9h3a1.5 1.5 0 0 1 1.5 1.5v3a1.5 1.5 0 0 1-1.5 1.5h-3A1.5 1.5 0 0 1 9 13.5z"/>
</svg>

    </a>
</div>
  
<div class="grades-view-cards">
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
 <!-- List view -->
  
<div class="grades-view-list table-responsive mt-1">
    <table class="table_admin">
        <thead>
            <tr>
                <th class="columns">Unit</th>
                <th class="columns">Code</th>
                <th class="columns">Task</th>
                <th class="columns">Mark</th>
                <th class="columns">Grade</th>
                <th class="comments">Details</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($grades as $g): ?>
                <tr>
                    <td ><?= htmlspecialchars($g['unit_name']); ?></td>
                    <td ><?= htmlspecialchars($g['unit_code']); ?></td>
                    <td ><?= htmlspecialchars($g['task_title']); ?></td>
                    <td ><?= htmlspecialchars($g['mark'] ?? '—'); ?></td>
                    <td ><?= htmlspecialchars($g['grade'] ?? '—'); ?></td>
                    <td> <button type="button"
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
                          </button></td>
                    

                  
                </tr>


                
            <?php endforeach; ?>
        </tbody>
    </table>
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

      <div class="modal-body">
        <div class="col-md-12 mt-1">
          <div class="title2">Unit Name:&nbsp;<span class="label" id="m_unit_name"></span></div>
        </div>
        <div class="col-md-12 mt-1">
          <div class="title2">Unit Code:&nbsp;<span class="label" id="m_unit_code"></span></div>
        </div>
        <div class="col-12 mt-1">
          <div class="title2">Task Title:&nbsp;<span class="label" id="m_task_title"></span></div>
        </div>
        <div class="col-12 mt-1">
          <div class="title2">Mark:&nbsp;<span class="label" id="m_mark"></span></div>
        </div>
        <div class="col-12 mt-1">
          <div class="title2">Grade:&nbsp;<span class="label" id="m_grade"></span></div>
        </div>

        <div class="col-12 mt-1">
          <div class="title2">
            Comments:
            <div class="label comment-box" id="m_comments"></div>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>
</div>
</div>
<script>
  const gradeModal = document.getElementById('viewGrade');

  gradeModal.addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget;
    if (!button) return;

    // Fill modal fields from data-* attributes on the clicked button
    document.getElementById('m_unit_name').textContent  =
      button.getAttribute('data-unit-name')  || '';

    document.getElementById('m_unit_code').textContent  =
      button.getAttribute('data-unit-code')  || '';

    document.getElementById('m_task_title').textContent =
      button.getAttribute('data-task-title') || '';

    document.getElementById('m_mark').textContent       =
      button.getAttribute('data-mark') || '—';

    document.getElementById('m_grade').textContent      =
      button.getAttribute('data-grade') || '—';

    document.getElementById('m_comments').textContent   =
      button.getAttribute('data-comments') || '';
  });
</script>
        


