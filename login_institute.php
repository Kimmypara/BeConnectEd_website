
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

<form action="/BeConnectEd_website/includes/login_inc.php" method="POST">
<div class="login_bg d-flex align-items-center">

  <div class="container ">
    <div class="row align-items-center">
 
      <!-- LEFT COLUMN: LOGO -->
      <div class="col-lg-6 text-center mb-4 ">
             
  <img class="form-logo logo-img light"  src="assets/images/logo.png"  alt="be connected logo">
  <img class="form-logo logo-img dark" src="assets/images/logo-darkmode.png"  alt="be connected logo">

      </div>
<div class="col-md-1"></div>
   
      <!-- RIGHT COLUMN: PATH SELECTION -->
      <div class="form-login col-lg-4 col-md-5 col-sm-12 ">
       
       <input type="email" id="email" name="email" class="d-block  button3" placeholder="email" required>
   

        <input type="password" id="password" name="password" placeholder="password" class="d-block button3" required>

 <?php
if (isset($_GET["error"])) {

  $error = "<h5>Could not log in:</h5><ul>";

  if ($_GET["error"] === "emptyinput") {
    $error .= "<li>You have some empty fields.</li>";
  }

  if ($_GET["error"] === "emailnotfound") {
    $error .= "<li>This email is not registered.</li>";
  }

  if ($_GET["error"] === "wrongpassword") {
    $error .= "<li>Incorrect password.</li>";
  }

  if ($_GET["error"] === "inactive") {
    $error .= "<li>Your account is inactive. Please contact the administrator.</li>";
  }

  if ($_GET["error"] === "mustchangepassword") {
    $error .= "<li>This is your first login. Please set your password.</li>";
  }

  if ($_GET["error"] === "invalidrole") {
    $error .= "<li>Your account role is invalid. Please contact support.</li>";
  }

  if ($_GET["error"] === "stmtfailed") {
    $error .= "<li>Server error. Please try again.</li>";
  }

  $error .= "</ul>";

  echo $error;
}
?>

              <p class="mt-3 formFields">
    New user?
    <a class="formFields2" href="reset_password.php">Click here to set your password</a>
</p>
        <div class="row">
        <div class="col">
            <button  type="submit" id="submit" name="submit" class="button loginbtn">Login</button>
        </div>
    </div>
      </div>
    </form>
    </div>
  </div>

</div>

</body>


 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="includes/darkmode.js" type="text/javascript" defer></script>







