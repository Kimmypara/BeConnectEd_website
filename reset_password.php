<?php

include 'includes/users.php';



$error = "";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>

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

                <h4 class="form-title mb-3">Set Your Password</h4>

               

                <form method="POST" action="/BeConnectEd_website/includes/reset_password_inc.php">

                    <input type="email" name="email"
                           placeholder="Email address" class="d-block button3" required>

                    <input type="password" name="password"
                           placeholder="New password" class="d-block button3" required>

                    <input type="password" name="confirm_password"
                           placeholder="Confirm password" class="d-block button3" required>

                            <?php
if (isset($_GET["error"])) {


  if ($_GET["error"] === "emptyinput") {
    $error .= "<li>You have some empty fields.</li>";
  }

  if ($_GET["error"] === "emailnotfound") {
    $error .= "<li>This email is not registered.</li>";
  }

  if ($_GET["error"] === "passwordmismatch") {
    $error .= "<li>Password does not match.</li>";
  }
  if ($_GET["error"] === "noactiveaccount") {
    $error .= "<li>Your account is not active. Please contact the administrator</li>";
  }
    if ($_GET["error"] === "stmtfailed") {
    $error .= "<li>Server error. Please try again.</li>";
  }

  $error .= "</ul>";

  echo $error;
}
?>

                    <button type="submit"
                            name="submit"
                            class="button loginbtn ">
                        Set Password
                    </button>

                </form>

            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="includes/darkmode.js" defer></script>

</body>
</html>
