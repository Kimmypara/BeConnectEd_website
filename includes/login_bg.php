
<style>
<?php include 'css/style.css'; ?>
</style>

<?php
include 'users.php';
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

<style>


.login_bg {
  height: 100vh;
  width: 100%;
  background: url("assets/images/login_bg.png") no-repeat center center;
  background-size: cover;
  position: relative;
  background-repeat: no-repeat;
}

.login-form {
  position: absolute;
  bottom: 30%;
  left: 0;
  right: 3rem;
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 0 10%;
}


.form-logo {
  width: 10rem;
  margin-left: 20rem;
  
}
.form-title{
    width: 20rem;
}

.login-layout{
    margin: 10rem;
}

</style>

<div class="login_bg d-flex align-items-end">

  <div class="container login-layout pb-5">
    <div class="row align-items-center">

      <!-- LEFT COLUMN: LOGO -->
      <div class="col-lg-6 col-md-6 col-sm-12 text-center text-md-start mb-4 mb-md-0">
        <img src="assets/images/logo.png"
             alt="BeConnectEd logo"
             class="form-logo">
      </div>

      <!-- RIGHT COLUMN: PATH SELECTION -->
      <div class="col-lg-4 col-md-6 col-sm-12">
        <h3 class="form-title mb-3">Choose your Path</h3>

        <a href="login_institute.php" class="d-block button mb-2">
          Login with Institute
        </a>

        <a href="login_independent.php" class="d-block button">
          Login as Independent User
        </a>
      </div>

    </div>
  </div>

</div>

</body>


 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="includes/darkmode.js" type="text/javascript" defer></script>
