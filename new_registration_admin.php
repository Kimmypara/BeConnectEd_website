
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
     

      <div class="col-lg-9 col-md-8">
      <div class="row">  
        <div class="col-12">  
      <div class="form_bg">
              <h2 class=" form_title">Register New Users</h2>
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
              <option class="input" value="5">Independent Teacher</option>
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
        if(isset($_GET["error"])) { 
            $error = "";
            if ($_GET["error"] == "emptyinput"){
                $error = "You have some empty fields.";
            }
            ?>
            <div class="row">
                <div class="col"></div>
                <div class="col border border-danger text-danger">
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










