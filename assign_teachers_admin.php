<?php
session_start();
include "includes/nav.php";
include "includes/conditions.php";
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
                  Assign Teachers to Units
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
                          <td><?php echo htmlspecialchars($row['unit_codes'] ?? '—'); ?></td>
                          <td class="text-center">
                            <a class="button_table"
                               href="edit-assignment.php?teacher_id=<?php echo $teacherId; ?>&class_id=<?php echo $classId; ?>">
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

<!-- MODAL: keep your existing form inside -->
<div class="modal fade" id="assignTeacherModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content form_bg3">

      <div class="modal-header">
        <h5 class="modal-title">Assign Teacher to Unit and Class</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
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
              <button type="submit" name="submit" class="btn button8 w-100">Save</button>
            </div>
            <div class="col-lg-6">
              <button type="button" class="btn button8 w-100" data-bs-dismiss="modal">Cancel</button>
            </div>
          </div>

        </div>
      </form>

    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
