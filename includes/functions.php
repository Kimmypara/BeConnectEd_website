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



function registerUser($conn, $user_role, $first_name, $last_name, $email, $date_of_birth, $password_hash, $must_change_password, $qualifications, $relationship){
    $sql = "INSERT INTO users (user_role, firstname, lastname, email, date_of_birth, password_hash, must_change_password, qualifications, relationship) 
            VALUES (?,?,?,?,?,?,?,?,?)";
    
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../new_registration_admin.php?error=stmtfailed");
        exit();
    }

    $hashedPassword = password_hash($password_hash, PASSWORD_DEFAULT);

    mysqli_stmt_bind_param(
        $stmt,
        "sssssisss",   // changed ORDER to match your data types
        $user_role,
        $first_name,
        $last_name,
        $email,
        $date_of_birth,
        $hashedPassword,
        $must_change_password,
        $qualifications,
        $relationship
    );

    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}



    //Validation functions
    function emptyRegistrationInput($user_role, $first_name, $last_name, $email, $date_of_birth, $password_hash, $must_change_password, $qualifications, $relationship){
    if(
        empty($user_role) || 
        empty($first_name) || 
        empty($last_name) || 
        empty($email) || 
        empty($date_of_birth) || 
        empty($password_hash) ||
        (!isset($must_change_password)) 
    ){
        return true;
    }
   
}






    //we should have a bunch of other functions that check different things 
    //Ex. Invalid username - maybe we do no want symbols
    //Invalid password - we can check if pw has numbers, letters, or symbols
    //
?>
