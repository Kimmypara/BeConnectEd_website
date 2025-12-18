
<?php
session_start();
include "includes/nav.php";
include 'includes/conditions.php';
require_once 'includes/users.php'
?>


<style>
<?php include 'css/style.css'; ?>
</style>



<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>


<div class="container-fluid">
  <div class="row">

      <div class="col-lg-2 col-md-3 p-0">
          <?php include 'includes/menuadmin.php'; ?>
      </div>
     

    <div class="col-1"></div>
  <div class="col-lg-9 col-md-8">
      <div class="row">  
        <div class="col-12">  
            <div class="form_bg">
            <div class="row align-items-center">

                <!-- SEARCH BAR -->
                <div class="col-lg-5 col-md-6 col-sm-4">
                    <form class="d-flex">
                       
                        <button class="search_button btn-outline-success my-3" type="submit">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                            </svg>
                        </button>
                         <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    </form>
                </div>
                <div class="col-lg-4 col-md-2 col-sm-4 text-end">
                    
                </div>

                <!-- REGISTER BUTTON -->
                <div class="col-lg-3 col-md-4 col-sm-4 text-end">
                    <a href="new_registration_admin.php" class="button">New Registration</a>
                </div>

      <!--Table -->  
<div class="col-lg-11 col-md-11 col-sm-11">
<table class="table_admin"  >
  <tr>
    <th>User Role</th>
    <th>First Name</th>
    <th>Last Name</th>
    <th>Email</th>
    <th>Status</th>
     <th></th>
      <th></th>
  </tr>

  <?php
  $result = getUsers($conn);
  while($row = mysqli_fetch_assoc($result)){
  echo '<tr>';
echo '<td>' . ($row['role_name']) . '</td>';
echo '<td>' .($row['first_name']) . '</td>';
echo '<td>' . ($row['last_name']) . '</td>';
echo '<td>' . ($row['email']) . '</td>';
echo '<td>' . ($row['is_active'] ? 'Active' : 'Inactive') . '</td>';
 
echo '<td class="text-center">';

if ($row['is_active']) {
    // Deregister button
    echo '
    <button type="button" class="button4" data-bs-toggle="modal" data-bs-target="#confirmModal"
        data-user-id="' . $row['user_id'] . '"
        data-action="inactivate">
        Deregister
    </button>';
} else {
    // Register button
    echo '
    <button type="button" class="button4" data-bs-toggle="modal" data-bs-target="#confirmModal"
        data-user-id="' . $row['user_id'] . '"
        data-action="activate">
        Register
    </button>';
}
}

echo '</td>';

//echo '<td class="text-center">
      //  <a href="new_registration_admin.php?user_id=' . $row['user_id'] . '"
         //  class="button_table">View / Edit</a>
      //</td>';

echo '</tr>';


  ?>
                    </table>
                </div>

            </div>
        </div>

    </div>
</div>

        
</div>
</div>
<div class="modal fade " id="confirmModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog  modal-dialog-centered">
    <div class="modal-content form_bg3">

      <div class="modal-header">
        <h5 class="modal-title">Confirm action</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body" id="confirmMessage">
        Are you sure you want to continue?
      </div>

      <div class="modal-footer">
        <button type="button" class="btn button5" data-bs-dismiss="modal">
          Cancel
        </button>

        <a href="#" id="confirmActionBtn" class="btn btn-danger">
          Confirm
        </a>
      </div>

    </div>
  </div>
</div>


<script>
const confirmModal = document.getElementById('confirmModal');

confirmModal.addEventListener('show.bs.modal', function (event) {
  const button = event.relatedTarget;

  const userId = button.getAttribute('data-user-id');
  const action = button.getAttribute('data-action');

  const confirmBtn = document.getElementById('confirmActionBtn');
  const message = document.getElementById('confirmMessage');

  if (action === 'activate') {
    message.textContent = 'Are you sure you want to register this user?';
    confirmBtn.className = 'btn btn-success';
  } else {
    message.textContent = 'Are you sure you want to deregister this user?';
    confirmBtn.className = 'btn btn-danger';
  }

  confirmBtn.href =
    `includes/update_status.php?user_id=${userId}&is_active=${action}`;
});
</script>
