
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
            <label class="formFields" for="user_role">User Role</label>
            <select class="input user_role" id="user_role" name="user_role">
              <option value="" disabled selected>Please select role</option>
              <option value="teacher">Teacher</option>
              <option value="student">Student</option>
              <option value="parent">Parent</option>
              <option value="administrator">Administrator</option>
            </select>
          </div>
        </div>


               </div>
          </div>

          
          </div>
          </div>


          
      </div>





  </div>
</div>







