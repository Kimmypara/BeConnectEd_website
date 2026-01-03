<?php session_start(); ?>
<?php
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
                <div class="col-11"><h2 class=" form_title">Add a Unit</h2></div>
                <div class="col-1">
                <a href="courses_admin.php" class="button mt-0" alt="close button"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
  <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"/>
</svg></a>
</div>
</div>
             


              <!-- Your form -->
      <div class="row">
 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
          <div>
            <form action="includes/units_inc.php" method="post">

            
             <div class="row">
                    <div class="col">
                      <label class="formFields" for="unit_name">Unit Name</label>
                        <input type="text" name="unit_name" id="unit_name" placeholder="unit name" class="placeholder_style mb-2 ">
                    </div>
                </div>

                

                <div class="row">
                    <div class="col">
                      <label class="formFields" for="unit_code">Unit Code</label>
                        <input type="text" name="unit_code" id="unit_code" placeholder="unit code" class="placeholder_style mb-2">
                    </div>
                </div>  

                <div class="row">
                    <div class="col">
                      <label class="formFields" for="ects_credits">ECTS Credits</label>
                        <input type="text" name="ects_credits" id="ects_credits" placeholder="ECTS credits " class="placeholder_style mb-2">
                    </div>
                </div>  


                 <div class="row">
                    <div class="col">
                      <label class="formFields" for="unit_duration"> Unit Duration</label>
                        <input type="text" name="unit_duration" id="unit_duration" placeholder="unit duration" class="placeholder_style mb-2">
                    </div>
                </div> 

               
              
              <label class="formFields" for="is_active">Active or Inactive?</label>
              <select  class="placeholder_style mb-2" id="is_active" name="is_active" >
              <option class="input" value="" disabled selected>Choose if user is Active or Inactive</option>
              <option class="input" value="1">Active</option>
              <option class="input" value="0">Inactive</option>
              </select>


        <div>
            <label class="formFields" for="unit_description">Unit Description</label>
            <textarea  class="placeholder_style mb-2" name="unit_description" id="unit_description" placeholder="Unit Description..." 
              rows="10"></textarea>
          </div>

           

             <div class="row d-flex ">
              <div class="col-lg-3"></div>
                    <div class="col-lg-2">
                        <button class="button" type="submit" name="submit"  id="submit">Save</button>
                    </div>
                    <div class="col-lg-2"></div>
                        
                    <div class="col-lg-2">
                        <button href="add_unit.php" class="button " type="reset" name="reset"  id="reset">Cancel</button>
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
            $error = "<h5>Could not Save unit:</h5><ul>";
            if (isset($_GET["emptyinput"])){
                $error = $error."<ol>You have some empty fields.</ol>";
            }
            if (isset($_GET["invalidUnit_name"])){
                $error = $error."<ol>Unit name format invalid.</ol>";
            }

             if (isset($_GET["invalidUnit_code"])){
                $error = $error."<ol>Unit code format invalid.</ol>";
            }
            if (isset($_GET["unitCodeExists"])) {
             $error .= "<ol>Unit code already exists.</ol>";
            }

            if (isset($_GET["invalidEcts_credits"])){
                $error = $error."<ol>ECTS Credits format invalid.</ol>";
            }
            if (isset($_GET["invalidUnit_duration"])){
                $error = $error."<ol>Unit Duration format invalid.</ol>";
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
                $message = "You have successfully added a new unit.";
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










