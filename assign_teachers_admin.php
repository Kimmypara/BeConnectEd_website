
<?php
include "includes/nav.php";
include 'includes/conditions.php'
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
  <div class="col-lg-9 col-md-8">
      <div class="row">  
        <div class="col-12">  
            <div class="form_bg">
              <h2 class=" form_title">Assign Teachers to Units
        <!--form-->
               <form action="includes/assign_teacher_units_inc.php" method="post" id="assignUnitsForm">
        <div class="modal-body">

           <!-- Units container -->
          <div id="unitsContainer">
            <div class="row align-items-center mb-3 unit-row">
              <div class="col-3">
                <label class="formFields mb-0">Choose Unit</label>
              </div>
              <div class="col-9">
                <select name="unit_ids[]" class="form-select placeholder_style unit-select" required>
                  <option value="" disabled selected>Units</option>

                  <?php
                  // IMPORTANT: we need units again because we looped once
                 
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

   <!-- teachers container -->
          <div id="teachersContainer">
            <div class="row align-items-center mb-3 teacher-row">
              <div class="col-3">
                <label class="formFields mb-0">Choose Teacher</label>
              </div>
              <div class="col-9">
         <select name="user_ids[]" class="form-select placeholder_style teacher-select" required>
  <option value="" disabled selected>Teachers</option>

  <?php
  $teachersRes3 = getTeachersActive($conn);

  if ($teachersRes3) :
    while ($t = mysqli_fetch_assoc($teachersRes3)) :
  ?>
      <option value="<?php echo (int)$t['user_id']; ?>">
        <?php echo htmlspecialchars($t['first_name'] . " " . $t['last_name']); ?>
      </option>
  <?php
    endwhile;
  endif;
  ?>
</select>

              </div>
            </div>
          </div>


             <!-- classes container -->
          <div id="classesContainer">
            <div class="row align-items-center mb-3 classes-row">
              <div class="col-3">
                <label class="formFields mb-0">Choose Class</label>
              </div>
              <div class="col-9">
         <select name="class_ids[]" class="form-select placeholder_style classes-select" required>
  <option value="" disabled selected>Classes</option>

  <?php
  $classesRes4 = getClasses($conn);

  if ($classesRes4) :
    while ($c = mysqli_fetch_assoc($classesRes4)) :
  ?>
      <option value="<?php echo (int)$c['class_id']; ?>">
        <?php echo htmlspecialchars($c['class_name'] . " " . $course['course_name']); ?>
      </option>
  <?php
    endwhile;
  endif;
  ?>
</select>

              </div>
            </div>
          </div>
  
          
             <div class="row d-flex ">
              <div class="col-lg-2"></div>
                    <div class="col-lg-3">
                         <button type="submit" name="submit" class="btn button8">Save</button>
                    </div>
                    <div class="col-lg-2"></div>
                        
                    <div class="col-lg-3">
                        <button href="courses_admin.php" class="btn button8 " type="reset" name="reset"  id="reset">Cancel</button>
                    </div>
                        <div class="col-lg-2"></div>
                </div>

        </div>

       

      </form>
            </div>
         </div>
      </div>
   </div>

  




</div>
</div>
