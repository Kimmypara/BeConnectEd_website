<?php
$student_id = (int)($_SESSION['user_id'] ?? 0);

$totalUnreadFiles = 0;
$totalUnreadAssignments = 0;

// FILE notifications
$sqlUnreadFiles = "
    SELECT COUNT(*) AS total_unread
    FROM file_notifications
    WHERE student_id = ? AND is_read = 0
";

$stmtUnreadFiles = mysqli_prepare($conn, $sqlUnreadFiles);
mysqli_stmt_bind_param($stmtUnreadFiles, "i", $student_id);
mysqli_stmt_execute($stmtUnreadFiles);
$resultUnreadFiles = mysqli_stmt_get_result($stmtUnreadFiles);
$rowUnreadFiles = mysqli_fetch_assoc($resultUnreadFiles);
$totalUnreadFiles = (int)($rowUnreadFiles['total_unread'] ?? 0);
mysqli_stmt_close($stmtUnreadFiles);


// ASSIGNMENT notifications
$totalUnreadAssignments = 0;

$sqlUnreadAssignments = "
    SELECT COUNT(*) AS total_unread
    FROM assignment_notifications
    WHERE student_id = ?
    AND is_read = 0
";

$stmtUnreadAssignments = mysqli_prepare($conn, $sqlUnreadAssignments);
mysqli_stmt_bind_param($stmtUnreadAssignments, "i", $student_id);
mysqli_stmt_execute($stmtUnreadAssignments);
$resultUnreadAssignments = mysqli_stmt_get_result($stmtUnreadAssignments);
$rowUnreadAssignments = mysqli_fetch_assoc($resultUnreadAssignments);

$totalUnreadAssignments = (int)($rowUnreadAssignments['total_unread'] ?? 0);

mysqli_stmt_close($stmtUnreadAssignments);

// GRADES notifications
$totalUnreadGrades = 0;

$sqlUnreadGrades = "
  SELECT COUNT(*) AS total_unread
  FROM grade_notifications
  WHERE student_id = ?
  AND is_read = 0
";

$stmtUnreadGrades = mysqli_prepare($conn, $sqlUnreadGrades);
mysqli_stmt_bind_param($stmtUnreadGrades, "i", $student_id);
mysqli_stmt_execute($stmtUnreadGrades);
$resultUnreadGrades = mysqli_stmt_get_result($stmtUnreadGrades);
$rowUnreadGrades = mysqli_fetch_assoc($resultUnreadGrades);

$totalUnreadGrades = (int)($rowUnreadGrades['total_unread'] ?? 0);

mysqli_stmt_close($stmtUnreadGrades);


// TOTAL for My Units menu
$totalUnreadAll = $totalUnreadFiles + $totalUnreadAssignments + $totalUnreadGrades;
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

      <?php if ($totalUnreadAll  > 0): ?>
        <span class="notif-badge-menu"><?php echo $totalUnreadAll; ?></span>
      <?php endif; ?>
    </span>
  </a>
</li>

<li class="nav-item">
  <a class="nav-link <?php if ($currentPage == 'grades.php') echo 'active'; ?>" href="grades.php">
  <span class="menu-badge-wrap">   
  Grades

      <?php if ($totalUnreadGrades  > 0): ?>
        <span class="notif-badge-menu"><?php echo $totalUnreadGrades; ?></span>
      <?php endif; ?>
      </span>
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