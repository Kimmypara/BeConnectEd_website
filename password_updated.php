<?php

include 'includes/users.php';



$error = "";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">

    <style>
        <?php include 'css/style.css'; ?>
    </style>
</head>

<body class="m-0">

<div class="login_bg d-flex align-items-center">
    <div class="container ">
        <div class="row align-items-center">

            <!--  LOGO -->
            <div class="col-lg-6 text-center mb-4 ">
                  <img class="form-logo logo-img light"  src="assets/images/logo.png"  alt="be connected logo">
  <img class="form-logo logo-img dark" src="assets/images/logo-darkmode.png"  alt="be connected logo">
            </div>

            <!--  FORM -->
            <div class="form-login col-lg-4 col-md-4 col-sm-12">

                <h4 class="form-title mb-3">Password Updated</h4>

                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="check bi bi-check2" viewBox="0 0 16 16">
  <path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0"/>
</svg>

            <p class='error-msg'>Your password has been successfully updated</p>



    <a href="login_independent.php" class="button loginbtn">Login</a>



            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="includes/darkmode.js" defer></script>

</body>
</html>
