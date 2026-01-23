

<?PHP
//This file will be used for all code that interact with database
function getUsers($conn){
   $sql = "SELECT users.*, role.role_name
            FROM users
            JOIN role ON users.role_id = role.role_id";

$stmt = mysqli_stmt_init($conn);

if(!mysqli_stmt_prepare($stmt, $sql)) {
    
    exit();
}

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
mysqli_stmt_close($stmt); 

return $result;
}

function getStudentsByCourseId($conn, $course_id){
  $sql = "SELECT u.user_id, u.first_name, u.last_name, e.class_id
          FROM enrolment e
          INNER JOIN users u ON u.user_id = e.student_id
          WHERE e.course_id = ?
            AND u.role_id = 2
            AND u.is_active = 1
          ORDER BY u.first_name, u.last_name";

  $stmt = mysqli_stmt_init($conn);
  if(!mysqli_stmt_prepare($stmt, $sql)){
    die("Prepare failed: " . mysqli_error($conn));
  }

  mysqli_stmt_bind_param($stmt, "i", $course_id);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
  mysqli_stmt_close($stmt);

  return $result;
}


function getStudentsByClassId($conn, $class_id){
  $sql = "SELECT u.user_id, u.first_name, u.last_name
          FROM enrolment e
          INNER JOIN users u ON u.user_id = e.student_id
          WHERE e.class_id = ?
            AND u.role_id = 2
            AND u.is_active = 1
          ORDER BY u.first_name, u.last_name";

  $stmt = mysqli_stmt_init($conn);
  if(!mysqli_stmt_prepare($stmt, $sql)){
    die("Prepare failed: " . mysqli_error($conn));
  }

  mysqli_stmt_bind_param($stmt, "i", $class_id);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
  mysqli_stmt_close($stmt);

  return $result;
}

function getClassesByCourseId($conn, $course_id) {
    $sql = "SELECT class_id, class_name
            FROM classes
            WHERE course_id = ?
            ORDER BY class_name";

    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        die("Prepare failed: " . mysqli_error($conn));
    }

    mysqli_stmt_bind_param($stmt, "i", $course_id);
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

function getEnrolment($conn){
  $sql = "SELECT enrolment.enrolment_id, enrolment.course_id, enrolment.student_id,
      course.course_name, course.course_code,
      users.first_name, users.last_name
    FROM enrolment 
    INNER JOIN course  ON course.course_id = enrolment.course_id
    INNER JOIN users   ON users.user_id  = enrolment.student_id
    ORDER BY course.course_name, users.first_name, users.last_name
  ";

  $stmt = mysqli_stmt_init($conn);
  if(!mysqli_stmt_prepare($stmt, $sql)){
    return false;
  }

  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
  mysqli_stmt_close($stmt);

  return $result;
}

function enrolmentExists($conn, $student_id, $course_id){
  $sql = "SELECT enrolment_id FROM enrolment WHERE student_id = ? AND course_id = ? LIMIT 1";
  $stmt = mysqli_stmt_init($conn);

  if(!mysqli_stmt_prepare($stmt, $sql)){
    return false;
  }

  mysqli_stmt_bind_param($stmt, "ii", $student_id, $course_id);
  mysqli_stmt_execute($stmt);

  $result = mysqli_stmt_get_result($stmt);
  $exists = mysqli_fetch_assoc($result) ? true : false;

  mysqli_stmt_close($stmt);
  return $exists;
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
   
    exit();
}

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
mysqli_stmt_close($stmt); 

return $result;
}

function getTeachersActive($conn){
   $sql = "SELECT user_id, first_name, last_name 
          FROM users
          WHERE is_active = 1 AND role_id = 1";
        
$stmt = mysqli_stmt_init($conn);

if(!mysqli_stmt_prepare($stmt, $sql)) {
    
    exit();
}

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
mysqli_stmt_close($stmt); 

return $result;
}
function getStudentsActive($conn){
   $sql = "SELECT user_id, first_name, last_name 
          FROM users
          WHERE is_active = 1 AND role_id = 2";
        
$stmt = mysqli_stmt_init($conn);

if(!mysqli_stmt_prepare($stmt, $sql)) {
    
    exit();
}

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
mysqli_stmt_close($stmt); 

return $result;
}


function getStudentEnrolmentWithUnits($conn, $student_id) {

    $sql = "SELECT
                c.course_id, c.course_name, c.course_code,
                u.unit_id, u.unit_name, u.unit_code,
                GROUP_CONCAT(DISTINCT CONCAT(t.first_name, ' ', t.last_name) SEPARATOR ', ') AS teacher_names
            FROM enrolment e
            JOIN course c ON c.course_id = e.course_id
            LEFT JOIN course_units cu ON cu.course_id = c.course_id
            LEFT JOIN unit u ON u.unit_id = cu.unit_id AND u.is_active = 1
            LEFT JOIN unit_teacher ut ON ut.unit_id = u.unit_id AND ut.class_id = e.class_id
            LEFT JOIN users t ON t.user_id = ut.teacher_id AND t.role_id = 1
            WHERE e.student_id = ?
              AND c.is_active = 1
            GROUP BY c.course_id, c.course_name, c.course_code,
                     u.unit_id, u.unit_name, u.unit_code
            ORDER BY c.course_name, u.unit_name";

    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        die("SQL prepare failed: " . mysqli_error($conn));
    }
    mysqli_stmt_bind_param($stmt, "i", $student_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);
    return $result;
}



function getTeachersActiveById($conn, $teacher_id){
  $sql = "SELECT user_id, first_name, last_name
          FROM users
          WHERE user_id = ? AND is_active = 1 AND role_id = 1
          LIMIT 1";

  $stmt = mysqli_stmt_init($conn);
  if(!mysqli_stmt_prepare($stmt, $sql)) return false;

  mysqli_stmt_bind_param($stmt, "i", $teacher_id);
  mysqli_stmt_execute($stmt);

  $result = mysqli_stmt_get_result($stmt);
  $row = mysqli_fetch_assoc($result);

  mysqli_stmt_close($stmt);
  return $row ?: false;
}


function getUnitIdsByTeacherAndClass($conn, $teacher_id, $class_id){
  $sql = "SELECT unit_id FROM unit_teacher WHERE teacher_id = ? AND class_id = ?";
  $stmt = mysqli_stmt_init($conn);
  if(!mysqli_stmt_prepare($stmt, $sql)) return false;
  mysqli_stmt_bind_param($stmt, "ii", $teacher_id, $class_id);
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


function getUnitIdsByCourseId($conn, $course_id){
  $sql = "SELECT unit_id FROM course_units WHERE course_id = ?";
  $stmt = mysqli_stmt_init($conn);

  if(!mysqli_stmt_prepare($stmt, $sql)){
    return false;
  }

  mysqli_stmt_bind_param($stmt, "i", $course_id);
  mysqli_stmt_execute($stmt);

  $result = mysqli_stmt_get_result($stmt);
  mysqli_stmt_close($stmt);

  return $result;
}


function getUnitsByCourseId($conn, $course_id){
    $sql = "SELECT unit.unit_id,unit.unit_code,unit.unit_name,unit.ects_credits,unit.is_active
            FROM course_units 
            JOIN unit  ON course_units.unit_id = unit.unit_id
            WHERE course_units.course_id = ?
            ORDER BY unit.unit_code";

    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        return false;
    }

    mysqli_stmt_bind_param($stmt, "i", $course_id);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);

    return $result;
}




function getClassById($conn, $class_id){
    $sql = "SELECT * FROM classes WHERE class_id = ?";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt, $sql)){
        return false;
    }

    mysqli_stmt_bind_param($stmt, "i", $class_id);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    $class = mysqli_fetch_assoc($result);

    mysqli_stmt_close($stmt);
    return $class;
}



function getRole($conn){
   $sql = "SELECT * FROM role";
$stmt = mysqli_stmt_init($conn);

if(!mysqli_stmt_prepare($stmt, $sql)) {
    
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




function registerUser($conn, $role_id, $first_name, $last_name, $email, $hashedPassword, $date_of_birth, $is_active, $must_change_password, $institute_id, $is_independent) {

  $sql = "INSERT INTO users 
            (role_id, first_name, last_name, email, password_hash, date_of_birth, is_active, must_change_password, institute_id, is_independent)
          VALUES 
            (?, ?, ?, ?, ?, ?, ?, ?, NULLIF(?,0), ?)";

  $stmt = mysqli_stmt_init($conn);
  if (!mysqli_stmt_prepare($stmt, $sql)) {
    die("Prepare failed: " . mysqli_error($conn));
  }

  
  $institute_id_param = (empty($institute_id) ? 0 : (int)$institute_id);

  mysqli_stmt_bind_param(
    $stmt,
    "isssssiiii",
    $role_id,
    $first_name,
    $last_name,
    $email,
    $hashedPassword,
    $date_of_birth,
    $is_active,
    $must_change_password,
    $institute_id_param,
    $is_independent
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

function deleteProfilePhoto($conn, $user_id){
  $sql = "UPDATE users SET profile_photo = NULL WHERE user_id = ?";
  $stmt = mysqli_stmt_init($conn);

  if(!mysqli_stmt_prepare($stmt, $sql)){
    return false;
  }

  mysqli_stmt_bind_param($stmt, "i", $user_id);
  mysqli_stmt_execute($stmt);
  mysqli_stmt_close($stmt);
  return true;
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
       if(!preg_match("/^[\p{L}\p{N}\s\-\x{2013}\x{2014}\(\)&'\"\x{2018}\x{2019}\x{201C}\x{201D},\.\/:]+$/u", $course_name)){
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

//Validation functions for classes
function getTeacherClassUnitSummary($conn){
  $sql = "
    SELECT ut.teacher_id, ut.class_id, CONCAT(u2.first_name, ' ', u2.last_name) AS teacher_name,
      c.class_name,
      GROUP_CONCAT(DISTINCT u.unit_code ORDER BY u.unit_code SEPARATOR ', ') AS unit_codes
    FROM unit_teacher ut
    JOIN users u2 ON u2.user_id = ut.teacher_id
    JOIN classes c ON c.class_id = ut.class_id
    JOIN unit u ON u.unit_id = ut.unit_id
    WHERE ut.class_id IS NOT NULL
    GROUP BY ut.teacher_id, ut.class_id
    ORDER BY teacher_name, c.class_name
  ";

  $stmt = mysqli_stmt_init($conn);
  if(!mysqli_stmt_prepare($stmt, $sql)){
    return false;
  }
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
  mysqli_stmt_close($stmt);
  return $result;
}



function getClassesWithUnits($conn){
  $sql = "
    SELECT 
      c.class_id,
      c.class_name,
      co.course_name,
      co.course_code,
      GROUP_CONCAT(u.unit_code ORDER BY u.unit_code SEPARATOR ', ') AS unit_codes
    FROM classes c
    LEFT JOIN course co ON co.course_id = c.course_id
    LEFT JOIN course_units cu ON cu.course_id = c.course_id
    LEFT JOIN unit u ON u.unit_id = cu.unit_id
    GROUP BY c.class_id, c.class_name, co.course_name, co.course_code
    ORDER BY c.class_name
  ";

  $stmt = mysqli_stmt_init($conn);
  if(!mysqli_stmt_prepare($stmt, $sql)){
    return false;
  }

  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
  mysqli_stmt_close($stmt);
  return $result;
}


function getClasses($conn){
  $sql = "
    SELECT 
      c.class_id,
      c.class_name,
      co.course_name,
      co.course_code,
      GROUP_CONCAT(DISTINCT CONCAT(u.first_name, ' ', u.last_name) 
                   ORDER BY u.first_name SEPARATOR ', ') AS teachers
    FROM classes c
    LEFT JOIN course co ON co.course_id = c.course_id
    LEFT JOIN unit_teacher ut ON ut.class_id = c.class_id
    LEFT JOIN users u ON u.user_id = ut.teacher_id
    GROUP BY c.class_id, c.class_name, co.course_name, co.course_code
    ORDER BY c.class_name
  ";

  $stmt = mysqli_stmt_init($conn);
  if(!mysqli_stmt_prepare($stmt, $sql)) return false;

  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
  mysqli_stmt_close($stmt);
  return $result;
}



//Validation functions for classes


function emptyClassInput($class_name, $course_id){
  return (trim($class_name) === "" || (int)$course_id <= 0);
}

function invalidClass_name($class_name){
  // letters, numbers, spaces, dash, dot, &, /
  return !preg_match("/^[a-zA-Z0-9\s\.\-&\/]+$/", $class_name);
}

function editClass($conn, $class_id, $class_name, $course_id){
  $sql = "UPDATE classes SET class_name = ?, course_id = ? WHERE class_id = ?";
  $stmt = mysqli_stmt_init($conn);

  if(!mysqli_stmt_prepare($stmt, $sql)){
    return false;
  }

  mysqli_stmt_bind_param($stmt, "sii", $class_name, $course_id, $class_id);
  $ok = mysqli_stmt_execute($stmt);
  mysqli_stmt_close($stmt);

  return $ok;
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
       if(!preg_match("/^[\p{L}\p{N}\s\-\x{2013}\x{2014}\(\)&'\"\x{2018}\x{2019}\x{201C}\x{201D},\.\/:]+$/u", $unit_name)){
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
function emptyRegistrationInput($role_id, $first_name, $last_name, $email, $date_of_birth, $is_active, $institute_id, $is_independent = 0) {

  // required for everyone
  if (
    trim((string)$role_id) === "" ||
    trim((string)$first_name) === "" ||
    trim((string)$last_name) === "" ||
    trim((string)$email) === "" ||
    trim((string)$date_of_birth) === "" ||
    trim((string)$is_active) === ""
  ) {
    return true;
  }

  // institute required ONLY for non-independent users
  if ((int)$is_independent === 0) {
    if (trim((string)$institute_id) === "" || (int)$institute_id === 0) {
      return true;
    }
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
  $sql = "SELECT user_id, role_id, first_name, last_name, email, password_hash, must_change_password, is_active
          FROM users
          WHERE email = ? LIMIT 1";
  $stmt = mysqli_stmt_init($conn);

  if(!mysqli_stmt_prepare($stmt, $sql)){
    return false;
  }

  mysqli_stmt_bind_param($stmt, "s", $email);
  mysqli_stmt_execute($stmt);

  $result = mysqli_stmt_get_result($stmt);
  $user = mysqli_fetch_assoc($result);

  mysqli_stmt_close($stmt);
  return $user ?: false;
}

function isUserActive($user) {
  return isset($user['is_active']) && (int)$user['is_active'] === 1;
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
    
  
function loginUser($conn, $email, $plainPassword) {
  $email = trim(strtolower($email));

  // check email exists
  $user = getUserByEmail($conn, $email);
  if(!$user){
    header("Location: ../login_institute.php?error=emailnotfound");
    exit();
  }

  //  inactive account
  if(isset($user['is_active']) && (int)$user['is_active'] === 0){
    header("Location: ../login_institute.php?error=inactive");
    exit();
  }

  //  must change password (first time login)
  if(isset($user['must_change_password']) && (int)$user['must_change_password'] === 1){
    header("Location: ../reset_password.php?email=" . urlencode($email) . "&error=mustchange");
    exit();
  }

  // verify password
  if(!password_verify($plainPassword, $user['password_hash'])){
    header("Location: ../login_institute.php?error=wrongpassword");
    exit();
  }

  //  login OK start session
  if (session_status() === PHP_SESSION_NONE) session_start();
  $_SESSION["user_id"] = (int)$user["user_id"];
  $_SESSION["email"] = $user["email"];
  $_SESSION["role_id"] = (int)$user["role_id"];
  $_SESSION["first_name"] = $user["first_name"];
  $_SESSION["last_name"] = $user["last_name"];

  header("Location: ../index.php");
  exit();
}

   

