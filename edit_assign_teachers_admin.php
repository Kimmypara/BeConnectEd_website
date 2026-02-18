<?php
session_start();
include "includes/conditions.php";
require_once "includes/dbh.php";
require_once "includes/functions.php";
include "includes/nav.php";

$teacher_id = (int)($_GET["teacher_id"] ?? 0);
$old_class_id = (int)($_GET["class_id"] ?? 0);

if ($teacher_id <= 0 || $old_class_id <= 0) {
  header("Location: assign_teachers_admin.php?error=missingdata");
  exit();
}

// teacher
$teacher = getTeachersActiveById($conn, $teacher_id);
if (!$teacher) {
  header("Location: assign_teachers_admin.php?error=teachernotfound");
  exit();
}

// all classes + all active units
$classesRes = getClasses($conn);
$unitsRes   = getUnitsActive($conn);
$userRes   = getTeachersActive($conn);


$assignedIds = [];
$assignedRes = getUnitIdsByTeacherAndClass($conn, $teacher_id, $old_class_id);
if ($assignedRes) {
  while ($r = mysqli_fetch_assoc($assignedRes)) {
    $assignedIds[] = (int)$r['unit_id'];
  }
}
?>
<div class="container-fluid">
  <div class="row">

    <div class="col-lg-2 col-md-3 p-0">
      <?php include 'includes/menuadmin.php'; ?>
    </div>

    <div class="col-1"></div>

    <div class="col-lg-9 col-md-8">
      <div class="form_bg">

                   <!--close button -->
              <div class="row">
                <div class="col-10"><h2 class=" form_title">Edit Assigned Teachers</h2></div>
                <div class="col-1">
                <a href="assign_teachers_admin.php" class=" close mt-0" alt="close button"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
  <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"/>
</svg></a>
</div>
<div class="col-1"></div>
</div>

<div class="row">
  <div class="col-lg-12 formFields3">
        
          
        
        </div>
</div>


        <form action="includes/edit_assign_teachers_inc.php" method="post">
          <input type="hidden" name="teacher_id" value="<?php echo $teacher_id; ?>">
          <input type="hidden" name="old_class_id" value="<?php echo $old_class_id; ?>">

              <!-- Change teacher -->
          <div class="row align-items-center mb-3">
            <div class="col-3">
              <label class="formFields mb-0">Lecturer </label>
            </div>
            <div class="col-9">
              <select name="teacher_id" class="form-select placeholder_style" required>
                <option value="" disabled>Select Lecturer</option>
                <?php while ($u = mysqli_fetch_assoc($userRes)): ?>
                  <option value="<?php echo (int)$u['user_id']; ?>"
                    <?php echo ((int)$u['user_id']) ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($u['first_name']); ?>
                    <?php echo htmlspecialchars($u['last_name']); ?>
                  </option>
                <?php endwhile; ?>
              </select>
            </div>
          </div>

          <!-- Change class -->
          <div class="row align-items-center mb-3">
            <div class="col-3">
              <label class="formFields mb-0">Class</label>
            </div>
            <div class="col-9">
              <select name="class_id" class="form-select placeholder_style" required>
                <option value="" disabled>Select Class</option>
                <?php while ($c = mysqli_fetch_assoc($classesRes)): ?>
                  <option value="<?php echo (int)$c['class_id']; ?>"
                    <?php echo ((int)$c['class_id'] === $old_class_id) ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($c['class_name']); ?>
                  </option>
                <?php endwhile; ?>
              </select>
            </div>
          </div>

          <!-- Units checkboxes -->
          <div class="row mb-3">
            <div class="col-3">
              <label class="formFields mb-0">Units</label>
            </div>
            <div class="col-9 border rounded p-3 units-box" style="max-height:260px; overflow:auto;">
              <div class="border rounded p-3" style="max-height:260px; overflow:auto;">
                <?php while ($u = mysqli_fetch_assoc($unitsRes)): 
                  $uid = (int)$u['unit_id'];
                  $checked = in_array($uid, $assignedIds, true);
                ?>
                  <div class="form-check mb-2">
                    <input class="form-check-input"
                           type="checkbox"
                           name="unit_ids[]"
                           value="<?php echo $uid; ?>"
                           id="unit_<?php echo $uid; ?>"
                           <?php echo $checked ? 'checked' : ''; ?>>
                    <label class="form-check-label" for="unit_<?php echo $uid; ?>">
                      <?php echo htmlspecialchars($u['unit_code'] . " - " . $u['unit_name']); ?>
                    </label>
                  </div>
                <?php endwhile; ?>
              </div>
              <small class="text-muted error-msg">Tick to keep/add. Untick to remove.</small>
            </div>
          </div>

          <?php if (isset($_GET['success'])): ?>
            <p class="text-success small">Saved successfully.</p>
          <?php endif; ?>
          <?php if (isset($_GET['error'])): ?>
            <p class="text-danger small">Please, check one or more units.</p>
          <?php endif; ?>


           <div class="row d-flex ">
              <div class="col-lg-3"></div>
                    <div class="col-lg-2">
                        <button class="button btn" type="submit" name="submit"  id="submit">Update</button>
                    </div>
                    <div class="col-lg-2"></div>
                        
                    <div class="col-lg-2">
                        <button href="assign_teachers_admin.php" class="button btn" type="reset" name="reset"  id="reset">Cancel</button>
                    </div>
                        <div class="col-lg-3"></div>
                </div>

      

        </form>
      </div>
    </div>

  </div>
</div>
