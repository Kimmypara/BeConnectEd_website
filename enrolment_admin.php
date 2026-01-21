<?php
session_start();
include "includes/conditions.php";
include "includes/nav.php";
require_once "includes/dbh.php";
require_once "includes/functions.php";

$coursesRes = getCourses($conn);

$course_id = (int)($_GET['course_id'] ?? 0);
$class_id  = (int)($_GET['class_id'] ?? 0);

$classesRes = ($course_id > 0) ? getClassesByCourseId($conn, $course_id) : false;

// Students to add
$studentsRes = getStudentsActive($conn);

// Enrolled list (by class)
$enrolledStudentsRes = ($class_id > 0) ? getStudentsByClassId($conn, $class_id) : false;
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

            <h2 class="form_title text-center mb-4">Enrol Students to Classes</h2>

            <!-- COURSE SELECT -->
            <div class="row align-items-center mb-4">
              <div class="col-lg-2 col-md-3">
                <label class="formFields mb-0">Course</label>
              </div>

              <div class="col-lg-7 col-md-9">
                <select class="form-select placeholder_style"
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

            <!-- CLASS SELECT -->
            <div class="row align-items-center mb-4">
              <div class="col-lg-2 col-md-3">
                <label class="formFields mb-0">Class</label>
              </div>

              <div class="col-lg-7 col-md-9">
                <select class="form-select placeholder_style"
                        <?php echo ($course_id<=0 ? 'disabled' : ''); ?>
                        onchange="if(this.value) window.location='enrolment_admin.php?course_id=<?php echo $course_id; ?>&class_id=' + this.value;">
                  <option value="" disabled <?php echo ($class_id<=0?'selected':''); ?>>
                    Select a class
                  </option>

                  <?php if ($classesRes): ?>
                    <?php while($cl = mysqli_fetch_assoc($classesRes)): ?>
                      <option value="<?php echo (int)$cl['class_id']; ?>"
                        <?php echo ($class_id === (int)$cl['class_id']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($cl['class_name']); ?>
                      </option>
                    <?php endwhile; ?>
                  <?php endif; ?>
                </select>
              </div>
            </div>

            <!-- ADD STUDENT FORM -->
            <form action="includes/enrolment_admin_inc.php" method="post">
              <input type="hidden" name="course_id" value="<?php echo $course_id; ?>">
              <input type="hidden" name="class_id" value="<?php echo $class_id; ?>">

              <div class="row align-items-center mb-4">
                <div class="col-lg-2 col-md-3">
                  <label class="formFields mb-0">Add student</label>
                </div>

                <div class="col-lg-7 col-md-7">
                  <select name="student_id" class="form-select placeholder_style"
                          <?php echo ($course_id<=0 || $class_id<=0 ? 'disabled' : 'required'); ?>>
                    <option value="" disabled selected>Search by Student name</option>
                    <?php while($st = mysqli_fetch_assoc($studentsRes)): ?>
                      <option value="<?php echo (int)$st['user_id']; ?>">
                        <?php echo htmlspecialchars($st['first_name'] . " " . $st['last_name']); ?>
                      </option>
                    <?php endwhile; ?>
                  </select>
                </div>

                <div class="col-lg-2 col-md-2 mt-2 mt-md-0">
                  <button type="submit"
                          name="add"
                          class="btn button5 w-100"
                          <?php echo ($course_id<=0 || $class_id<=0 ? 'disabled' : ''); ?>>
                    Add
                  </button>
                </div>
              </div>
            </form>

            <!-- ENROLLED STUDENTS LIST -->
            <div class="row mb-4">
              <div class="col-lg-2 col-md-3">
                <label class="formFields mb-0">Enrolled students</label>
              </div>

              <div class="col-lg-7 col-md-9">

                <?php if ($class_id > 0 && $enrolledStudentsRes && mysqli_num_rows($enrolledStudentsRes) > 0): ?>

                  <table class="table_admin">
                    <tr>
                      <th>Student</th>
                      <th style="width:160px;"></th>
                    </tr>

                    <?php while ($s = mysqli_fetch_assoc($enrolledStudentsRes)): ?>
                      <tr>
                        <td><?php echo htmlspecialchars($s['first_name'] . " " . $s['last_name']); ?></td>
                        <td class="text-center">
                          <form action="includes/enrolment_admin_inc.php" method="post" class="m-0">
                            <input type="hidden" name="course_id" value="<?php echo (int)$course_id; ?>">
                            <input type="hidden" name="class_id" value="<?php echo (int)$class_id; ?>">
                            <input type="hidden" name="student_id" value="<?php echo (int)$s['user_id']; ?>">
                            <button class="btn button4" type="submit" name="remove">Remove</button>
                          </form>
                        </td>
                      </tr>
                    <?php endwhile; ?>
                  </table>

                <?php elseif ($course_id > 0 && $class_id > 0): ?>
                  <p class="text-muted mb-0">No students enrolled to this class yet.</p>
                <?php elseif ($course_id > 0): ?>
                  <p class="text-muted mb-0">Select a class to view enrolled students.</p>
                <?php else: ?>
                  <p class="text-muted mb-0">Select a course first.</p>
                <?php endif; ?>

              </div>
            </div>

            <!-- CANCEL -->
            <div class="row mt-4">
              <div class="col-lg-12">
                <button type="button" class="btn button8 w-100"
                        onclick="window.location='enrolment_admin.php'">
                  Cancel
                </button>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>

  </div>
</div>
