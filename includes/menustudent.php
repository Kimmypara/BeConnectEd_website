<?php
$student_id = $_SESSION['user_id'];

$sqlUnread = "
    SELECT COUNT(*) AS total_unread
    FROM file_notifications
    WHERE student_id = ? AND is_read = 0
";

$stmtUnread = mysqli_prepare($conn, $sqlUnread);
mysqli_stmt_bind_param($stmtUnread, "i", $student_id);
mysqli_stmt_execute($stmtUnread);
$resultUnread = mysqli_stmt_get_result($stmtUnread);
$rowUnread = mysqli_fetch_assoc($resultUnread);

$totalUnreadFiles = $rowUnread['total_unread'] ?? 0;
?>

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
<div class="offcanvas-md offcanvas-start sidebar" id="sidebarMenu">
    <div class="offcanvas-header d-md-none">
    </div>

<!--vertical nav -->
<div>
    <div class="offcanvas-body">
        <ul class="nav flex-column">
           <li class="nav-item">
  <a class="nav-link <?php if ($currentPage == 'student_index.php') echo 'active'; ?>" href="student_index.php">
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
    <span class="menu-badge-wrap">
      My Units

      <?php if ($totalUnreadFiles > 0): ?>
        <span class="notif-badge-menu"><?php echo $totalUnreadFiles; ?></span>
      <?php endif; ?>
    </span>
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
</div>