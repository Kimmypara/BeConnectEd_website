<style>
<?php include 'css/style.css'; ?>
</style>



<!-- Hamburger button (small screens) -->
 <div class="row">
  <div class="col-sm-4">
<button class="btn btn-light d-md-none menu-btn" 
        type="button" 
        data-bs-toggle="offcanvas" 
        data-bs-target="#sidebarMenu">
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="20" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16">
        <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5"/>
    </svg>
</button>
</div>
</div>
<!--Detecting the current page-->
<?php $currentPage = basename($_SERVER['PHP_SELF']); ?>


<!-- Sidebar -->
<div class="offcanvas-md offcanvas-start sidebar col-lg-2" id="sidebarMenu">
    <div class="offcanvas-header d-md-none">
    </div>

<!--vertical nav -->
<div class="col">
    <div class="offcanvas-body">
        <ul class="nav flex-column">
           <li class="nav-item">
  <a class="nav-link <?php if ($currentPage == 'admin_index.php') echo 'active'; ?>" href="admin_index.php">
      Home
  </a>
</li>

<li class="nav-item">
  <a class="nav-link <?php if ($currentPage == 'plan_schedule_admin.php') echo 'active'; ?>" href="plan_schedule_admin.php">
      Plan & Schedule
  </a>
</li>

<li class="nav-item">
  <a class="nav-link <?php if ($currentPage == 'enrolment_admin.php') echo 'active'; ?>" href="enrolment_admin.php">
      Enrolment
  </a>
</li>

<li class="nav-item">
  <a class="nav-link <?php if ($currentPage == 'registration_admin.php') echo 'active'; ?>" href="registration_admin.php">
      Registration
  </a>
</li>

<li class="nav-item">
  <a class="nav-link <?php if ($currentPage == 'courses_admin.php') echo 'active'; ?>" href="courses_admin.php">
      Courses
  </a>
</li>

<li class="nav-item">
  <a class="nav-link <?php if ($currentPage == 'assign_teachers_admin.php') echo 'active'; ?>" href="assign_teachers_admin.php">
     Assign Teachers
  </a>
</li>

<li class="nav-item">
  <a class="nav-link <?php if ($currentPage == 'classes_admin.php') echo 'active'; ?>" href="classes_admin.php">
     Classes
  </a>
</li>

<li class="nav-item">
  <a class="nav-link <?php if ($currentPage == 'notifications_admin.php') echo 'active'; ?>" href="notifications_admin.php">
      Notifications
  </a>
</li>

<li class="nav-item">
  <a class="nav-link <?php if ($currentPage == 'chats_admin.php') echo 'active'; ?>" href="chats_admin.php">
      Chats
  </a>
</li>

        </ul>
    </div>
</div>
</div>