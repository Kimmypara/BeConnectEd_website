<?php session_start(); ?>
<?php
include "includes/conditions.php";
include "includes/nav.php";
require_once "includes/dbh.php";
require_once "includes/functions.php";

$unit = null;

if(isset($_GET["unit_id"]) && is_numeric($_GET["unit_id"])){
    $unit_id = (int)$_GET["unit_id"];
    $unit = getUnitById($conn, $unit_id);
}
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
              
              <!--close button -->
              <div class="row">
                <div class="col-10"><h2 class=" form_title">Edit or View Unit data</h2></div>
                <div class="col-1">
                <a href="courses_admin.php" class="close mt-0" alt="close button"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
  <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"/>
</svg></a>
</div>
<div class="col-1"></div>
</div>
             


              <!-- Your form -->
      <div class="row">
 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
          <div>
<?php

if(isset($_GET["unit_id"])){
    $selectedFormAction = "includes/edit_unit_inc.php?unit_id=" . (int)$_GET["unit_id"];
} else {
    $selectedFormAction = "includes/units_inc.php";
}

?>

            <form action="<?php echo $selectedFormAction; ?>" method="post">

             <div class="row">
                    <div class="col">
                      <label class="formFields" for="unit_name">Unit Name</label>
                        <input type="text" name="unit_name" id="unit_name"
                         value="<?php echo htmlspecialchars($unit['unit_name'] ?? ''); ?>" 
                         placeholder="unit name" class="placeholder_style mb-2 ">
                    </div>
                </div>

                

                <div class="row">
                    <div class="col">
                      <label class="formFields" for="unit_code">Unit Code</label>
                        <input type="text" name="unit_code" id="unit_code" 
                         value="<?php echo htmlspecialchars($unit['unit_code'] ?? ''); ?>" 
                        placeholder="unit code" class="placeholder_style mb-2">
                    </div>
                </div>  

                <div class="row">
                    <div class="col">
                      <label class="formFields" for="ects_credits">ECTS Credits</label>
                        <input type="text" name="ects_credits" id="ects_credits" 
                         value="<?php echo htmlspecialchars($unit['ects_credits'] ?? ''); ?>" 
                        placeholder="ECTS credits " class="placeholder_style mb-2">
                    </div>
                </div>  


                 <div class="row">
                    <div class="col">
                      <label class="formFields" for="unit_duration"> Unit Duration</label>
                        <input type="text" name="unit_duration" id="unit_duration" 
                         value="<?php echo htmlspecialchars($unit['unit_duration'] ?? ''); ?>" 
                        placeholder="unit duration" class="placeholder_style mb-2">
                    </div>
                </div> 

               
              
              <label class="formFields" for="is_active">Active or Inactive?</label>
              <select  class="placeholder_style mb-2" id="is_active" name="is_active" >
              <option class="input" value="" disabled selected>Choose if user is Active or Inactive</option>
              <option class="input" value="1"<?php echo (($unit['is_active'] ?? '') == 1) ? 'selected' : ''; ?>>Active</option>
              <option class="input" value="0"<?php echo (($unit['is_active'] ?? '') == 0) ? 'selected' : ''; ?>>Inactive</option>
              </select>


        <div>
            <label class="formFields" for="unit_description">Unit Description</label>
            <textarea  class="placeholder_style mb-2" name="unit_description" id="unit_description" placeholder="Unit Description..."
              rows="20"> <?php echo htmlspecialchars($unit['unit_description'] ?? ''); ?></textarea>
          </div>

             
         
             <div class="row d-flex ">
              <div class="col-lg-3"></div>
                    <div class="col-lg-2">
                        <button class="button btn" type="submit" name="submit"  id="submit">Update</button>
                    </div>
                    <div class="col-lg-2"></div>
                        
                    <div class="col-lg-2">
                        <button href="courses_admin.php" class="button btn" type="reset" name="reset"  id="reset">Cancel</button>
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










