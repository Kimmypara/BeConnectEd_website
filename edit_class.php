<?php
session_start();
include "includes/conditions.php";
include "includes/nav.php";
require_once "includes/dbh.php";
require_once "includes/functions.php";

$class_id = (int)($_GET["class_id"] ?? 0);
if ($class_id <= 0) {
  header("Location: classes_admin.php?error=missingclassid");
  exit();
}

$class = getClassById($conn, $class_id);
if (!$class) {
  header("Location: classes_admin.php?error=classnotfound");
  exit();
}

$coursesRes = getCourses($conn); 
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
              
              <!--close button -->
              <div class="row">
                <div class="col-10"><h2 class=" form_title">Edit or View Class data</h2></div>
                <div class="col-1">
                <a href="classes_admin.php" class=" close mt-0" alt="close button"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
  <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"/>
</svg></a>
</div>
<div class="col-1"></div>
</div>
             


              <!--  form -->
      <div class="row">
 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
          <div>


           <form action="includes/edit_classes_inc.php" method="post">
  <input type="hidden" name="class_id" value="<?php echo (int)$class['class_id']; ?>">

  <div class="row mb-3">
    <div class="col-3 d-flex align-items-center">
      <label class="formFields mb-0">Class Name</label>
    </div>
    <div class="col-8">
      <input
        type="text"
        name="class_name"
        class="form-control placeholder_style"
        required
        value="<?php echo htmlspecialchars($class['class_name'] ?? ''); ?>"
      >
    </div>
    <div class="col-1"></div>
  </div>

  <div class="row mb-3">
    <div class="col-3 d-flex align-items-center">
      <label class="formFields mb-0">Course</label>
    </div>
    <div class="col-8">
      <select name="course_id" class="form-select w-100 placeholder_style me-auto" required>
        <option value="" disabled>Select course</option>

        <?php while($c = mysqli_fetch_assoc($coursesRes)): ?>
          <option
            value="<?php echo (int)$c['course_id']; ?>"
            <?php echo ((int)$c['course_id'] === (int)$class['course_id']) ? 'selected' : ''; ?>
          >
            <?php echo htmlspecialchars($c['course_code'] . " - " . $c['course_name']); ?>
          </option>
        <?php endwhile; ?>
      </select>
    </div>
    <div class="col-1"></div>
  </div>

  <?php
  if (isset($_GET["error"])) {
    $msg = "<h5>Could not update class:</h5><ul>";
    if (isset($_GET["emptyinput"])) $msg .= "<li>You have some empty fields.</li>";
    if (isset($_GET["invalidClass_name"])) $msg .= "<li>Class name format invalid.</li>";
    $msg .= "</ul>";
    echo $msg;
  }
  ?>

  <div class="row d-flex ">
              <div class="col-lg-3"></div>
                    <div class="col-lg-2">
                        <button class="button btn" type="submit" name="submit"  id="submit">Update</button>
                    </div>
                    <div class="col-lg-2"></div>
                        
                    <div class="col-lg-2">
                        <button href="classes_admin.php" class="button btn" type="reset" name="reset"  id="reset">Cancel</button>
                    </div>
                        <div class="col-lg-3"></div>
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










