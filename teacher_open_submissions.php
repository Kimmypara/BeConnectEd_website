<?php
session_start();
include "includes/conditions.php";   
include "includes/nav.php";
require_once "includes/dbh.php";     


$unit_id  = (int)($_GET['unit_id'] ?? 0);
$class_id = (int)($_GET['class_id'] ?? 0);
$teacher_id = (int)($_SESSION['user_id'] ?? 0);
$unitTitle = ($unit_id > 0) ? "Unit ID: " . $unit_id : "Unit";

if ($unit_id <= 0 || $class_id <= 0 || $teacher_id <= 0) {
  exit("<div class='alert alert-warning'>No unit/class selected.</div>");
}

$success = isset($_GET['success']) ? $_GET['success'] : null;
$error   = isset($_GET['error']) ? $_GET['error'] : null;

$row = [];
$submissions = [];
$assignments = [];


if ($unit_id > 0 && $teacher_id > 0) {

  $sql = "SELECT 
          a.assignment_id,
          a.unit_id,
          a.class_id,
          a.task_title,
          a.due_date,
          a.description,
          COUNT(s.submission_id) AS submitted_count
        FROM assignment a
        LEFT JOIN submission s
          ON s.assignment_id = a.assignment_id
        WHERE a.teacher_id = ?
          AND a.class_id = ?
        GROUP BY 
          a.assignment_id, a.unit_id, a.class_id, a.task_title, a.due_date, a.description
        ORDER BY a.due_date ASC, a.assignment_id ASC";


  $stmt = mysqli_stmt_init($conn);
  if (mysqli_stmt_prepare($stmt, $sql)) {
   mysqli_stmt_bind_param($stmt, "ii", $teacher_id, $class_id);

    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);

    while ($row = mysqli_fetch_assoc($res)) {
      $assignments[] = $row;
    }
    mysqli_stmt_close($stmt);
  }
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
            <h2 class="form_title">Assignments for <?php echo '&nbsp;' .htmlspecialchars($unit['unit_name']); ?></h2>
</div>
<div class="col-3">
<button type="button" class="btn button9" data-bs-toggle="modal" data-bs-target="#openSubmissionModal">
  Open submission
</button>

</div>

            <?php if ($success): ?>
              <div class="alert alert-success">File uploaded successfully.</div>
            <?php endif; ?>

            <?php if ($error): ?>
              <div class="alert alert-danger">
                <?php
                  //  errors
                  $map = [
                    "filetype"   => "Invalid file type. Allowed: PDF, PPTX, DOCX, XLSX.",
                    "fileUpload" => "Upload failed. Please try again.",
                    "fileSize"   => "File is too large.",
                    "nofile"     => "Please choose a file first.",
                    "missingdata"=> "Missing assignment.",
                    "movfailed"  => "Could not save the file on the server."
                  ];
                  echo htmlspecialchars($map[$error] ?? "Something went wrong.");
                ?>
              </div>
            <?php endif; ?>

            <div class="row g-2">

              <?php if ($unit_id <= 0): ?>
                <div class="col-12">
                  <div class="alert alert-warning">No unit selected. Add <strong>?unit_id=1</strong> in the URL.</div>
                </div>
              <?php elseif (empty($assignments)): ?>
                <div class="col-12">
                  <div class="alert alert-info">No assignments found for this unit.</div>
                </div>
              <?php else: ?>

                <?php foreach ($assignments as $a): ?>
                  <div class="col-12 col-md-6 col-lg-4">
                    <div class="card h-100 mb-0">
                      <div class="card-body d-flex flex-column">

                        <div class="card-subtitle mb-1">
                          <strong>Task Title:</strong> <?php echo htmlspecialchars($a['task_title'] ?? ''); ?>
                        </div>

                        <?php if (!empty($a['description'])): ?>
                          <div class="card-subtitle mb-1">
                            <strong>Description:</strong><?php echo '&nbsp' . nl2br(htmlspecialchars($a['description'])); ?>
                          </div>
                        <?php endif; ?>

                        <?php if (!empty($a['due_date'])): ?>
                          <div class="card-subtitle mb-1">
                            <strong>Due:</strong> <?php echo htmlspecialchars($a['due_date']); ?>
                          </div>
                        <?php endif; ?>

                        <!-- Show saved submission from DB  -->
                        <?php if (!empty($a['file_path'])): ?>
                          <div class="card-subtitle mb-1">
                            <strong>File Name:</strong> <?php echo htmlspecialchars(basename($a['file_path'])); ?>
                          </div>
                          <div class="card-subtitle mb-3">
                            <strong>Date:</strong> <?php echo htmlspecialchars($a['submitted_at']); ?>
                          </div>

                          <!--  download link  -->
                          <a class="button-icon btn mt-auto"
                             href="<?php echo 'fileUploads/' . rawurlencode(basename($a['file_path'])); ?>"
                             download>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                 fill="currentColor" class="bi bi-download" viewBox="0 0 16 16" aria-hidden="true">
                              <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5"/>
                              <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708z"/>
                            </svg>
                            <span>Download</span>
                          </a>
                        
                        <?php endif; ?>

                        <!-- Upload form -->
                        <form action="includes/upload_file.php" method="post" enctype="multipart/form-data" class="mt-3">

                          <input type="hidden" name="assignment_id" value="<?php echo (int)$a['assignment_id']; ?>">
                          <input type="hidden" name="unit_id" value="<?php echo (int)$unit_id; ?>">

                       
               
  <a href="teachers_view_submissions.php?assignment_id=<?php echo (int)$a['assignment_id']; ?>&unit_id=<?php echo (int)$unit_id; ?>&class_id=<?php echo (int)$class_id; ?>"
   class="btn button w-100 mt-2">
   View Submissions
</a>

                         

                        </form>

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
<!-- OPEN SUBMISSION MODAL -->
<div class="modal fade" id="openSubmissionModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content form_bg3">

      <div class="modal-header">
        <h5 class="modal-title">Open New Submission</h5>

        <button type="button" class="btn close3" data-bs-dismiss="modal" aria-label="Close">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
            <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"/>
          </svg>
        </button>
      </div>

      <form action="includes/create_assignment_inc.php" method="post">
        <div class="modal-body">

          <!-- keep unit/class hidden -->
          <input type="hidden" name="unit_id" value="<?php echo (int)$unit_id; ?>">
          <input type="hidden" name="class_id" value="<?php echo (int)$class_id; ?>">
          <input type="hidden" name="teacher_id" value="<?php echo (int)$teacher_id; ?>">

          <!-- Task title -->
          <div class="row align-items-center mb-3">
            <div class="col-3">
              <label class="formFields mb-0">Task Title</label>
            </div>
            <div class="col-9">
              <input type="text" name="task_title" class="form-control placeholder_style" required>
            </div>
          </div>

          <!-- Due date -->
          <div class="row align-items-center mb-3">
            <div class="col-3">
              <label class="formFields mb-0">Due Date</label>
            </div>
            <div class="col-9">
              <input type="date" name="due_date" class="form-control placeholder_style">
            </div>
          </div>

          <!-- Description -->
          <div class="row align-items-center mb-3">
            <div class="col-3">
              <label class="formFields mb-0">Description</label>
            </div>
            <div class="col-9">
              <textarea name="description" class="form-control placeholder_style" rows="4"></textarea>
            </div>
          </div>

          <!-- Feedback message inside modal -->
          <div class="col-12 mt-2">
            <?php if (isset($_GET['success']) && $_GET['success'] === 'assignment_created'): ?>
              <p class="text-success small mb-0">Submission opened successfully.</p>
            <?php endif; ?>
            <?php if (isset($_GET['error']) && $_GET['error'] === 'create_failed'): ?>
              <p class="text-danger small mb-0">Something went wrong. Please try again.</p>
            <?php endif; ?>
          </div>

          <div class="row mt-3">
            <div class="col-lg-6">
              <button type="submit" name="submit" class="button btn w-100">Save</button>
            </div>
            <div class="col-lg-6">
              <button type="button" class="button btn w-100" data-bs-dismiss="modal">Cancel</button>
            </div>
          </div>

        </div>
      </form>

    </div>
  </div>
</div>
