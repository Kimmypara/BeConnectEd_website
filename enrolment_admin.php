<?php
session_start();
include "includes/conditions.php";
include "includes/nav.php";
require_once "includes/dbh.php";
require_once "includes/functions.php";

$coursesRes  = getCourses($conn);


$course_id = (int)($_GET['course_id'] ?? 0);
$enrolledStudentsRes = ($course_id > 0) ? getStudentsByCourseId($conn, $course_id) : false;


$studentsRes = getStudentsActive($conn);
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

            <h2 class="form_title text-center mb-4">Enrol Students to Courses</h2>

            <!-- COURSE SELECT (reload page on change) -->
            <div class="row align-items-center mb-4">
              <div class="col-lg-2 col-md-3">
                <label class="formFields mb-0">Course</label>
              </div>

              <div class="col-lg-7 col-md-9">
                <select class="form-select placeholder_style"
                        id="courseSelect"
                        onchange="if(this.value) window.location='enrolment_admin.php?course_id=' + this.value;">
                  <option value="" disabled <?php echo ($course_id<=0?'selected':''); ?>>
                    Search by Course name or code
                  </option>

                  <?php while($course = mysqli_fetch_assoc($coursesRes)): ?>
                    <option value="<?php echo (int)$course['course_id']; ?>"
                      <?php echo ($course_id === (int)$course['course_id']) ? 'selected' : ''; ?>>
                      <?php echo htmlspecialchars($course['course_code'] . " - " . $course['course_name']); ?>
                    </option>
                  <?php endwhile; ?>
                </select>
              </div>
            </div>

            <!-- ENROLLED STUDENTS LIST -->
            <div class="row mb-4">
              <div class="col-lg-2 col-md-3">
                <label class="formFields mb-0">Enrolled students</label>
              </div>

              <div class="col-lg-7 col-md-9">
                <?php if($course_id <= 0): ?>
                  <p class="text-muted mb-0">Select a course to view enrolled students.</p>

                <?php elseif($enrolledStudentsRes && mysqli_num_rows($enrolledStudentsRes) > 0): ?>

                  <?php while($s = mysqli_fetch_assoc($enrolledStudentsRes)): ?>
                    <div class="d-flex align-items-center justify-content-between mb-2">
                      <div class="formFields mb-0">
                        <?php echo htmlspecialchars($s['first_name'] . " " . $s['last_name']); ?>
                      </div>

                      <!-- remove -->
                      <a class="btn button5"
                         href="includes/enrolment_remove_inc.php?course_id=<?php echo $course_id; ?>&user_id=<?php echo (int)$s['user_id']; ?>">
                        Remove
                      </a>
                    </div>
                  <?php endwhile; ?>

                <?php else: ?>
                  <p class="text-muted mb-0">No students enrolled to this course yet.</p>
                <?php endif; ?>
              </div>
            </div>

            <!-- ADD STUDENTS -->
            <form action="includes/enrolment_admin_inc.php" method="post">
              <input type="hidden" name="course_id" value="<?php echo $course_id; ?>">

              <div class="row align-items-center mb-4">
                <div class="col-lg-2 col-md-3">
                  <label class="formFields mb-0">Add students</label>
                </div>

                <div class="col-lg-7 col-md-7">
                  <select name="student_id" class="form-select placeholder_style" <?php echo ($course_id<=0?'disabled':'required'); ?>>
                    <option value="" disabled selected>Search by Student name or class name</option>
                    <?php while($st = mysqli_fetch_assoc($studentsRes)): ?>
                      <option value="<?php echo (int)$st['user_id']; ?>">
                        <?php echo htmlspecialchars($st['first_name'] . " " . $st['last_name']); ?>
                      </option>
                    <?php endwhile; ?>
                  </select>
                </div>

                <div class="col-lg-2 col-md-2 mt-2 mt-md-0">
                  <button type="submit"
                          name="submit"
                          class="btn button5 w-100"
                          <?php echo ($course_id<=0?'disabled':''); ?>>
                    Add
                  </button>
                </div>
              </div>

              <!-- SAVE / CANCEL -->
              <div class="row mt-4">
                <div class="col-lg-3"></div>

                <div class="col-lg-2 col-md-6 mb-2 mb-md-0">
                  <button type="submit" name="save" class="btn button8 w-100" <?php echo ($course_id<=0?'disabled':''); ?>>
                    Save
                  </button>
                </div>

                <div class="col-lg-2"></div>

                <div class="col-lg-2 col-md-6">
                  <a href="enrolment_admin.php" class="btn button8 w-100">
                    Cancel
                  </a>
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


