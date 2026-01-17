<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

// Not logged in → go to login
if (empty($_SESSION['user_id'])) {
  header("Location: login.php?error=loginrequired");
  exit();
}
