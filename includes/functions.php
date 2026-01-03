

<?PHP
//This file will be used for all code that interact with database
function getUsers($conn){
   $sql = "SELECT users.*, role.role_name
            FROM users
            JOIN role ON users.role_id = role.role_id";

$stmt = mysqli_stmt_init($conn);

if(!mysqli_stmt_prepare($stmt, $sql)) {
    //echo"<p>We have an error.</p>";
    exit();
}

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
mysqli_stmt_close($stmt); 

return $result;
}

function getUserById($conn, $user_id){
    $sql = "SELECT * FROM users WHERE user_id = ?";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt, $sql)){
        return false;
    }

    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);

    mysqli_stmt_close($stmt);
    return $user;
}


function getCourses($conn){
   $sql = "SELECT course.*, institute.institute_name
            FROM course
            Left JOIN institute ON course.institute_id = institute.institute_id";

$stmt = mysqli_stmt_init($conn);

if(!mysqli_stmt_prepare($stmt, $sql)) {
    //echo"<p>We have an error.</p>";
    exit();
}

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
mysqli_stmt_close($stmt); 

return $result;
}

function getCourseById($conn, $course_id){
    $sql = "SELECT * FROM course WHERE course_id = ?";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt, $sql)){
        return false;
    }

    mysqli_stmt_bind_param($stmt, "i", $course_id);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    $course = mysqli_fetch_assoc($result);

    mysqli_stmt_close($stmt);
    return $course;
}

function getUnits($conn){
   $sql = "SELECT * FROM unit";

$stmt = mysqli_stmt_init($conn);

if(!mysqli_stmt_prepare($stmt, $sql)) {
    //echo"<p>We have an error.</p>";
    exit();
}

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
mysqli_stmt_close($stmt); 

return $result;
}

function getUnitsActive($conn){
   $sql = "SELECT * FROM unit WHERE is_active = 1";

$stmt = mysqli_stmt_init($conn);

if(!mysqli_stmt_prepare($stmt, $sql)) {
    //echo"<p>We have an error.</p>";
    exit();
}

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
mysqli_stmt_close($stmt); 

return $result;
}

function getUnitById($conn, $unit_id){
    $sql = "SELECT * FROM unit WHERE unit_id = ?";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt, $sql)){
        return false;
    }

    mysqli_stmt_bind_param($stmt, "i", $unit_id);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    $unit = mysqli_fetch_assoc($result);

    mysqli_stmt_close($stmt);
    return $unit;
}



function getRole($conn){
   $sql = "SELECT * FROM role";
$stmt = mysqli_stmt_init($conn);

if(!mysqli_stmt_prepare($stmt, $sql)) {
    //echo"<p>We have an error.</p>";
    exit();
}

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
mysqli_stmt_close($stmt); 

return $result;
}


function getInstitute($conn){
   $sql = "SELECT * FROM institute";
$stmt = mysqli_stmt_init($conn);

if(!mysqli_stmt_prepare($stmt, $sql)) {
    //echo"<p>We have an error.</p>";
    exit();
}

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
mysqli_stmt_close($stmt); 

return $result;
}


function editUser($conn, $user_id, $role_id, $first_name, $last_name, $email, $date_of_birth, $is_active, $must_change_password, $institute_id){

    $sql = "UPDATE users 
            SET role_id = ?, first_name = ?, last_name = ?, email = ?, date_of_birth = ?, 
                is_active = ?, must_change_password = ?, institute_id = ?
            WHERE user_id = ?;";

    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt,$sql)){
        header("location: ../edit-registration.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param(
        $stmt,
        "issssiiii",
        $role_id,
        $first_name,
        $last_name,
        $email,
        $date_of_birth,
        $is_active,
        $must_change_password,
        $institute_id,
        $user_id
    );

    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}




function registerUser($conn, $role_id, $first_name, $last_name, $email, $hashedPassword, $date_of_birth, $is_active,$must_change_password, $institute_id){
    $sql = "INSERT INTO users (role_id, first_name, last_name, email,password_hash, date_of_birth, is_active,must_change_password, institute_id) 
            VALUES (?,?,?,?,?,?,?,?,?)";
    
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../new_registration_admin.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param(
        $stmt,
        "isssssisi",   // changed ORDER to match your data types
        $role_id,
        $first_name,
        $last_name,
        $email,
        $hashedPassword,
        $date_of_birth,
        $is_active,
        $must_change_password,
        $institute_id,
        //$qualifications,
       
    );

    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

function registerCourse($conn,$course_name,  $course_code, $institute_id, $is_active,  $MQF_Level,  $duration,$credits,$course_description){
    $sql = "INSERT INTO course (course_name, course_code, institute_id, is_active, MQF_Level, duration, credits, course_description) 
            VALUES (?,?,?,?,?,?,?,?)";
    
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../add_course.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param(
        $stmt,
        "ssiiisis",   //  ORDER to match data types
        $course_name,
        $course_code,
        $institute_id,
        $is_active,
        $MQF_Level,
        $duration,
        $credits,
        $course_description
       
       
    );

    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}


function registerUnit($conn, $unit_name,  $unit_code, $ects_credits, $unit_description,  $is_active,  $unit_duration){
    $sql = "INSERT INTO unit (unit_name, unit_code, ects_credits, unit_description, is_active, unit_duration) 
            VALUES (?,?,?,?,?,?)";
    
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../add_unit.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param(
        $stmt,
        "ssisis",   //  ORDER to match data types
        $unit_name,
        $unit_code,
        $ects_credits,
        $unit_description,
        $is_active,
        $unit_duration
    );

    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

function editCourse($conn, $course_id, $course_name,  $course_code, $institute_id, $is_active,  $MQF_level,  $duration,$credits,$course_description){

    $sql = "UPDATE course 
            SET course_name = ?, course_code = ?, institute_id = ?, is_active = ?, MQF_level = ?, 
                duration = ?, credits = ?, course_description = ?
            WHERE course_id = ?;";

    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt,$sql)){
        header("location: ../edit-course.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param(
           $stmt,
        "ssiissisi",   //  ORDER to match data types
        $course_name,
        $course_code,
        $institute_id,
        $is_active,
        $MQF_level,
        $duration,
        $credits,
        $course_description,
        $course_id

    );

    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

function editUnit($conn, $unit_id, $unit_name,  $unit_code, $ects_credits, $unit_description,  $is_active,  $unit_duration){

    $sql = "UPDATE unit 
            SET unit_name = ?, unit_code = ?, ects_credits = ?, unit_description = ?, is_active = ?, 
                unit_duration = ?
            WHERE unit_id = ?;";

    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt,$sql)){
        header("location: ../edit-unit.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param(
           $stmt,
        "ssisisi",   //  ORDER to match data types
        $unit_name,
        $unit_code,
        $ects_credits,
        $unit_description,
        $is_active,
        $unit_duration,
        $unit_id

    );

    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}


//Validation functions for courses
function emptyCourseInput($course_name,  $course_code, $institute_id, $is_active,  $MQF_level,  $duration,$credits,$course_description){
    if (empty($course_name) || 
        empty($course_code) || 
        empty($institute_id) || 
        $is_active === "" || 
        empty($MQF_level) || 
        empty($duration) || 
        empty($credits) || 
        empty($course_description) 
       ) {

        return true;
    }
}

function invalidCourse_name($course_name){
       if(!preg_match("/^[a-zA-Z0-9\s\-]+$/", $course_name)){
            return true;
        }
    }

    function invalidCourse_code($course_code){
      if(!preg_match("/^[A-Za-z0-9\-\.\/]+$/", $course_code)){
            return true;
        }
    }

function courseCodeExists($conn, $course_code){
    $sql = "SELECT course_id FROM course WHERE course_code = ?";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt, $sql)){
        return false;
    }

    mysqli_stmt_bind_param($stmt, "s", $course_code);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_assoc($result) ? true : false;

      mysqli_stmt_close($stmt);
    return $exists;
}


function invalidMQF_Level($MQF_level){
    return empty($MQF_level);
}

function invalidCredits($credits){
    return empty($credits);
}
function invalidDuration($duration){
    return empty($duration);
}

//Validation functions for units
function emptyUnitInput($unit_name,  $unit_code, $ects_credits, $is_active,  $unit_description,  $unit_duration){
    if (empty($unit_name) || 
        empty($unit_code) || 
        empty($ects_credits) || 
        empty($unit_description) ||
        $is_active === "" || 
        empty($unit_duration) 
       ) {

        return true;
    }
}

function invalidUnit_name($unit_name){
       if(!preg_match("/^[a-zA-Z0-9\s\-]+$/", $unit_name)){
            return true;
        }
    }

    function invalidUnit_code($unit_code){
      if(!preg_match("/^[A-Za-z0-9\-\.\/]+$/", $unit_code)){
            return true;
        }
    }

function unitCodeExists($conn, $unit_code){
    $sql = "SELECT unit_id FROM unit WHERE unit_code = ?";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt, $sql)){
        return false;
    }

    mysqli_stmt_bind_param($stmt, "s", $unit_code);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_assoc($result) ? true : false;

      mysqli_stmt_close($stmt);
    return $exists;
}


function invalidEcts_credits($ects_credits){
    return empty($ects_credits);
}

function invalidUnit_duration($unit_duration){
    return empty($unit_duration);
}




//Validation functions for new user registration
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


   function login($conn, $email, $plainPassword){
    $user = userExists($conn, $email);

    if(!$user){
    header("location: ../login_institute.php?error=incorrectlogin");
    exit();    
    }

  $userId =$user["user_id"];

  $user = getUser($conn, $userId);
  $dbPassword = $user["password_hash"];
  $checkPassword = password_verify($plainPassword, $dbPassword);

  if(!$checkPassword){
    header("location:../login.php?error=incorrectlogin");
    exit();
  }

  session_start();

  $_SESSION ["email"] = $email;
  $_SESSION ["user_id"] = $userId;

  header("location:../index.php");
  exit();

}

 function random_password(){
    $lower_case = "qwertyuiopasdfghjklzxcvbnm";
    $upper_case = "QWERTYUIOPASDFGHJKLZXCVBNM";
    $digits = "1234567890";
    $symbols = "%!$*&^~#@";

     $lower_case = str_shuffle($lower_case);
     $upper_case = str_shuffle($upper_case);
     $digits = str_shuffle($digits);
     $symbols = str_shuffle($symbols);

     $random_characters = 2;

     $random_password =substr($lower_case, 0, $random_characters);
     $random_password .=substr($upper_case, 0, $random_characters);
     $random_password .=substr($digits, 0, $random_characters);
     $random_password .=substr($symbols, 0, $random_characters);

     return str_shuffle($random_password);
   } 

function getUserByEmail($conn, $email) {
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_assoc($result);
}

function userExists($conn, $first_name){
    $sql = "SELECT user_id FROM user WHERE first_name = ?;";
    
    $stmt = mysqli_stmt_init($conn);
    
    if(!mysqli_stmt_prepare($stmt,$sql)){
        header("location: ../login.php?error=stmtfailed");
        exit();
    }
    
    // Here, we replace the ? wildcard with an integer, its value being in the userId variable
    mysqli_stmt_bind_param($stmt, "s", $first_name);
    
    mysqli_stmt_execute($stmt);
    
    $result = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);
    
    if($row = mysqli_fetch_assoc($result)){
        return $row;
    }
    else{
        return false;
    }
}
    
  

   

