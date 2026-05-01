<?php
if (session_status() === PHP_SESSION_NONE) session_start();

  // include this in your html before the <html> tag
    header("Cache-Control: no-cache, must-revalidate"); // does not store the page in cache
    header("Expires: 01 Jan 1970 00:00"); // Date in the past to cancel cache
?>
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
          <?php include 'includes/menustudent.php'; ?>
      </div>
     

   <div class="col-1"></div>
  <div class="col-lg-9 col-md-8">
      <div class="row">  
        <div class="col-12">  
            <div class="form_bg">
              <h2 class=" form_title">Register New Users</h2>

            </div>
         </div>
      </div>
   </div>





</div>
</div>

<script>
window.addEventListener("pageshow", function(event) {
  if (event.persisted || performance.getEntriesByType("navigation")[0].type === "back_forward") {
    window.location.reload();
  }
});
</script>