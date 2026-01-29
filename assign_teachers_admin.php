<?php
session_start();
include "includes/conditions.php";
include "includes/nav.php";
require_once "includes/users.php";
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
                <div class="col-lg-4 col-md-2 col-sm-4 text-end">
                    
                </div>

                <!-- REGISTER BUTTON -->
                 
                <button type="button" class="btn button7" data-bs-toggle="modal" data-bs-target="#assignTeacherModal">
                  Assign New Teacher to Unit and Class
                </button>
             
              <div class="col-lg-12 col-md-12 col-sm-12 mt-3">
                <table class="table_admin">
                  <tr>
                    <th>Teacher</th>
                    <th>Class</th>
                    <th>Units</th>
                    <th></th>
                  </tr>

                  <?php
                    $res = getTeacherClassUnitSummary($conn);

                    if ($res && mysqli_num_rows($res) > 0):
                      while ($row = mysqli_fetch_assoc($res)):
                        $teacherId = (int)$row['teacher_id'];
                        $classId   = (int)$row['class_id'];
                  ?>
                        <tr>
                          <td><?php echo htmlspecialchars($row['teacher_name']); ?></td>
                          <td><?php echo htmlspecialchars($row['class_name']); ?></td>
                         

                           <?php echo '<td>';
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
  echo '</td>';?>
                          <td class="text-center">
                            <a class="button_table"
                               href="edit_assign_teachers_admin.php?teacher_id=<?php echo $teacherId; ?>&class_id=<?php echo $classId; ?>">
                               
                              View / Edit
                            </a>
                          </td>
                        </tr>
                  <?php
                      endwhile;
                    else:
                  ?>
                      <tr><td colspan="4" class="text-center">No assignments found.</td></tr>
                  <?php endif; ?>
                </table>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>

<!-- MODAL -->
<div class="modal fade" id="assignTeacherModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content form_bg3">

      <div class="modal-header">
        <h5 class="modal-title">Assign New Teacher to Unit and Class</h5>
        <button type="button" class="btn close3" data-bs-dismiss="modal"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
  <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"/>
</svg></button>
      </div>

      <form action="includes/assign_teacher_units_inc.php" method="post">
        <div class="modal-body">

          <!-- Unit -->
          <div class="row align-items-center mb-3">
            <div class="col-3">
              <label class="formFields mb-0">Choose Unit</label>
            </div>
            <div class="col-9">
              <select name="unit_ids[]" class="form-select placeholder_style" required>
                <option value="" disabled selected>Units</option>
                <?php
                  $unitsRes = getUnitsActive($conn);
                  while ($unit = mysqli_fetch_assoc($unitsRes)):
                ?>
                  <option value="<?php echo (int)$unit['unit_id']; ?>">
                    <?php echo htmlspecialchars($unit['unit_code'] . " - " . $unit['unit_name']); ?>
                  </option>
                <?php endwhile; ?>
              </select>
            </div>
          </div>

          <!-- Teacher -->
          <div class="row align-items-center mb-3">
            <div class="col-3">
              <label class="formFields mb-0">Choose Teacher</label>
            </div>
            <div class="col-9">
              <select name="user_ids[]" class="form-select placeholder_style" required>
                <option value="" disabled selected>Teachers</option>
                <?php
                  $teachersRes = getTeachersActive($conn);
                  while ($t = mysqli_fetch_assoc($teachersRes)):
                ?>
                  <option value="<?php echo (int)$t['user_id']; ?>">
                    <?php echo htmlspecialchars($t['first_name'] . " " . $t['last_name']); ?>
                  </option>
                <?php endwhile; ?>
              </select>
            </div>
          </div>

          <!-- Class -->
          <div class="row align-items-center mb-3">
            <div class="col-3">
              <label class="formFields mb-0">Choose Class</label>
            </div>
            <div class="col-9">
              <select name="class_id" class="form-select placeholder_style" required>
                <option value="" disabled selected>Select Class</option>
                <?php
                  $classesRes = getClasses($conn);
                  while ($c = mysqli_fetch_assoc($classesRes)):
                ?>
                  <option value="<?php echo (int)$c['class_id']; ?>">
                    <?php echo htmlspecialchars($c['class_name']); ?>
                  </option>
                <?php endwhile; ?>
              </select>
            </div>
          </div>

           <div class="col-12 mt-2">
                <?php if (isset($_GET['success'])): ?>
                  <p class="text-success small mb-0">Saved successfully.</p>
                <?php endif; ?>
                <?php if (isset($_GET['error'])): ?>
                  <p class="text-danger small mb-0">Something went wrong. Please try again.</p>
                <?php endif; ?>
              </div>

          <div class="row">
            <div class="col-lg-6">
              <button type="submit" name="submit" class="button btn">Save</button>
            </div>
            <div class="col-lg-6">
              <button  class="button btn"  type="reset" name="reset"  id="reset">Cancel</button>
            </div>
          </div>

        </div>
      </form>

    </div>
  </div>
</div>


