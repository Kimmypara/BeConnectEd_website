
<style>
<?php include 'css/style.css'; ?>
</style>

<?php

include 'includes/users.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nav</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:ital,wght@0,100..900;1,100..900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
 
</head>
<body>


<div class="login_bg d-flex align-items-center">

  <div class="container login-layout pb-5">
    <div class="row align-items-center">

      
      <div class="col-lg-6 col-sm-12 text-center mb-4">
          <img class="form-logo logo-img light"  src="assets/images/logo.png"  alt="be connected logo">
  <img class="form-logo logo-img dark" src="assets/images/logo-darkmode.png"  alt="be connected logo">
      </div>
<div class="col-md-1"></div>
      
      <div class="form-login col-lg-5 col-md-4 col-sm-12 ">
        <div class="row">

        <div class="col-12">
<h4 class="form-title mb-3">Create an Account</h4>

<form action="includes/new_registration_admin_inc.php" method="post">

 <!-- redirect targets -->
  <input type="hidden" name="success_to" value="../login_independent.php?success=registered">
  <input type="hidden" name="error_to" value="../create_account.php">
<input type="hidden" name="is_independent" value="1">
<input type="hidden" name="is_active" value="1">
<input type="hidden" name="institute_id" value="0">

  <!-- User Role -->
  <div class="row align-items-center mb-3">
    <div class="col-3">
      <label class="formFields2 mb-0" for="role_id">User Role</label>
    </div>
    <div class="col-9 d-flex justify-content-end">
      <select class="placeholder_style w-100" id="role_id" name="role_id" required>
        <option value="" disabled selected>Please select role</option>
        <option value="1">Teacher</option>
        <option value="2">Student</option>
      </select>
    </div>
  </div>

  <!-- First Name -->
  <div class="row align-items-center mb-3">
    <div class="col-3">
      <label class="formFields2 mb-0" for="first_name">First Name</label>
    </div>
    <div class="col-9 d-flex justify-content-end">
      <input type="text" name="first_name" id="first_name"
             placeholder="first name" class="placeholder_style w-100" required>
    </div>
  </div>

  <!-- Last Name -->
  <div class="row align-items-center mb-3">
    <div class="col-3">
      <label class="formFields2 mb-0" for="last_name">Last Name</label>
    </div>
    <div class="col-9 d-flex justify-content-end">
      <input type="text" name="last_name" id="last_name"
             placeholder="last name" class="placeholder_style w-100" required>
    </div>
  </div>

  <!-- E-mail -->
  <div class="row align-items-center mb-3">
    <div class="col-3">
      <label class="formFields2 mb-0" for="email">E-mail</label>
    </div>
    <div class="col-9 d-flex justify-content-end">
      <input type="email" name="email" id="email"
             placeholder="E-mail" class="placeholder_style w-100" required>
    </div>
  </div>

  <!-- Date of Birth -->
  <div class="row align-items-center mb-4">
    <div class="col-3">
      <label class="formFields2 mb-0" for="date_of_birth">Date of Birth</label>
    </div>
    <div class="col-9 d-flex justify-content-end">
      <input type="date" name="date_of_birth" id="date_of_birth"
             class="placeholder_style w-100" required>
    </div>
  </div>

  <!-- Buttons -->
  <div class="row">
    <div class="col-6 ">
      <button class="button btn" type="submit" name="submit" id="submit">Register</button>
    </div>

    <div class="col-6 ">
      
      <a href="login_independent.php" class="button btn" id="reset">Cancel</a>
    </div>
  </div>

  

</form>


        </div>
        </div>
        
      </div>

    </div>
  </div>

</div>

</body>


 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="includes/darkmode.js" type="text/javascript" defer></script>



