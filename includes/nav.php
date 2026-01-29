

<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$role_id = $_SESSION['role_id'] ?? null;

// Default page when open website
$homeUrl = 'login.php'; // fallback

switch ((int)$role_id) {
  case 1: $homeUrl = 'teacher_index.php'; break;
  case 2: $homeUrl = 'student_index.php'; break;
  case 3: $homeUrl = 'parent_index.php'; break;
  case 4: $homeUrl = 'admin_index.php'; break;

  case 5: $homeUrl = 'ind_teacher_index.php'; break;  // Independent teacher
  case 6: $homeUrl = 'ind_student_index.php'; break;  // Independent student

  default: $homeUrl = 'login.php'; break;
}




// Session data
$first_name = $_SESSION['first_name'] ?? '';
$last_name  = $_SESSION['last_name'] ?? '';
$role_id    = $_SESSION['role_id'] ?? null;
$profile_photo = $_SESSION['profile_photo'] ?? '';

require_once __DIR__ . '/arrays.php';
?>


<?php
include 'includes/users.php';

?>

<?php



$user_id = (int)($_SESSION['user_id'] ?? 0);
$user = null;

$photoPath = "assets/images/default_user.png"; 

if ($user_id > 0) {
  $user = getUserById($conn, $user_id);

  if (!empty($user['profile_photo'])) {
    $photoPath = "upload_images/" . $user['profile_photo'];
  }
}


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
<div class="container-fluid  px-3">
  <div class="row">
    
    <div class="col-lg-3 col-md-3 col-sm-12 ">
<a href="<?php echo $homeUrl; ?>" id="logo">
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

<?php
$first = $_SESSION['first_name'] ?? '';
$last  = $_SESSION['last_name'] ?? '';
echo '&nbsp;' . htmlspecialchars(trim($first . ' ' . $last));

    
     if (isset($message)) {
        echo ' — ' . htmlspecialchars($message[array_rand($message)]);
    }
    ?>





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


<!-- PROFILE pop-up -->
<div class="col-1">
  <div class="dropdown">
    <a href="#"
       class="dropdown-toggle d-flex align-items-center profile-toggle"
       id="profileDropdown"
       data-bs-toggle="dropdown"
       data-bs-auto-close="outside"
       aria-expanded="false"
       style="text-decoration:none;">

      <svg class="profile-icon "
           xmlns="http://www.w3.org/2000/svg"
           width="20" height="20"
           fill="var(--text-color)"
           viewBox="0 0 16 16">
        <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
        <path fill-rule="evenodd"
              d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1"/>
      </svg>
    </a>

    <?php
      $user_id = (int)($_SESSION['user_id'] ?? 0);
      $user = null;

      if ($user_id > 0) {
        $user = getUserById($conn, $user_id);
      }

      $photoPath = "assets/images/default_user.png";
      if (!empty($user['profile_photo'])) {
        $photoPath = "upload_images/" . $user['profile_photo'];
      }

     $roles = [
  1 => 'Teacher',
  2 => 'Student',
  3 => 'Parent',
  4 => 'Administrator',
  5 => 'Independent Teacher',
  6 => 'Independent Student'
];

    ?>

    <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="profileDropdown" style="width:16rem;">

      <li class="dropdown-header  d-flex align-items-start justify-content-between ">
        <div class="text-center w-100 pe-4">
          <strong>
            <?php echo htmlspecialchars($_SESSION['first_name'] ?? ''); ?>
            <?php echo ' ' . htmlspecialchars($_SESSION['last_name'] ?? ''); ?>
          </strong><br>
          <small><?php echo htmlspecialchars($roles[$_SESSION['role_id'] ?? 0] ?? ''); ?></small>
        </div>

        <button type="button" class="btn close1 ms-2" id="profileCloseBtn" aria-label="Close">
         <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
  <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"/>
</svg>
        </button>
      </li>


 <?php if (!empty($_SESSION['profile_error'])): ?>
  <div class="small text-danger mt-2">
    <?php echo htmlspecialchars($_SESSION['profile_error']); ?>
  </div>
  <?php unset($_SESSION['profile_error']); ?>
<?php endif; ?>

<?php if (!empty($_SESSION['profile_success'])): ?>
  <div class="small text-success mt-2">
    <?php echo htmlspecialchars($_SESSION['profile_success']); ?>
  </div>
  <?php unset($_SESSION['profile_success']); ?>
<?php endif; ?>


      <!-- CURRENT PHOTO OR PREVIEW -->
      <li class="px-3 py-2 text-center">
        <img
          id="profilePreviewImg"
          src="<?php echo htmlspecialchars($photoPath); ?>?v=<?php echo time(); ?>"
          alt="Profile photo"
          class="profile-img"
          style="width:8rem;height:8rem;object-fit:cover;border-radius:50%;"
        >
        <div class="small mt-2" id="uploadHint" style="display:none;">
          Selected. Click <strong>Save</strong> to confirm.
        </div>
      </li>

      <li><hr class="dropdown-divider "></li>

     
      
<li class="px-3 pb-2">
  <div class="d-flex justify-content-center gap-4 my-2 align-items-center">

    <!-- UPLOAD FORM  -->
    <form action="includes/upload_profile_photo.php"
          method="post"
          enctype="multipart/form-data"
          id="profileUploadForm"
          class="d-inline">

      <input type="hidden" name="redirect_to"
             value="<?php echo basename($_SERVER['PHP_SELF']); ?>">

      <input type="file"
             name="userFile"
             id="profileFile"
             class="d-none"
             accept=".jpg,.jpeg,.png,.webp">

      <!-- Upload icon button -->
      <button type="button"
              class="btn p-0 border-0 bg-transparent icons "
              id="uploadIconBtn"
              aria-label="Choose file">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
             class="bi bi-upload " viewBox="0 0 16 16">
          <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5"/>
          <path d="M7.646 1.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 2.707V11.5a.5.5 0 0 1-1 0V2.707L5.354 4.854a.5.5 0 1 1-.708-.708z"/>
        </svg><div class="icon_text">Upload Image</div>
      </button>
     
    </form>

    <!-- DELETE profile photo form  -->
    <form action="includes/delete_profile_photo.php" method="post"
          id="deletePhotoForm" class="d-inline">
          <input type="hidden" name="redirect_to"
          value="<?php echo basename($_SERVER['PHP_SELF']); ?>">

      <button type="submit"
              class="btn p-0 border-0 bg-transparent icons"
              id="profileTrashBtn"
              aria-label="Remove photo">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
             class="bi bi-trash" viewBox="0 0 16 16">
          <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
          <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
        </svg><div class="icon_text">Bin</div>
      </button>
    </form>

  </div>

  <!-- SAVE button  -->
  <button type="submit"
          form="profileUploadForm"
          name="uploadFile"
          value="upload"
          class="btn button w-100 mt-2"
          id="saveProfileBtn">
    Save
  </button>
</li>

      <li><hr class="dropdown-divider "></li>

     <?php
if(isset($_SESSION["user_id"])){?> 
<li class="nav-item">
  <a class="nav-link " href="includes/logout-inc.php">SignOut</a>
</li>
<?php } else {?>

  <li class="nav-item">
  <a class="nav-link " href="login.php">Login</a>

<?php } ?>


    </ul>
  </div>
</div>
  </div>
</div>

    </div>
</div>
      
  </div>
</div>

<!--image strip-->
<img class="strip" src="assets/images/strip.png" alt="">



  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="includes/darkmode.js" type="text/javascript" defer></script>


<script>
document.addEventListener('DOMContentLoaded', () => {
  const fileInput = document.getElementById('profileFile');
  const uploadBtn = document.getElementById('uploadIconBtn');
  const preview   = document.getElementById('profilePreviewImg');
  const hint      = document.getElementById('uploadHint');
  const form      = document.getElementById('profileUploadForm');
  const toggleEl  = document.getElementById('profileDropdown');
  const closeBtn  = document.getElementById('profileCloseBtn'); 
  const trashBtn  = document.getElementById('profileTrashBtn');


  const defaultImg = "assets/images/default_user.png";

  if (!form || !toggleEl) return;

  // Open file picker by clicking upload icon
  if (uploadBtn && fileInput) {
    uploadBtn.addEventListener('click', (e) => {
      e.preventDefault();
      e.stopPropagation();
      fileInput.click();
    });
  }

  // Preview chosen file (not uploaded yet)
  if (fileInput) {
    fileInput.addEventListener('change', () => {
      const file = fileInput.files?.[0];
      if (!file) return;

      if (preview) preview.src = URL.createObjectURL(file);
      if (hint) hint.style.display = 'block';
    });
  }

  // Save but if no file chosen, close dropdown and don't submit
  form.addEventListener('submit', (e) => {
    const hasFile = fileInput && fileInput.files && fileInput.files.length > 0;

    if (!hasFile) {
      e.preventDefault();
      bootstrap.Dropdown.getOrCreateInstance(toggleEl).hide();
    }
  });

  //  Close button 
  if (closeBtn) {
    closeBtn.addEventListener('click', (e) => {
      e.preventDefault();
      e.stopPropagation(); 
      bootstrap.Dropdown.getOrCreateInstance(toggleEl).hide();
    });
  }

  document.addEventListener('DOMContentLoaded', () => {
  const hasMsg = document.querySelector('.text-danger, .text-success');
  const toggleEl = document.getElementById('profileDropdown');

  if (hasMsg && toggleEl) {
    bootstrap.Dropdown.getOrCreateInstance(toggleEl).show();
  }
});

 //  Trash
trashBtn?.addEventListener('click', () => {
 
  preview.src = defaultImg + "?v=" + Date.now();
});

});
</script>





</body>



</html>


