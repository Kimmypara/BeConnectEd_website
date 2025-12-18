<?php session_start(); ?>
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
              
              <!--close button -->
              <div class="row">
                <div class="col-11"><h2 class=" form_title">Register New Users</h2></div>
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
            <form action="includes/new_registration_admin_inc.php" method="post">

              <label class="formFields" for="role_id">User Role</label>
              <select class="placeholder_style mb-2" id="role_id" name="role_id" >
              <option class="input" value="" disabled selected>Please select role</option>
              <option class="input" value="1">Teacher</option>
              <option class="input" value="2">Student</option>
              <option class="input" value="3">Parent</option>
              <option class="input" value="4">Administrator</option>
             
            </select>

             <div class="row">
                    <div class="col">
                      <label class="formFields" for="first_name">First Name</label>
                        <input type="text" name="first_name" id="first_name" placeholder="first name" class="placeholder_style mb-2 ">
                    </div>
                </div>

                

                <div class="row">
                    <div class="col">
                      <label class="formFields" for="last_name">Last Name</label>
                        <input type="text" name="last_name" id="last_name" placeholder="last name" class="placeholder_style mb-2">
                    </div>
                </div>  

                <div class="row">
                    <div class="col">
                      <label class="formFields" for="email">E-mail</label>
                        <input type="email" name="email" id="email" placeholder="E-mail" class="placeholder_style mb-2">
                    </div>
                </div>  

                   <div class="row">
                    <div class="col">
                      <label class="formFields" for="date_of_birth">Date of Birth</label>
                        <input type="date" name="date_of_birth" id="date_of_birth" placeholder="date of birth" class="placeholder_style mb-2">
                    </div>
                </div> 



              <label class="formFields" for="must_change_password">User must change password on first login?</label>
              <select  class="placeholder_style mb-2" id="must_change_password" name="must_change_password" >
              <option class="input" value="" disabled selected>Change password on first login?</option>
              <option class="input" value="1">Yes</option>
              <option class="input" value="0">No</option>
              </select>


              
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

        <!--<div>
            <label class="formFields" for="qualifications">If teacher, insert Qualifications</label>
            <textarea  class="placeholder_style mb-2" name="qualifications" id="qualifications" placeholder="Teacher Qualifications..." 
              rows="10"></textarea>
          </div> -->

           

             <div class="row d-flex ">
              <div class="col-lg-3"></div>
                    <div class="col-lg-2">
                        <button class="button" type="submit" name="submit"  id="submit">Register</button>
                    </div>
                    <div class="col-lg-2"></div>
                        
                    <div class="col-lg-2">
                        <button href="registration_admin.php" class="button " type="reset" name="reset"  id="reset">Cancel</button>
                    </div>
                        <div class="col-lg-3"></div>
                </div>

            </form>
          </div>
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
?>

  <?php 
        if(isset($_GET["error"])) { 
            $error = "<h5>Could not register account:</h5><ul>";
            if (isset($_GET["emptyinput"])){
                $error = $error."<li>You have some empty fields.</li>";
            }
            if (isset($_GET["invalidFirst_name"])){
                $error = $error."<li>First name format invalid.</li>";
            }

             if (isset($_GET["invalidLast_name"])){
                $error = $error."<li>Lastt name format invalid.</li>";
            }
            if (isset($_GET["invalidEmail"])){
                $error = $error."<li>Email format invalid.</li>";
            }

             if (isset($_GET["emailExists"])){
                $error = $error."<li>Email already exist.</li>";
            }

              if (isset($_GET["invalidDate_of_birth"])){
                $error = $error."<li>Date of Birth format invalid.</li>";
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
                $message = "You have successfully registered a new account.";
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


    
 
               </div>
          </div>
          </div>
          </div>
      </div>
  </div>
</div>










