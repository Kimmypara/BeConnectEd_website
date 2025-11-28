
<style>
<?php include '/assets/css/style.css'; ?>
</style>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>

    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:ital,wght@0,100..900;1,100..900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
  
 

</head>
<body>
<style>

    body {
    margin: 0;
    padding: 0;
    height: 100vh;
    background: linear-gradient(to bottom, #babee0, #a9dadc, #ccebf3);
    background-attachment: fixed; /* keeps gradient still */
    font-family: Roboto, "Helvetica Neue", Helvetica, sans-serif;
}

.sidebar {
  background-color: #dcf1f8;
  border-radius: 1rem;
  width: auto;
  height: 100% ;
  margin: 7rem 1rem 7rem 1rem;
  box-shadow:0 8px 15px 0 #0000004d;
  position: fixed;
  overflow: auto;
  padding-top:2rem ;
  padding-left:1rem;
  padding-right: 1rem;
}

.nav-link{
  color: #23323d;
  font-size: .8rem;
  text-decoration: none ;
  font-weight: 550 ;
  padding-right: 2rem;
  padding-left: 2rem;
  justify-content: center;
}

.nav-link:hover{
  color: #1a5b71;
}

.nav-link:focus{
  color: #1a5b71;
box-shadow: 2px 1px 10px 0 #1a5b71;
    border-radius: .5rem;
    height:2rem ;
    width: auto;
}

.nav-link.active{
  color: #1a5b71;
    box-shadow: 2px 1px 10px 0 #1a5b71;
    border-radius: .5rem;
    height:2rem ;
    width: auto;
    margin-bottom: .3rem;
}

.offcanvas-md {
    background-color: #dcf1f8 !important;
    border-radius: 1rem;
}

/* Hamburger button */
.menu-btn {
    position: fixed;
    top: 1rem;
    left: 1rem;
    z-index: 1;
    background-color: #172c42;
    color: #ddf1f8; 
    box-shadow: 0 4px 8px #00000033;
    border-radius: .5rem;
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

.logo{
  transform: translateX(-33%);
  left: 33%;
}
}

.strip{
  width: 100%;
  margin-top : 6rem;
  position: fixed;
}

.logo{
  position: fixed;
  width: 7rem ;
  margin:1rem 1rem 0rem 4rem;
}

</style>

<a href="index.php">
  <img class="logo" src="assets/images/logo.png" alt="be connected logo">
</a>

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
</body>



</html>