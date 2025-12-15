
<?php
session_start();
require_once "includes/dbh.php";
include 'includes/users.php';
?>


<style>
<?php include 'css/style.css'; ?>
</style>



<?php if (isset($error)): ?>
    <p style="color:red;"><?php echo $error; ?></p>
<?php endif; ?>

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


<form  method="POST">
<div class="login_bg d-flex ">

  <div class="container login-layout pb-5">
    <div class="row align-items-center">
 
      <!-- LEFT COLUMN: LOGO -->
      <div class="col-lg-6 col-md- col-sm-12 text-center text-md-start mb-4 mb-md-0">
        <img src="assets/images/logo.png"
             alt="BeConnectEd logo"
             class="form-logo">
      </div>

   
      <!-- RIGHT COLUMN: PATH SELECTION -->
      <div class="form-login col-lg-4 col-md-6 col-sm-12">
       <h4 class="form-title mb-3">Reset Password</h4>

      

        <input type="password" id="password" name="password" placeholder="password" class="d-block button3 " required>

        <input type="password" id="confirm_password" name="confirm_password" placeholder="confirm_password" class="d-block button3 " required>

        <div class="row">
        <div class="col">
            <button  type="submit" id="submit" name="submit" class="button loginbtn">Set Password</button>
        </div>
    </div>
      </div>
    </form>

</body>


 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="includes/darkmode.js" type="text/javascript" defer></script>


<?php


if (!isset($_GET['token'])) {
    die("Invalid password reset link.");
}

$token = $_GET['token'];



$sql = "SELECT * FROM reset_password WHERE reset_token = ? AND expires_at > NOW()";
$stmt = mysqli_stmt_init($conn);

if (!mysqli_stmt_prepare($stmt, $sql)) {
    die("Something went wrong.");
}

mysqli_stmt_bind_param($stmt, "s", $token);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$reset = mysqli_fetch_assoc($result);

if (!$reset) {
    die("This password reset link is invalid or has expired.");
}

$user_id = $reset['user_id'];
