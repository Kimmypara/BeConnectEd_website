

<?PHP
//This file will be used for all code that interact with database
function getUsers($conn){
   $sql = "SELECT users.*, role.role_name
            FROM users
            JOIN role ON users.role_id = role.role_id";

$stmt = mysqli_stmt_init($conn);

if(!mysqli_stmt_prepare($stmt, $sql)) {
    echo"<p>We have an error.</p>";
    exit();
}

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
mysqli_stmt_close($stmt); 

return $result;
}



function getRole($conn){
   $sql = "SELECT * FROM role";
$stmt = mysqli_stmt_init($conn);

if(!mysqli_stmt_prepare($stmt, $sql)) {
    echo"<p>We have an error.</p>";
    exit();
}

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
mysqli_stmt_close($stmt); 

return $result;
}






function registerUser($conn, $role_id, $first_name, $last_name, $email, $date_of_birth, $is_active,$must_change_password, $institute_id){
    $sql = "INSERT INTO users (role_id, first_name, last_name, email, date_of_birth, is_active,must_change_password, institute_id) 
            VALUES (?,?,?,?,?,?,?,?)";
    
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../new_registration_admin.php?error=stmtfailed");
        exit();
    }

  

    mysqli_stmt_bind_param(
        $stmt,
        "issssisi",   // changed ORDER to match your data types
        $role_id,
        $first_name,
        $last_name,
        $email,
        $date_of_birth,
        $is_active,
        $must_change_password,
        $institute_id,
        //$qualifications,
       
    );

    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

//Validation functions
  function emptyRegistrationInput($role_id, $first_name, $last_name, $email, $date_of_birth, $is_active, $must_change_password, $institute_id){

    if (empty($role_id) || 
        empty($first_name) || 
        empty($last_name) || 
        empty($email) || 
        empty($date_of_birth) || 
        $is_active === "" || 
        $must_change_password === "") {

        return true;
    }

      // if Independent_teacher(role_id = 5), institute MUST be empty
    if($role_id == 5 && !empty($institute_id)){
        return true;
    }

       if ($role_id != 5 && empty($institute_id)) {
        return true;
    }

    return false;
}

function invalidFirst_name($first_name){
        // allow letters and numbers, but nothing else
        if(!preg_match("/^[a-zA-Z0-9]*$/",$first_name)){
            return true;
        }
    }

    function invalidLast_name($last_name){
        // allow letters and numbers, but nothing else
        if(!preg_match("/^[a-zA-Z0-9]*$/",$last_name)){
            return true;
        }
    }

    function invalidEmail($email){
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            return true;
        }
    }
function emailExists($conn, $email){
    $sql = "SELECT user_id FROM users WHERE email = ?";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt, $sql)){
        return false;
    }

    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    return mysqli_fetch_assoc($result) ? true : false;
}


function invalidDate_of_birth($date_of_birth){
    return empty($date_of_birth);
}


    // If Teacher (role_id = 1), qualifications MUST NOT be empty
   // if($role_id == 1 && empty($qualifications)){
     //   return true;
    //}

    // If Parent (role_id = 3), relationship MUST NOT be empty
   // if($role_id == 3 && empty($relationship)){
     //   return true;
   // }
    
    
?>
