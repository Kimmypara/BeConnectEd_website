
<?php
session_start();
include "includes/conditions.php";
include "includes/nav.php";
require_once "includes/dbh.php";
require_once "includes/functions.php";



$unit_id  = (int)($_GET['unit_id'] ?? 0);
$class_id = (int)($_GET['class_id'] ?? 0);
$teacher_id = (int)($_SESSION['user_id'] ?? 0);

if ($unit_id <= 0 || $class_id <= 0 || $teacher_id <= 0) {
  exit("<div class='alert alert-warning'>No unit/class selected.</div>");
}



$sql = "SELECT file_id, file_name, category, uploaded_at, notes
        FROM file
        WHERE unit_id = ?
        ORDER BY uploaded_at DESC";

$stmt = mysqli_stmt_init($conn);
mysqli_stmt_prepare($stmt, $sql);
mysqli_stmt_bind_param($stmt, "i", $unit_id);
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);

$sqlUnit = "SELECT unit_name FROM unit WHERE unit_id = ?";
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
          <?php include 'includes/menuteacher.php'; ?>
      </div>
     

    <div class="col-1"></div>
  <div class="col-lg-9 col-md-8">
      <div class="row">  
        
        <div class="col-lg-12">  
            <div class="form_bg">
                     <div class="row">
               <div class="col-lg-1 col-md-1 col-sm-1"> 
      <a href="teaching_units_teacher.php" class="close mt-0"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"  viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8"/>
</svg></a> </div>
<div class="col-8">
                  
              <h2 class=" form_title" >Files for<?php echo '&nbsp;' .htmlspecialchars($unit['unit_name']); ?> </h2></div>
 <div class="col-3">
<a href="teacher_upload_file.php?unit_id=<?php echo $unit_id; ?>&class_id=<?php echo $class_id;?> &teacher_id=<?php echo $teacher_id;?>" class="btn button9">
  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-upload mx-1" viewBox="0 0 16 16">
    <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5"/>
    <path d="M7.646 1.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 2.707V11.5a.5.5 0 0 1-1 0V2.707L5.354 4.854a.5.5 0 1 1-.708-.708z"/>
  </svg>
  Upload File
</a>
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
      </div>
   </div>





</div>
</div>