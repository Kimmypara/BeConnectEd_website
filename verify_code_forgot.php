<?php

include 'includes/users.php';



$error = "";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Code</title>

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

                <h4 class="form-title mb-3">Enter Code</h4>

               

                <form method="POST" action="check_code_forgot.php">
                    <input type="hidden" name="login_type" value="independent">

    <input type="text" name="code" placeholder="Code" class="d-block button3" required>
    <p class="error-msg">Please enter the code sent to your e-mail</p>
    <?php
    if (isset($_GET["error"])) {
        
        echo "<h5 class='error-msg'>Could not proceed:</h5><ul>";
       

        if ($_GET["error"] === "emptyinput") {
            echo "<li class='error-msg'>You have some empty fields.</li>";
        }

        if ($_GET["error"] === "invalidcode") {
            echo "<li class='error-msg'>This code is invalid.</li>";
        }

        if ($_GET["error"] === "stmtfailed") {
            echo "<li class='error-msg'>Server error. Please try again.</li>";
        }

        echo "</ul>";
        
    }
    ?>

    <button type="submit" name="submit" class="button loginbtn">Verify Code</button>

</form>

            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="includes/darkmode.js" defer></script>

</body>
</html>
