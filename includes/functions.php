

<?PHP
//This file will be used for all code that interact with database
function getUsers($conn){
   $sql = "SELECT * FROM users";
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



function registerUser($conn, $role_id, $first_name, $last_name, $email, $date_of_birth, $must_change_password, $qualifications, $relationship){
    $sql = "INSERT INTO users (user_role, firstname, lastname, email, date_of_birth, password_hash, must_change_password, qualifications, relationship) 
            VALUES (?,?,?,?,?,?,?,?,?)";
    
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../new_registration_admin.php?error=stmtfailed");
        exit();
    }

  

    mysqli_stmt_bind_param(
        $stmt,
        "isssiiss",   // changed ORDER to match your data types
        $role_id,
        $first_name,
        $last_name,
        $email,
        $date_of_birth,
        $must_change_password,
        $qualifications,
        $relationship
    );

    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

//Validation functions
function emptyRegistrationInput($role_id, $first_name, $last_name, $email, $date_of_birth,  $must_change_password, $qualifications, $relationship){

    if(empty($role_id) || empty($firstname) || empty($lastname) || empty($email) || empty($date_of_birth) ){
        return true;
    }

    // If Teacher (role_id = 1), qualifications MUST NOT be empty
    if($role_id == 1 && empty($qualifications)){
        return true;
    }

    // If Parent (role_id = 3), relationship MUST NOT be empty
    if($role_id == 3 && empty($relationship)){
        return true;
    }

    return false;
}

    //we should have a bunch of other functions that check different things 
    //Ex. Invalid username - maybe we do no want symbols
    //Invalid password - we can check if pw has numbers, letters, or symbols
    //
?>
