
<?php
session_start();
include "includes/conditions.php";
include "includes/nav.php";
require_once 'includes/users.php';
?>


<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>


<div class="container-fluid">
  <div class="row">

      <div class="col-lg-2 col-md-3 p-0">
          <?php include 'includes/menuadmin.php'; ?>
      </div>
     

    <div class="col-1"></div>
  <div class="col-lg-9 col-md-8">
      <div class="row">  
        <div class="col-12">  
            <div class="form_bg">
            <div class="row align-items-center">

                <!-- SEARCH BAR -->
                <div class="col-lg-5 col-md-6 col-sm-4">
                    <form class="d-flex">
                       
                        <button class="search_button btn-outline-success my-3" type="submit">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                            </svg>
                        </button>
                         <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    </form>
                </div>

                    <!-- Add new class BUTTON -->
                    <div class="col-lg-6 col-md-6 col-sm-12 text-end mt-3 mt-md-0">
                    <button type="button" class="btn button7" data-bs-toggle="modal" data-bs-target="#addNewClassModal">
                    New Class
                    </button>
                    </div>

                <div class="col-lg-4 col-md-2 col-sm-4 text-end">
                    
                </div>

      <!--Table -->  
<div class="col-lg-12 col-md-12 col-sm-12">
<table class="table_admin"  >
  <tr>
    <th>Class Name</th>
    <th>Course</th>
    <th>Assigned Units codes</th>
      <th></th>
  </tr>

  <?php
$result = getClassesWithUnits($conn);

if ($result) {
  while($row = mysqli_fetch_assoc($result)){
    echo '<tr>';
    echo '<td>' . htmlspecialchars($row['class_name']) . '</td>';
    echo '<td>' . htmlspecialchars(($row['course_code'] ?? '') . ' - ' . ($row['course_name'] ?? '')) . '</td>';
     


 echo '<td>';
  if (!empty($row['unit_codes'])) {
    $codes = explode(', ', $row['unit_codes']);
    echo '<p class="mb-0 mt-1 ps-3">';
    foreach ($codes as $code) {
      echo '<p >' . htmlspecialchars($code) . '</p>';
    }
    echo '</p>';
  } else {
    echo '—';
  }
  echo '</td>';

    echo '<td class="text-center">
<a href="edit_class.php?class_id=' . (int)$row['class_id'] . '" class="button_table">View / Edit</a>  
          </td>';

    echo '</tr>';
  }
}
  ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
   </div>   
  </div>
</div>
<?php $coursesRes = getCourses($conn); ?>

<div class="modal fade" id="addNewClassModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content form_bg3">

      <div class="modal-header">
        <h5 class="modal-title">New Class</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <form action="includes/classes_inc.php" method="post">
        <div class="modal-body">

          <div class="row mb-3">
            <div class="col-3 d-flex align-items-center">
              <label class="formFields mb-0">Class Name</label>
            </div>
            <div class="col-9">
              <input type="text" name="class_name" class="form-control placeholder_style" required>
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-3 d-flex align-items-center">
              <label class="formFields mb-0">Course</label>
            </div>
            <div class="col-9">
              <select name="course_id" class="form-select placeholder_style" required>
                <option value="" disabled selected>Select course</option>
                <?php while($c = mysqli_fetch_assoc($coursesRes)): ?>
                  <option value="<?php echo (int)$c['course_id']; ?>">
                    <?php echo htmlspecialchars($c['course_code'] . " - " . $c['course_name']); ?>
                  </option>
                <?php endwhile; ?>
              </select>
            </div>
          </div>

          <?php
if (isset($_GET["error"])) {
  $msg = "<h5>Could not create class:</h5><ul>";

  if (isset($_GET["emptyinput"])) {
    $msg .= "<li>You have some empty fields.</li>";
  }
  if (isset($_GET["invalidClass_name"])) {
    $msg .= "<li>Class name format invalid.</li>";
  }
  if (isset($_GET["invalidCourse"])) {
    $msg .= "<li>Please select a course.</li>";
  }
  if (isset($_GET["stmtfailed"])) {
    $msg .= "<li>Server error. Please try again.</li>";
  }

  $msg .= "</ul>";
  echo $msg;
}
?>


          <div class="row d-flex">
            
            <div class="col-lg-6">
              <button type="submit" name="submit" class="btn button8 w-100">Save</button>
            </div>

            <div class="col-lg-6 text-end">
              <button type="button" class="btn button8" data-bs-dismiss="modal">Cancel</button>
            </div>
          </div>

        </div>
      </form>

    </div>
  </div>
</div>
