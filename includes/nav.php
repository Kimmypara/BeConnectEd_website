<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


// Session data
$first_name = $_SESSION['first_name'] ?? '';
$last_name  = $_SESSION['last_name'] ?? '';
$role_id    = $_SESSION['role_id'] ?? null;

// Optional arrays (safe include)
require_once __DIR__ . '/arrays.php';
?>





<?php
include 'includes/users.php';
include 'includes/arrays.php'
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
 <link rel="stylesheet" href="css/style.css">
</head>
<body >
  

<!--logo-->
<div class="container-fluid mx-5 px-4">
  <div class="row">
    
    <div class="col-2 ">
<a href="index.php" id="logo">
  <img class="logo logo-img light"  src="assets/images/logo.png"  alt="be connected logo">
  <img class="logo logo-img dark" src="assets/images/logo-darkmode.png"  alt="be connected logo">
</a>

</div>

<!--welcome banner -->

<div class="banner col-lg-7 col-md-7 col-sm-12 text-center" id="banner">
<?php
$hour = date("H");
  $greeting =
    $hour < 12 ? 'Good Morning' :
    ($hour < 18 ? 'Good Afternoon' : 'Good Evening');
?>


<span class="greeting">
    <?php echo htmlspecialchars($greeting) . ' '; ?>



    <?php echo '&nbsp;'. htmlspecialchars($_SESSION['first_name'] . ' ' . $_SESSION['last_name']); ?>


<?php if (isset($message)): ?>
  
        <?php echo ' — ' . htmlspecialchars($message[array_rand($message)]); ?>
    </span>
<?php endif; ?>






      </div>   
      <!--dark /light mode -->
      <div class="col-1 " >
    <a href="" id="theme-switch" alt="dark mode button">
<svg alt="dark mode button" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="var(--text-color )" class="bi bi-moon-stars  icon dark-mode-icon " viewBox="0 0 16 16">
  <path d="M6 .278a.77.77 0 0 1 .08.858 7.2 7.2 0 0 0-.878 3.46c0 4.021 3.278 7.277 7.318 7.277q.792-.001 1.533-.16a.79.79 0 0 1 .81.316.73.73 0 0 1-.031.893A8.35 8.35 0 0 1 8.344 16C3.734 16 0 12.286 0 7.71 0 4.266 2.114 1.312 5.124.06A.75.75 0 0 1 6 .278M4.858 1.311A7.27 7.27 0 0 0 1.025 7.71c0 4.02 3.279 7.276 7.319 7.276a7.32 7.32 0 0 0 5.205-2.162q-.506.063-1.029.063c-4.61 0-8.343-3.714-8.343-8.29 0-1.167.242-2.278.681-3.286"/>
  <path d="M10.794 3.148a.217.217 0 0 1 .412 0l.387 1.162c.173.518.579.924 1.097 1.097l1.162.387a.217.217 0 0 1 0 .412l-1.162.387a1.73 1.73 0 0 0-1.097 1.097l-.387 1.162a.217.217 0 0 1-.412 0l-.387-1.162A1.73 1.73 0 0 0 9.31 6.593l-1.162-.387a.217.217 0 0 1 0-.412l1.162-.387a1.73 1.73 0 0 0 1.097-1.097zM13.863.099a.145.145 0 0 1 .274 0l.258.774c.115.346.386.617.732.732l.774.258a.145.145 0 0 1 0 .274l-.774.258a1.16 1.16 0 0 0-.732.732l-.258.774a.145.145 0 0 1-.274 0l-.258-.774a1.16 1.16 0 0 0-.732-.732l-.774-.258a.145.145 0 0 1 0-.274l.774-.258c.346-.115.617-.386.732-.732z"/>
</svg>
<svg alt="light mode button" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="var(--text-color )" class="bi bi-brightness-high  icon light-mode-icon" viewBox="0 0 16 16">
  <path d="M8 11a3 3 0 1 1 0-6 3 3 0 0 1 0 6m0 1a4 4 0 1 0 0-8 4 4 0 0 0 0 8M8 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 0m0 13a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 13m8-5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2a.5.5 0 0 1 .5.5M3 8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2A.5.5 0 0 1 3 8m10.657-5.657a.5.5 0 0 1 0 .707l-1.414 1.415a.5.5 0 1 1-.707-.708l1.414-1.414a.5.5 0 0 1 .707 0m-9.193 9.193a.5.5 0 0 1 0 .707L3.05 13.657a.5.5 0 0 1-.707-.707l1.414-1.414a.5.5 0 0 1 .707 0m9.193 2.121a.5.5 0 0 1-.707 0l-1.414-1.414a.5.5 0 0 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .707M4.464 4.465a.5.5 0 0 1-.707 0L2.343 3.05a.5.5 0 1 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .708"/>
</svg>

    </a>
</div>

    <!--profile icon-->
<div class="col-1 text-end">
    <div class="dropdown">

        <!-- PROFILE ICON (same SVG you already use) -->
        <a href="#"
           class="dropdown-toggle d-flex align-items-center"
           id="profileDropdown"
           data-bs-toggle="dropdown"
           aria-expanded="false"
           style="text-decoration:none;">

            <svg alt="profile icon"
                 xmlns="http://www.w3.org/2000/svg"
                 width="20"
                 height="20"
                 fill="var(--text-color)"
                 viewBox="0 0 16 16">
                <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
                <path fill-rule="evenodd"
                      d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1"/>
            </svg>
        </a>

        <!-- POPUP MENU -->
        <ul class="dropdown-menu dropdown-menu-end shadow"
            aria-labelledby="profileDropdown">

            <li class="dropdown-header">
                <strong>
                    <?php echo htmlspecialchars($_SESSION['first_name'] . ' ' . $_SESSION['last_name']); ?>
                </strong><br>
                <small class="">
                    <?php
                    $roles = [
                        1 => 'Teacher',
                        2 => 'Student',
                        3 => 'Parent',
                        4 => 'Administrator',
                        5 => 'Independent'
                    ];
                    echo $roles[$_SESSION['role_id']] ?? '';
                    ?>
                </small>
            </li>

                   <!--if user is logged in - show logout link-->
<?php
if(isset($_SESSION["user_id"])){?> 
<li class="nav-item">
  <a class="nav-link " href="includes/logout-inc.php">Logout</a>
</li>
<?php } else {?>
<!--if user is logged out - show loginlink-->
  <li class="nav-item">
  <a class="nav-link mt-1" href="login.php">Login</a>

<?php } ?>
            </li>

        </ul>
    </div>
</div>





      
  </div>
</div>

<!--image strip-->
<img class="strip" src="assets/images/strip.png" alt="">



  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="includes/darkmode.js" type="text/javascript" defer></script>
</body>



</html>