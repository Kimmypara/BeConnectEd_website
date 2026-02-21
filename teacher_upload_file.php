<?php


include "includes/conditions.php";
include "includes/nav.php";
require_once "includes/dbh.php";

$unit_id    = (int)($_GET['unit_id'] ?? 0);
$teacher_id = (int)($_SESSION['user_id'] ?? 0);
$class_id = (int)($_GET['class_id'] ?? 0);

if ($unit_id <= 0 || $class_id <= 0) {
  exit("<div class='alert alert-warning text-center'>Missing unit or class.</div>");
}


$success = ($_GET['success'] ?? '') === '1';
$error   = $_GET['error'] ?? '';

// Get unit name for title (optional)
$unitName = "";
$sqlUnit = "SELECT unit_name FROM unit WHERE unit_id = ? LIMIT 1";
$stmtU = mysqli_stmt_init($conn);
if (mysqli_stmt_prepare($stmtU, $sqlUnit)) {
  mysqli_stmt_bind_param($stmtU, "i", $unit_id);
  mysqli_stmt_execute($stmtU);
  $resU = mysqli_stmt_get_result($stmtU);
  $urow = mysqli_fetch_assoc($resU);
  $unitName = $urow['unit_name'] ?? "";
  mysqli_stmt_close($stmtU);
}

// Get classes teacher teaches for this unit
$classes = [];
$sqlC = "
  SELECT cl.class_id, cl.class_name
  FROM unit_teacher ut
  INNER JOIN classes cl ON cl.class_id = ut.class_id
  WHERE ut.teacher_id = ?
    AND ut.unit_id = ?
  ORDER BY cl.class_name ASC
";
$stmtC = mysqli_stmt_init($conn);
if (mysqli_stmt_prepare($stmtC, $sqlC)) {
  mysqli_stmt_bind_param($stmtC, "ii", $teacher_id, $unit_id);
  mysqli_stmt_execute($stmtC);
  $resC = mysqli_stmt_get_result($stmtC);
  while ($r = mysqli_fetch_assoc($resC)) {
    $classes[] = $r;
  }
  mysqli_stmt_close($stmtC);
}
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

           <h2 class="form_title">Upload File for <?php echo htmlspecialchars($unitName ?: 'Unit'); ?></h2>


            <?php if ($success): ?>
              <div class="alert alert-success">File uploaded successfully.</div>
            <?php endif; ?>

            <?php if ($error): ?>
              <div class="alert alert-danger">
                <?php
                  $map = [
                    "filetype"   => "Invalid file type. Allowed: PDF, PPTX, DOCX, XLSX.",
                    "fileUpload" => "Upload failed. Please try again.",
                    "fileSize"   => "File is too large.",
                    "nofile"     => "Please choose a file first.",
                    "missingdata"=> "Missing data.",
                    "movfailed"  => "Could not save the file on the server."
                  ];
                  echo htmlspecialchars($map[$error] ?? "Something went wrong.");
                ?>
              </div>
            <?php endif; ?>

            <form action="includes/teacher_upload_file_inc.php" method="post" enctype="multipart/form-data">

              <input type="hidden" name="unit_id" value="<?php echo (int)$unit_id; ?>">
            <input type="hidden" name="class_id" value="<?php echo (int)$class_id; ?>">


              <!-- Select a file  -->
              <div class="row">
              <div class="col">
                <label class="formFields" for="date_of_birth">Choose a File</label>
                <input class="placeholder_style mb-2 " type="file" name="userFile" id="userFile"  
                       accept=".pdf,.pptx,.docx,.xlsx">
</div>
              </div>
              
             

              <!-- Category -->
               <div class="row">
              <div class="col">
                <label class="formFields">Category</label>
                <select name="category" class="placeholder_style mb-2" required>
                  <option value="">Choose category</option>
                  <option value="Lecture Notes">Lecture Notes</option>
                  <option value="Slides">Slides</option>
                  <option value="Assignment Brief">Assignment Brief</option>
                  <option value="Worksheet">Worksheet</option>
                  <option value="Reading Material">Reading Material</option>
                  <option value="Template">Template</option>
                  <option value="Rubric">Rubric</option>
                  <option value="Other">Other</option>
                </select>
              </div>
              </div>

    

              <!-- Notes -->
              <div class="row">
              <div class="col">
                <label class="formFields">Notes</label>
                <textarea name="notes" class="placeholder_style mb-2" rows="4" placeholder="Add notes (optional)"></textarea>
              </div>
</div>
              <!-- Buttons -->
              <div class="row d-flex ">
              <div class="col-lg-3"></div>
                    <div class="col-lg-2">
                  <button type="submit" name="uploadFile" value="upload" class="btn button">Send</button>
                </div>
                <div class="col-lg-2"></div>
                        
                    <div class="col-lg-2">
                   <button href="teacher_upload_file.php" class="button btn" type="reset" name="reset"  id="reset">Cancel</button>
                  
                <div class="col-lg-3"></div>
                </div>
              </div>

            </form>

          </div>
        </div>
      </div>
    </div>

  </div>
</div>
