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
    a.assignment_id,
    a.unit_id,
    a.task_title,
    a.due_date,
    a.description,

    s.submission_id,
    s.submitted_at,
    COUNT(sf.submission_file_id) AS file_count

  FROM assignment a
  LEFT JOIN submission s
    ON s.assignment_id = a.assignment_id
   AND s.student_id = ?

  LEFT JOIN submission_files sf
    ON sf.submission_id = s.submission_id

  WHERE a.unit_id = ?
  GROUP BY
    a.assignment_id, a.unit_id, a.task_title, a.due_date, a.description,
    s.submission_id, s.submitted_at
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

// unit title
$sqlUnit = "SELECT unit_name FROM unit WHERE unit_id = ? LIMIT 1";
$stmtUnit = mysqli_stmt_init($conn);
mysqli_stmt_prepare($stmtUnit, $sqlUnit);
mysqli_stmt_bind_param($stmtUnit, "i", $unit_id);
mysqli_stmt_execute($stmtUnit);
$resUnit = mysqli_stmt_get_result($stmtUnit);
$unit = mysqli_fetch_assoc($resUnit);
mysqli_stmt_close($stmtUnit);



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

            <h2 class="form_title">Assignments for <?php echo $unit ? '&nbsp;' . htmlspecialchars($unit['unit_name']) : ''; ?></h2>

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
                          <div class="card-subtitle mb-1">
                            <strong>Description:</strong><?php echo '&nbsp;' .nl2br(htmlspecialchars($a['description'])); ?>
                          </div>
                        <?php endif; ?>

                        <?php if (!empty($a['due_date'])): ?>
                          <div class="card-subtitle mb-1">
                            <strong>Due Date:</strong> <?php echo htmlspecialchars($a['due_date']); ?>
                          </div>
                        <?php endif; ?>

                        <!-- Show saved submission from DB  -->
                       
                      <div class="card-subtitle mb-1">
  <strong>Submitted At:</strong>
  <?php echo !empty($a['submitted_at']) ? htmlspecialchars($a['submitted_at']) : '—'; ?>
</div>



<?php if (!empty($a['submission_id'])): ?>
  <?php
    $files = [];
    $q = "SELECT submission_file_id, file_path, original_name, uploaded_at
          FROM submission_files
          WHERE submission_id = ?
          ORDER BY uploaded_at DESC";
    $st = mysqli_stmt_init($conn);
    if (mysqli_stmt_prepare($st, $q)) {
      mysqli_stmt_bind_param($st, "i", $a['submission_id']);
      mysqli_stmt_execute($st);
      $rs = mysqli_stmt_get_result($st);
      while ($f = mysqli_fetch_assoc($rs)) $files[] = $f;
      mysqli_stmt_close($st);
    }
  ?>

  <?php if (!empty($files)): ?>
    <ul class="list-unstyled mb-0">
      <?php foreach ($files as $f): ?>
        <li class="d-flex justify-content-between align-items-center mb-1">
          <a href="<?php echo 'fileUploads/' . rawurlencode(basename($f['file_path'])); ?>" download>
            <?php echo htmlspecialchars($f['original_name'] ?: basename($f['file_path'])); ?>
          </a>

          <form action="includes/delete_submission_file.php" method="post" class="ms-2">
              <input type="hidden" name="assignment_id"
         value="<?php echo (int)$a['assignment_id']; ?>">

  <input type="hidden" name="unit_id"
         value="<?php echo (int)$unit_id; ?>">
            <button type="submit" class="btn btn-sm btn-danger">Remove</button>
          </form>
        </li>
      <?php endforeach; ?>
    </ul>
  <?php endif; ?>
<?php endif; ?>


                        <!-- Upload form -->
                        <form action="includes/upload_file.php" method="post" enctype="multipart/form-data" class="mt-3">

                          <input type="hidden" name="assignment_id" value="<?php echo (int)$a['assignment_id']; ?>">
                          <input type="hidden" name="unit_id" value="<?php echo (int)$unit_id; ?>">

                        <input type="file"
                        name="userFiles[]"
                        id="userFiles_<?php echo (int)$a['assignment_id']; ?>"
                        class="visually-hidden"
                         accept=".pdf,.pptx,.docx,.xlsx"
                        multiple
                        onchange="addFiles(this, <?php echo (int)$a['assignment_id']; ?>)">



                         <div id="preview_<?php echo (int)$a['assignment_id']; ?>" class="mt-2"></div>




                          <label for="userFiles_<?php echo (int)$a['assignment_id']; ?>" class="attach-btn" style="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                 fill="currentColor" class="bi bi-paperclip " viewBox="0 0 16 16" aria-hidden="true">
                              <path d="M4.5 3a2.5 2.5 0 0 1 5 0v9a1.5 1.5 0 0 1-3 0V5a.5.5 0 0 1 1 0v7a.5.5 0 0 0 1 0V3a1.5 1.5 0 1 0-3 0v9a2.5 2.5 0 0 0 5 0V5a.5.5 0 0 1 1 0v7a3.5 3.5 0 1 1-7 0z"/>
                            </svg>
                            Attach a file
                          </label>

                         
                          
                              <button type="submit" name="uploadFile" value="upload" class="btn button w-100 mt-2"> Submit </button>

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
<script>
const fileStores = {}; // assignmentId => DataTransfer

function getStore(id) {
  if (!fileStores[id]) fileStores[id] = new DataTransfer();
  return fileStores[id];
}

function addFiles(input, id) {
  const store = getStore(id);

  // add newly selected files into existing store
  for (const f of input.files) {
    // optional: prevent duplicates by name+size
    const exists = Array.from(store.files).some(x => x.name === f.name && x.size === f.size);
    if (!exists) store.items.add(f);
  }

  // update the real input files
  input.files = store.files;

  renderFileList(input, id);
}

function renderFileList(input, id) {
  const preview = document.getElementById("preview_" + id);
  preview.innerHTML = "";

  const store = getStore(id);

  Array.from(store.files).forEach((file, index) => {
    const row = document.createElement("div");
    row.className = "d-flex justify-content-between align-items-center mb-1 border p-2 rounded text-start";

    const name = document.createElement("span");
    name.textContent = file.name;

    const btn = document.createElement("button");
    btn.type = "button";
    btn.className = "btn btn-sm btn-danger";
    btn.textContent = "Remove";
    btn.onclick = () => removeFile(input, id, index);

    row.appendChild(name);
    row.appendChild(btn);
    preview.appendChild(row);
  });

  // keep input in sync
  input.files = store.files;
}

function removeFile(input, id, indexToRemove) {
  const oldStore = getStore(id);
  const newStore = new DataTransfer();

  Array.from(oldStore.files).forEach((file, idx) => {
    if (idx !== indexToRemove) newStore.items.add(file);
  });

  fileStores[id] = newStore;
  input.files = newStore.files;

  renderFileList(input, id);
}
</script>

