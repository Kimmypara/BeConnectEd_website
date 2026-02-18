<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

require_once "includes/dbh.php";
include "includes/conditions.php";
include "includes/nav.php";

$class_id = (int)($_GET['class_id'] ?? 0);

if ($class_id <= 0) {
  
  $class = null;
} else {
  $sql = "SELECT class_name FROM classes WHERE class_id = ? LIMIT 1";
  $stmt = mysqli_stmt_init($conn);
  mysqli_stmt_prepare($stmt, $sql);
  mysqli_stmt_bind_param($stmt, "i", $class_id);
  mysqli_stmt_execute($stmt);
  $res = mysqli_stmt_get_result($stmt);
  $class = mysqli_fetch_assoc($res);
  mysqli_stmt_close($stmt);
}
?>



<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
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
            <div class="row align-items-center">



      <!--Table --> 
     <div class="col-lg-1 col-md-1 col-sm-1"> 
      <a href="enrolment_teacher.php" class="close mt-0"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"  viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8"/>
</svg></a> </div>
<div class="col-lg-10 col-md-10 col-sm-10">

<?php if (!$class): ?>
  <h2 class="form_title">Attendance</h2>
  <div class="alert alert-warning text-center">No class selected.</div>
<?php else: ?>
  <h2 class="form_title">Attendance for <?php echo htmlspecialchars($class['class_name']); ?></h2>
<?php endif; ?>
</div>
<div class="col-lg-1 col-md-1 col-sm-1"> </div>

<div class="row align-items-center">
  <div class="col-lg-12 col-md-12 col-sm-12">
<table class="table_admin"  >
  <tr>
    <th>Student First Name</th>
    <th>Student Last Name </th>
    <th>E-mail Address</th>
   
  </tr>

  <?php
 $result = getStudentsByClassId($conn, $class_id);

while($row = mysqli_fetch_assoc($result)){
  echo '<tr>';
  echo '<td>' . $row['first_name'] . '</td>';
  echo '<td>' . $row['last_name'] . '</td>';
  echo '<td>' . $row['email'] . '</td>';
 
  echo '</tr>';
}


  ?>
                    </table>
                </div>
</div>
            </div>
        </div>
 </div>
    </div>
