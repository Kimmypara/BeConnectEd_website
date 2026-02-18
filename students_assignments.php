<?php
include "includes/conditions.php";   
include "includes/nav.php";
require_once "includes/dbh.php";     


 

$unit_id = (int)($_GET['unit_id'] ?? 0);
$student_id = (int)($_SESSION['user_id'] ?? 0);
$unitTitle = ($unit_id > 0) ? "Unit ID: " . $unit_id : "Unit";

$success = isset($_GET['success']) ? $_GET['success'] : null;
$error   = isset($_GET['error']) ? $_GET['error'] : null;


$assignments = [];

if ($unit_id > 0 && $student_id > 0) {
  $sql = "
    SELECT 
      a.assignment_id, a.unit_id, a.task_title,a.due_date,a.description,
      s.file_path, s.submitted_at

    FROM assignment a
    LEFT JOIN submission s
      ON s.assignment_id = a.assignment_id
     AND s.student_id = ?

    WHERE a.unit_id = ?
    ORDER BY a.due_date ASC, a.assignment_id ASC
  ";

  $stmt = mysqli_stmt_init($conn);
  if (mysqli_stmt_prepare($stmt, $sql)) {
    mysqli_stmt_bind_param($stmt, "ii", $student_id, $unit_id);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);

    while ($row = mysqli_fetch_assoc($res)) {
      $assignments[] = $row;
    }
    mysqli_stmt_close($stmt);
  }
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

            <h2 class="form_title">Assignments for <?php echo htmlspecialchars($unitTitle); ?></h2>

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
                    "missingdata"=> "Missing assignment or student information.",
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
                          <div class="small mb-2">
                            <?php echo nl2br(htmlspecialchars($a['description'])); ?>
                          </div>
                        <?php endif; ?>

                        <?php if (!empty($a['due_date'])): ?>
                          <div class="small mb-3">
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
                        <?php else: ?>
                          <div class="card-subtitle mb-3"><strong>File Name:</strong> —</div>
                        <?php endif; ?>

                        <!-- Upload form -->
                        <form action="includes/upload_file.php" method="post" enctype="multipart/form-data" class="mt-3">

                          <input type="hidden" name="assignment_id" value="<?php echo (int)$a['assignment_id']; ?>">
                          <input type="hidden" name="unit_id" value="<?php echo (int)$unit_id; ?>">

                          <input type="file"
                                 name="userFile"
                                 id="userFile_<?php echo (int)$a['assignment_id']; ?>"
                                 class="visually-hidden"
                                 accept=".pdf,.pptx,.docx,.xlsx">

                          <label for="userFile_<?php echo (int)$a['assignment_id']; ?>" class="attach-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                 fill="currentColor" class="bi bi-paperclip" viewBox="0 0 16 16" aria-hidden="true">
                              <path d="M4.5 3a2.5 2.5 0 0 1 5 0v9a1.5 1.5 0 0 1-3 0V5a.5.5 0 0 1 1 0v7a.5.5 0 0 0 1 0V3a1.5 1.5 0 1 0-3 0v9a2.5 2.5 0 0 0 5 0V5a.5.5 0 0 1 1 0v7a3.5 3.5 0 1 1-7 0z"/>
                            </svg>
                            Attach a file
                          </label>

                          <button type="submit" name="uploadFile" value="upload" class="btn button w-100 mt-2">
                            Submit
                          </button>

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
