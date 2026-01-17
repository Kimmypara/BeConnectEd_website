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
  <div class="col-lg-9 col-md-8">
      <div class="row">  
        <div class="col-12">  
            <div class="form_bg">
              
              <!--close button -->
              <div class="row">
                <div class="col-10"><h2 class=" form_title">Add a Course</h2></div>
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
            <form action="includes/courses_inc.php" method="post">

            
             <div class="row">
                    <div class="col">
                      <label class="formFields" for="course_name">Course Name</label>
                        <input type="text" name="course_name" id="course_name" placeholder="course name" class="placeholder_style mb-2 ">
                    </div>
                </div>

                

                <div class="row">
                    <div class="col">
                      <label class="formFields" for="course_code">Course Code</label>
                        <input type="text" name="course_code" id="course_code" placeholder="Course Code" class="placeholder_style mb-2">
                    </div>
                </div>  

                <div class="row">
                    <div class="col">
                      <label class="formFields" for="MQF_Level">MQF Level</label>
                        <input type="text" name="MQF_Level" id="MQF_Level" placeholder="MQF level" class="placeholder_style mb-2">
                    </div>
                </div>  

                   <div class="row">
                    <div class="col">
                      <label class="formFields" for="credits">Credits</label>
                        <input type="text" name="credits" id="credits" placeholder="credits" class="placeholder_style mb-2">
                    </div>
                </div> 

                 <div class="row">
                    <div class="col">
                      <label class="formFields" for="duration">Duration</label>
                        <input type="text" name="duration" id="duration" placeholder="duration" class="placeholder_style mb-2">
                    </div>
                </div> 

               
              
              <label class="formFields" for="is_active">Active or Inactive?</label>
              <select  class="placeholder_style mb-2" id="is_active" name="is_active" >
              <option class="input" value="" disabled selected>Choose if user is Active or Inactive</option>
              <option class="input" value="1">Active</option>
              <option class="input" value="0">Inactive</option>
              </select>

               
              <label class="formFields" for="institute_id">Institute</label>
              <select  class="placeholder_style mb-2" id="institute_id" name="institute_id" >
              <option class="input" value="" disabled selected>Choose an Institute</option>
              <option class="input" value="1">MCAST Institute for the Creative Arts</option>
              <option class="input" value="2">MCAST Institute of Applied Sciences</option>
              <option class="input" value="3">University of Malta</option>
              <option class="input" value="4">St. Benedict College</option>
              </select>

        <div>
            <label class="formFields" for="course_description">Course Description</label>
            <textarea  class="placeholder_style mb-2" name="course_description" id="course_description" placeholder="Course Description..." 
              rows="10"></textarea>
          </div>

   <?php        
if (isset($_SESSION['reset_link'])) {
    echo "<div class='alert alert-info'>
            <strong>Reset link (dev only):</strong><br>
            <a href='{$_SESSION['reset_link']}' target='_blank'>
                {$_SESSION['reset_link']}
            </a>
          </div>";
    unset($_SESSION['reset_link']); // show once
}


   
        if(isset($_GET["error"])) { 
            $error = "<h5>Could not Save course:</h5><ul>";
            if (isset($_GET["emptyinput"])){
                $error = $error."<ol>You have some empty fields.</ol>";
            }
            if (isset($_GET["invalidCourse_name"])){
                $error = $error."<ol>Course name format invalid.</ol>";
            }

             if (isset($_GET["invalidCourse_code"])){
                $error = $error."<ol>Course code format invalid.</ol>";
            }
            if (isset($_GET["courseCodeExists"])) {
             $error .= "<ol>Course code already exists.</ol>";
            }

            if (isset($_GET["invalidMQF_Level"])){
                $error = $error."<ol>MQF Level format invalid.</ol>";
            }
            if (isset($_GET["invalidCredits"])){
                $error = $error."<ol>Credits format invalid.</ol>";
            }
            if (isset($_GET["invalidDuration"])){
                $error = $error."<ol>Duration format invalid.</ol>";
            }
           
            
            $error= $error."</ul>";
            ?>
            <div class="row">
                <div class="col"></div>
                <div class="col-6 border border-danger text-danger rounded">
                    <p><?php echo $error; ?></p>
                </div>
                <div class="col"></div>
            </div>
    <?php } ?>


    <?php 
        if(isset($_GET["success"])) { 
            $message = "";
            if ($_GET["success"] == "true"){
                $message = "You have successfully added a new course.";
            }
            ?>
            <div class="row">
                <div class="col"></div>
                <div class="col border border-success text-success">
                    <p><?php echo $message; ?></p>
                </div>
                <div class="col"></div>
            </div>
    <?php } ?>

             <div class="row d-flex ">
              <div class="col-lg-3"></div>
                    <div class="col-lg-2">
                        <button class="button" type="submit" name="submit"  id="submit">Save</button>
                    </div>
                    <div class="col-lg-2"></div>
                        
                    <div class="col-lg-2">
                        <button href="add_course.php" class="button " type="reset" name="reset"  id="reset">Cancel</button>
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










