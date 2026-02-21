<?php session_start(); ?>
<?php
include "includes/conditions.php";
include "includes/nav.php";

?>

<style>
<?php include 'css/style.css'; ?>
</style>

<div class="container-fluid">
  <div class="row">

      <div class="col-lg-2 col-md-3 p-0">
          <?php include 'includes/menuadmin.php'; ?>
      </div>
     

<div class="col-1"></div>
  <div class="col-lg-9 col-md-8 col-sm-12">
      <div class="row">  
        <div class="col-12">  
            <div class="form_bg4 mb-4">
            
                <div class="row align-items-center">

                   <!-- SEARCH BAR -->
                    <div class="col-lg-5 col-md-6 col-sm-12">
                        <form class="d-flex">
                            <button class="search_button btn-outline-success my-3" type="submit">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                     fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                                </svg>
                            </button>
                            <input class="form-control" type="search" placeholder="Search">
                        </form>
                    </div>
                    <div class="col-lg-3 col-md-2  text-end">
                    
                </div>

                    <!-- Assign Units to Course BUTTON -->
                    <div class="col-lg-4 col-md-4 col-sm-12 text-end ">
                    <button type="button" class="btn button" data-bs-toggle="modal" data-bs-target="#assignUnitsModal">
                    Assign Units to Course
                    </button>
                    </div>
    
              

<div class="form_bg2">
  
    <div class="row align-items-center">
<div class="row">
  <div class="col-lg-8 col-md-8 col-sm-12">
    <h2 class=" form_title2">Courses</h2>
  </div>

  <div class="col-lg-4">
    <a class="button6"  href="add_course.php">Add a Course</a>
  </div>
</div>
                
      <!--Table -->  
<div class="col-lg-11 col-md-11 col-sm-12">
<table class="table_admin"  >
  <tr>
    <th>Course Code</th>
    <th>Course Name</th >
    <th>MQF Level</th >
     <th></th>
     
  </tr>

  <?php
  $result = getCourses($conn);
  while($row = mysqli_fetch_assoc($result)){
  echo '<tr>';
  echo '<td>' .($row['course_code']) . '</td>';
echo '<td>' . ($row['course_name']) . '</td>';
echo '<td>' . ($row['MQF_Level']) . '</td>';


echo '<td class="text-center">';


echo '
<span  type="button" class="button4" data-bs-toggle="modal" data-bs-target="#confirmModal"
    data-type="course"
    data-id="' . (int)$row['course_id'] . '"
    data-action="' . ($row['is_active'] ? 'deactivate' : 'activate') . '">
    ' . ($row['is_active'] ? 'Deregister' : 'Register') . '
</span>';


if(isset($_GET["course_id"])){
    $selectedFormAction="includes/edit_course_inc,php";
}
else{
    $selectedFormAction="includes/add_course_admin_inc.php";
}


echo '<a href="edit_course.php?course_id=' . $row['course_id'] . '" class="button4">View/Edit</a>';


echo '</td>';
echo '</tr>';
}
  ?>
</table>
</div>   
        </div>
            </div>
            


<div class="form_bg2">
  <div class="row align-items-center">
   <div class="row">
  <div class="col-lg-8 .col-md-8 .col-sm-12">
    <h2 class=" form_title2">Units</h2>
  </div>

  <div class="col-lg-4 ">
    <a class="button6"  href="add_unit.php">Add a Unit</a>
  </div>
</div>
            

      <!--Table -->  
<div class="col-lg-11 col-md-11 col-sm-12">
<table class="table_admin"  >
  <tr>
     <th>Unit Code</th>
    <th>Unit Name</th >
    <th>ECTS Credits</th >
     <th></th>
  </tr>

  <?php
  $result = getUnits($conn);
  while($row = mysqli_fetch_assoc($result)){
  echo '<tr>';
echo '<td>' . ($row['unit_code']) . '</td>';
echo '<td>' .($row['unit_name']) . '</td>';
echo '<td>' . ($row['ects_credits']) . '</td>';

echo '<td class="text-center">';


echo '
<span type="button" class="button4" label="Register or Deregister" data-bs-toggle="modal" data-bs-target="#confirmModal"
    data-type="unit"
    data-id="' . (int)$row['unit_id'] . '"
    data-action="' . ($row['is_active'] ? 'deactivate' : 'activate') . '">
    ' . ($row['is_active'] ? 'Deregister' : 'Register') . '
</span>';


if(isset($_GET["unit_id"])){
    $selectedFormAction="includes/edit_unit_inc,php";
}
else{
    $selectedFormAction="includes/add_unit_inc.php";
}


echo '<a href="edit_unit.php?unit_id=' . $row['unit_id'] . '" class="button4">View/Edit</a>';


echo '</td>';
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

</div>
</div>

<div class="modal fade" id="confirmModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content form_bg3">

      <div class="modal-header">
        <h5 class="modal-title">Confirm action</h5>
        <button type="button" class="btn close2" data-bs-dismiss="modal"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
  <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"/>
</svg></button>
      </div>

      <div class="modal-body" id="confirmMessage">
        Are you sure you want to continue?
      </div>

      <div class="modal-footer">
        <button type="button" class="btn button5 btn-secondary" data-bs-dismiss="modal">
          Cancel
        </button>

        <a href="#" id="confirmActionBtn" class="btn button ">
          Confirm
        </a>
      </div>

    </div>
  </div>
</div>

<script>
const confirmModalEl = document.getElementById('confirmModal');

confirmModalEl.addEventListener('show.bs.modal', function (event) {
  const button = event.relatedTarget;

  const type = button.getAttribute('data-type'); // "course or unit"
  const id = button.getAttribute('data-id');
  const action = button.getAttribute('data-action'); // "activate or deactivate"

  const confirmBtn = document.getElementById('confirmActionBtn');
  const message = document.getElementById('confirmMessage');

  // Message 
  if (action === 'activate') {
    message.textContent = `Are you sure you want to register this ${type}?`;
    confirmBtn.className = 'btn btn-success';
  } else {
    message.textContent = `Are you sure you want to deregister this ${type}?`;
    confirmBtn.className = 'btn btn-danger';
  }

  
  if (type === 'course') {
    confirmBtn.href = `includes/update_course_status.php?course_id=${id}&action=${action}`;
  } else if (type === 'unit') {
    confirmBtn.href = `includes/update_unit_status.php?unit_id=${id}&action=${action}`;
  }
}
);
</script>

<?php
$coursesRes = getCourses($conn);
$unitsRes   = getUnits($conn);
?>

<div class="modal fade" id="assignUnitsModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content form_bg3">

      <div class="modal-header">
        <h5 class="modal-title">Assign Units to Course</h5>
        <button type="button" class="btn close3" data-bs-dismiss="modal"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
  <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"/>
</svg></button>
      </div>

      <form action="includes/assign_units_inc.php" method="post" id="assignUnitsForm">
        <div class="modal-body">

          <!-- Choose Course -->
          <div class="row align-items-center mb-3">
            <div class="col-3">
              <label class="formFields mb-0">Choose Course</label>
            </div>
            <div class="col-9">
              <select name="course_id" id="courseSelect" class="form-select placeholder_style" required>
                <option value="" disabled selected>Courses</option>
                <?php while ($course = mysqli_fetch_assoc($coursesRes)): ?>
                   <option value="<?php echo (int)$course['course_id']; ?>">
                    <?php echo htmlspecialchars(
                     $course['course_code'] . " - " . $course['course_name']
                     ); ?>
                    </option>
                <?php endwhile; ?>

              </select>
            </div>
          </div>

          <!-- Units container -->
          <div id="unitsContainer">
            <div class="row align-items-center unit-row">
              <div class="col-3">
                <label class="formFields mb-0">Choose Unit</label>
              </div>
              <div class="col-6">
                <select name="unit_ids[]" class="form-select placeholder_style unit-select" required>
                  <option value="" disabled selected>Units</option>

                  <?php
                  
                 
                  $unitsRes2 = getUnitsActive($conn);
                  while ($unit = mysqli_fetch_assoc($unitsRes2)):
                  ?>
                  <option value="<?php echo (int)$unit['unit_id']; ?>">
                   <?php echo htmlspecialchars(
                   $unit['unit_code'] . " - " . $unit['unit_name']
                   ); ?>
                  </option>
                <?php endwhile; ?>


                </select>
              </div>
            </div>
          </div>

          <!-- Add another unit -->
<div class="row">
          <div class="text-center my-3">
            <button type="button" class="btn button7" id="addUnitBtn">Add another Unit</button>
          </div>
</div>
          
             <div class="row d-flex ">
              <div class="col-lg-2"></div>
                    <div class="col-lg-3">
                         <button type="submit" name="submit" class="btn button8 mt-1">Assign Units</button>
                    </div>
                    <div class="col-lg-2"></div>
                        
                    <div class="col-lg-3">
                        <button href="courses_admin.php" class="btn button8 mt-1" type="reset" name="reset"  id="reset">Cancel</button>
                    </div>
                        <div class="col-lg-2"></div>
                </div>

        </div>

      </form>

    </div>
  </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', () => {
  const assignModal = document.getElementById('assignUnitsModal');
  const form = document.getElementById('assignUnitsForm');
  const unitsContainer = document.getElementById('unitsContainer');
  const addUnitBtn = document.getElementById('addUnitBtn');
  const courseSelect = document.getElementById('courseSelect');

 
  const firstSelect = unitsContainer.querySelector('select.unit-select');
  const unitOptionsHTML = firstSelect ? firstSelect.innerHTML : '';

  function buildUnitRow(selectedUnitId = "") {
    const row = document.createElement('div');
    row.className = 'row align-items-center mb-3 unit-row';

    row.innerHTML = `
      <div class="col-3">
        <label class="formFields mb-0">Choose Unit</label>
      </div>
      <div class="col-6">
        <select name="unit_ids[]" class="form-select placeholder_style unit-select" required>
          ${unitOptionsHTML}
        </select>
      </div>
     
      <div class="col-2 text-end">
        <button type="button" class="btn button5 remove-unit-btn">Remove</button>
      </div>
    `;

    const select = row.querySelector('select.unit-select');
    if (selectedUnitId) select.value = String(selectedUnitId);

    // remove row button
    row.querySelector('.remove-unit-btn').addEventListener('click', () => {
      row.remove();
      // keep at least 1 row
      if (unitsContainer.querySelectorAll('.unit-row').length === 0) {
        unitsContainer.appendChild(buildUnitRow(""));
      }
    });

    return row;
  }

  function resetUnitRowsToOneEmpty() {
    unitsContainer.innerHTML = '';
    unitsContainer.appendChild(buildUnitRow(""));
  }

  // Add another unit button
  addUnitBtn.addEventListener('click', () => {
    unitsContainer.appendChild(buildUnitRow(""));
  });

  // When course changes, load assigned units
  courseSelect.addEventListener('change', async () => {
    const courseId = courseSelect.value;
    if (!courseId) {
      resetUnitRowsToOneEmpty();
      return;
    }

    try {
      const res = await fetch(`includes/get_assigned_units_inc.php?course_id=${encodeURIComponent(courseId)}`);
      const assigned = await res.json();

      unitsContainer.innerHTML = '';

      if (Array.isArray(assigned) && assigned.length > 0) {
        assigned.forEach(u => {
          unitsContainer.appendChild(buildUnitRow(u.unit_id));
        });
      } else {
        resetUnitRowsToOneEmpty();
      }

    } catch (e) {
      console.error("Failed to load assigned units", e);
      resetUnitRowsToOneEmpty();
    }
  });

  // When modal closes, clear only units 
  assignModal.addEventListener('hidden.bs.modal', () => {
    form.reset();
    resetUnitRowsToOneEmpty();
  });

  
  resetUnitRowsToOneEmpty();
});
</script>

