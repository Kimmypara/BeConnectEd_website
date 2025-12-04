
<style>
<?php include '/assets/css/style.css'; ?>
</style>
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
  
</head>
<body >
<style>

 :root{
    --base-color: linear-gradient(to bottom, #babee0, #a9dadc, #ccebf3);
    --base-variant: #dcf1f8;
    --text-color: #23323d;
    --secondary-text: #1a5b71;
    --button-color: #172c42;
    --hover-button:  #1a5b71;
  }

  .darkmode {
    --base-color: linear-gradient(to bottom, #1a5b71, #172c42);
    --base-variant: #1b3e53 ;
    --text-color: #ddf1f8;
    --secondary-text: #6cb6b7;
    --button-color: #ddf1f8;
    --hover-button:  #6cb6b7;
  }

.logo {
    cursor: pointer;
    border-radius: .5rem;
    transition: box-shadow 0.2s ease;
    width: 7rem ;
}

.logo:hover,
.logo:focus {
    box-shadow: 0 0 10px var(--secondary-text);
    border-radius: .5rem;
    outline: none;
}


  #logo{
    display: flex;
    position: fixed;
    cursor: pointer;
  }


#logo img.active{
  color: var(--secondary-text);
    box-shadow: 2px 1px 10px 0 #1a5b71;
    border-radius: .5rem;
}

#logo:focus {
    outline: none;
    box-shadow: 0 0 10px var(--secondary-text);
    border-radius: .5rem;
    display: inline-block;
}

.logo-img.dark { display: none; }

.darkmode .logo-img.light { display: none; }
.darkmode .logo-img.dark { display: block; }


#theme-switch svg {
    color: var(--button-color);
    cursor: pointer;
    transition: box-shadow 0.2s ease, color 0.2s ease;
}

#theme-switch svg:hover,
#theme-switch svg:focus {
    box-shadow: 0 0 10px var(--secondary-text);
    border-radius: .5rem;
    outline: none;
}

#theme-switch:focus {
    outline: none;
    box-shadow: 0 0 10px var(--secondary-text);
    border-radius: .5rem;
    display: inline-block;
}

  #theme-switch svg{
  color: var(--button-color );
}


.light-mode-icon { display: none; }

.darkmode .dark-mode-icon { display: none; }
.darkmode .light-mode-icon { display: block; }


.col-1{
  margin-top: 2.5rem;
}

    body {
    margin-top:2rem;
    padding: 0;
    height: 100vh;
    background: var(--base-color);
    background-attachment: fixed; /* keeps gradient still */
    font-family: Roboto, "Helvetica Neue", Helvetica, sans-serif;
}

.sidebar {
  background-color: var(--base-variant);
  border-radius: 1rem;
  width: auto;
  height: 100% ;
  margin: 1rem 1rem 1rem 1rem;
  box-shadow:0 8px 15px 0 #0000004d;
  position: fixed;
  overflow: auto;
  padding-top:2rem ;
  padding-left:1rem;
  padding-right: 1rem;
  z-index:  3;
}

.nav-link{
  color: var(--text-color);
  font-size: .8rem;
  text-decoration: none ;
  font-weight: 550 ;
  padding-right: 2rem;
  padding-left: 2rem;
  justify-content: center;
}

.nav-link:hover{
  box-shadow: 0 0 10px var(--secondary-text);
  color: var(--secondary-text);
  border-radius: .5rem;
}

.nav-link:focus{
  box-shadow: 0 0 10px var(--secondary-text);
   color: var(--secondary-text);
  box-shadow: 2px 1px 10px 0 #1a5b71;
    border-radius: .5rem;
    height:2rem ;
    width: auto;
}

.nav-link.active{
   color: var(--secondary-text);
   box-shadow: 0 0 10px var(--secondary-text);
    border-radius: .5rem;
    height:2rem ;
    width: auto;
    margin-bottom: .3rem;
}

.offcanvas-md {
    background-color:var(--base-variant) !important;
    border-radius: 1rem;
}

/* Hamburger button */
.menu-btn {
    position: fixed;
    top: 1rem;
    left: 1rem;
    z-index: 1;
    background-color: var(--button-color);
    color: #ddf1f8; 
    box-shadow: 0 4px 8px #0000004d;
    border-radius: .5rem;
}



.strip{
  width: 100%;
  position: fixed;
}


.banner{
  display: flex;
  color: var(--text-color);
  font-size :1.2rem;
  font-weight: 600;
  margin-top: 2.5rem ;
}



/* small screens */
@media (max-width: 767px) {
    .sidebar {
        margin: 1rem 1rem 1rem 0rem;
        height: 100%;
        border-radius: 1rem;
        box-shadow:0 8px 15px 0 #0000004d;
        position: fixed;
        overflow: auto;
        padding-top:2rem ;
        padding-left:.5rem;
        padding-right: .5rem;
    }

    #sidebarMenu{
  width: 70% ;
}

.menu-btn {
    top: 7rem;
    left:3rem;
}

.logo{
  position: fixed;
  width: 7rem ;
  margin:2rem 0rem 0rem 0rem;
   transform: translateX(-50%);
  left: 50%;
}

.banner{
  display: flex;
  font-size :1.2rem;
  font-weight: 600;
  margin-top: 10rem ;
  width: 90%;
  
}

}

</style>
<!--logo-->
<div class="container-fluid mx-4 px-4">
  <div class="row">
    
    <div class="col-2 ">
<a href="index.php" id="logo">
  <img class="logo logo-img light"  src="assets/images/logo.png"  alt="be connected logo">
  <img class="logo logo-img dark" src="assets/images/logo-darkmode.png"  alt="be connected logo">
</a>

</div>

<!--welcome banner -->

<div class="banner col-8 text-center">
<?php
        echo "<div class='col'>";
        date("H:i:s");
        $time = date("H");
        if($time < "12"){
            echo "Good Morning ";
        }
        elseif($time < "18"){
            echo "Good Afternoon  ";
        }
        else{
            echo "Good Evening ";
        }
        echo " &nbsp;{$first_name} {$last_name},&nbsp";
         echo $message[$random_keys[0]];
        echo "</div>";
       
        ?>

      </div>   
      <!--dark /light mode -->
      <div class="col-1 " >
    <a href="" id="theme-switch">
<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="var(--text-color )" class="bi bi-moon-stars  icon dark-mode-icon" viewBox="0 0 16 16">
  <path d="M6 .278a.77.77 0 0 1 .08.858 7.2 7.2 0 0 0-.878 3.46c0 4.021 3.278 7.277 7.318 7.277q.792-.001 1.533-.16a.79.79 0 0 1 .81.316.73.73 0 0 1-.031.893A8.35 8.35 0 0 1 8.344 16C3.734 16 0 12.286 0 7.71 0 4.266 2.114 1.312 5.124.06A.75.75 0 0 1 6 .278M4.858 1.311A7.27 7.27 0 0 0 1.025 7.71c0 4.02 3.279 7.276 7.319 7.276a7.32 7.32 0 0 0 5.205-2.162q-.506.063-1.029.063c-4.61 0-8.343-3.714-8.343-8.29 0-1.167.242-2.278.681-3.286"/>
  <path d="M10.794 3.148a.217.217 0 0 1 .412 0l.387 1.162c.173.518.579.924 1.097 1.097l1.162.387a.217.217 0 0 1 0 .412l-1.162.387a1.73 1.73 0 0 0-1.097 1.097l-.387 1.162a.217.217 0 0 1-.412 0l-.387-1.162A1.73 1.73 0 0 0 9.31 6.593l-1.162-.387a.217.217 0 0 1 0-.412l1.162-.387a1.73 1.73 0 0 0 1.097-1.097zM13.863.099a.145.145 0 0 1 .274 0l.258.774c.115.346.386.617.732.732l.774.258a.145.145 0 0 1 0 .274l-.774.258a1.16 1.16 0 0 0-.732.732l-.258.774a.145.145 0 0 1-.274 0l-.258-.774a1.16 1.16 0 0 0-.732-.732l-.774-.258a.145.145 0 0 1 0-.274l.774-.258c.346-.115.617-.386.732-.732z"/>
</svg>
<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="var(--text-color )" class="bi bi-brightness-high  icon light-mode-icon" viewBox="0 0 16 16">
  <path d="M8 11a3 3 0 1 1 0-6 3 3 0 0 1 0 6m0 1a4 4 0 1 0 0-8 4 4 0 0 0 0 8M8 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 0m0 13a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 13m8-5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2a.5.5 0 0 1 .5.5M3 8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2A.5.5 0 0 1 3 8m10.657-5.657a.5.5 0 0 1 0 .707l-1.414 1.415a.5.5 0 1 1-.707-.708l1.414-1.414a.5.5 0 0 1 .707 0m-9.193 9.193a.5.5 0 0 1 0 .707L3.05 13.657a.5.5 0 0 1-.707-.707l1.414-1.414a.5.5 0 0 1 .707 0m9.193 2.121a.5.5 0 0 1-.707 0l-1.414-1.414a.5.5 0 0 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .707M4.464 4.465a.5.5 0 0 1-.707 0L2.343 3.05a.5.5 0 1 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .708"/>
</svg>

    </a>
      </div>
  </div>
</div>

<!--image strip-->
<img class="strip" src="assets/images/strip.png" alt="">

  
  
  <!-- Hamburger button (small screens) -->
<button class="btn btn-light d-md-none menu-btn" 
        type="button" 
        data-bs-toggle="offcanvas" 
        data-bs-target="#sidebarMenu">
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="20" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16">
        <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5"/>
    </svg>
</button>

<!--Detecting the current page-->
<?php $currentPage = basename($_SERVER['PHP_SELF']); ?>


<!-- Sidebar -->
<div class="offcanvas-md offcanvas-start sidebar" id="sidebarMenu">
    <div class="offcanvas-header d-md-none">
    </div>

<!--vertical nav -->
<div>
    <div class="offcanvas-body">
        <ul class="nav flex-column">
           <li class="nav-item">
  <a class="nav-link <?php if ($currentPage == 'index.php') echo 'active'; ?>" href="index.php">
      Home
  </a>
</li>

<li class="nav-item">
  <a class="nav-link <?php if ($currentPage == 'plan_schedule.php') echo 'active'; ?>" href="plan_schedule.php">
      Plan & Schedule
  </a>
</li>

<li class="nav-item">
  <a class="nav-link <?php if ($currentPage == 'enrolment.php') echo 'active'; ?>" href="enrolment.php">
      Enrolment
  </a>
</li>

<li class="nav-item">
  <a class="nav-link <?php if ($currentPage == 'my_units.php') echo 'active'; ?>" href="my_units.php">
      My Units
  </a>
</li>

<li class="nav-item">
  <a class="nav-link <?php if ($currentPage == 'grades.php') echo 'active'; ?>" href="grades.php">
      Grades
  </a>
</li>

<li class="nav-item">
  <a class="nav-link <?php if ($currentPage == 'notifications.php') echo 'active'; ?>" href="notifications.php">
      Notifications
  </a>
</li>

<li class="nav-item">
  <a class="nav-link <?php if ($currentPage == 'chats.php') echo 'active'; ?>" href="chats.php">
      Chats
  </a>
</li>

        </ul>
    </div>
</div>


  
  
  
  


  

  
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="../Bootstrap/bootstrap.bundle.min.js">
  </script>

<script src="../Bootstrap/script.js"></script>
<script src="includes/darkmode.js" type="text/javascript" defer></script>
</body>



</html>