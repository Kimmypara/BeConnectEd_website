<?php session_start(); ?>
<?php
include "includes/nav.php";
include 'includes/conditions.php';
require_once "includes/dbh.php";
require_once "includes/functions.php";

$user = null;

if(isset($_GET["course_id"]) && is_numeric($_GET["course_id"])){
    $course_id = (int)$_GET["course_id"];
    $course = getCourseById($conn, $course_id);
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
                <div class="col-11"><h2 class=" form_title">Edit or View Course data</h2></div>
                <div class="col-1">
                <a href="registration_admin.php" class="button mt-0" alt="close button"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
  <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"/>
</svg></a>
</div>
</div>
             


              <!-- Your form -->
      <div class="row">
 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
          <div>
<?php

if(isset($_GET["course_id"])){
    $selectedFormAction = "includes/edit_course_inc.php?course_id=" . (int)$_GET["course_id"];
} else {
    $selectedFormAction = "includes/courses_inc.php";
}

?>

            <form action="<?php echo $selectedFormAction; ?>" method="post">

             
             <div class="row">
                    <div class="col">
                      <label class="formFields" for="course_name">Course Name</label>
                        <input type="text" name="course_name" id="course_name" placeholder="course name"
                         value="<?php echo htmlspecialchars($course['course_name'] ?? ''); ?>" 
                        class="placeholder_style mb-2 ">
                    </div>
                </div>

                

                <div class="row">
                    <div class="col">
                      <label class="formFields" for="course_code">Course Code</label>
                        <input type="text" name="course_code" id="course_code" placeholder="Course Code"
                            value="<?php echo htmlspecialchars($course['course_code'] ?? ''); ?>" 
                        class="placeholder_style mb-2">
                    </div>
                </div>  

                <div class="row">
                    <div class="col">
                      <label class="formFields" for="MQF_Level">MQF Level</label>
                        <input type="text" name="MQF_Level" id="MQF_Level" placeholder="MQF level" 
                            value="<?php echo htmlspecialchars($course['MQF_Level'] ?? ''); ?>" class="placeholder_style mb-2">
                    </div>
                </div>  

                   <div class="row">
                    <div class="col">
                      <label class="formFields" for="credits">Credits</label>
                        <input type="text" name="credits" id="credits" placeholder="credits" 
                            value="<?php echo htmlspecialchars($course['credits'] ?? ''); ?>" 
                        class="placeholder_style mb-2">
                    </div>
                </div> 

                 <div class="row">
                    <div class="col">
                      <label class="formFields" for="duration">Duration</label>
                        <input type="text" name="duration" id="duration" placeholder="duration" 
                            value="<?php echo htmlspecialchars($course['duration'] ?? ''); ?>" 
                        class="placeholder_style mb-2">
                    </div>
                </div> 

               
              
              <label class="formFields" for="is_active">Active or Inactive?</label>
              <select  class="placeholder_style mb-2" id="is_active" name="is_active" >
              <option class="input" value="" disabled selected>Choose if user is Active or Inactive</option>
              <option class="input" value="1" <?php echo (($course['is_active'] ?? '') == 1) ? 'selected' : ''; ?>>Active</option>
              <option class="input" value="0" <?php echo (($course['is_active'] ?? '') == 0) ? 'selected' : ''; ?>>Inactive</option>
              </select>

               
              <label class="formFields" for="institute_id">Institute</label>
              <select  class="placeholder_style mb-2" id="institute_id" name="institute_id" >
              <option class="input" value="" disabled selected>Choose an Institute</option>
              <option class="input"value="1" <?php echo (($course['institute_id'] ?? '') == 1) ? 'selected' : ''; ?>>MCAST Institute for the Creative Arts</option>
              <option class="input" value="2" <?php echo (($course['institute_id'] ?? '') == 2) ? 'selected' : ''; ?>>MCAST Institute of Applied Sciences</option>
              <option class="input" value="3" <?php echo (($course['institute_id'] ?? '') == 3) ? 'selected' : ''; ?>">University of Malta</option>
              <option class="input"value="4" <?php echo (($course['institute_id'] ?? '') == 4) ? 'selected' : ''; ?>>St. Benedict College</option>
              </select>

        <div>
            <label class="formFields" for="course_description">Course Description</label>
            <textarea class="placeholder_style mb-2" name="course_description" id="course_description" rows="10"
          placeholder="Course Description..."><?php echo htmlspecialchars($course['course_description'] ?? ''); ?></textarea>
          </div>

         
             <div class="row d-flex ">
              <div class="col-lg-3"></div>
                    <div class="col-lg-2">
                        <button class="button" type="submit" name="submit"  id="submit">Update</button>
                    </div>
                    <div class="col-lg-2"></div>
                        
                    <div class="col-lg-2">
                        <button href="courses_admin.php" class="button " type="reset" name="reset"  id="reset">Cancel</button>
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










