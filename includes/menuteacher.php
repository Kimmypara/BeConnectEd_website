<style>
<?php include 'css/style.css'; ?>
</style>



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
<div class="offcanvas-md offcanvas-start sidebar col-lg-2" id="sidebarMenu">
    <div class="offcanvas-header d-md-none">
    </div>

<!--vertical nav -->
<div class="col">
    <div class="offcanvas-body">
        <ul class="nav flex-column">
           <li class="nav-item">
  <a class="nav-link <?php if ($currentPage == 'teacher_index.php') echo 'active'; ?>" href="teacher_index.php">
      Home
  </a>
</li>

<li class="nav-item">
  <a class="nav-link <?php if ($currentPage == 'plan_schedule_teacher.php') echo 'active'; ?>" href="plan_schedule_teacher.php">
      Plan & Schedule
  </a>
</li>

<li class="nav-item">
  <a class="nav-link <?php if ($currentPage == 'enrolment_teacher.php') echo 'active'; ?>" href="enrolment_teacher.php">
      Enrolment
  </a>
</li>

<li class="nav-item">
  <a class="nav-link <?php if ($currentPage == 'teaching_units_teacher.php') echo 'active'; ?>" href="teaching_units_teacher.php">
      Teaching Units
  </a>
</li>



<li class="nav-item">
  <a class="nav-link <?php if ($currentPage == 'notifications_teacher.php') echo 'active'; ?>" href="notifications_teacher.php">
      Notifications
  </a>
</li>

<li class="nav-item">
  <a class="nav-link <?php if ($currentPage == 'chats_teacher.php') echo 'active'; ?>" href="chats_teacher.php">
      Chats
  </a>
</li>

        </ul>
    </div>
</div>
</div>