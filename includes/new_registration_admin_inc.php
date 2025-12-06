<?php
require_once "functions.php";
require_once "dbh.php";
    
//check if data submitted
if(!isset($_POST["submit"])){
    //user trying to access this file without submitting a form

    //redirect user back to registration page
    header("location: ../new_registration_admin.php");
    exit();
}
else{
    $user_role = $_POST["user_role"];
    $first_name = $_POST["first_name"];
    $last_name = $_POST["last_name"];
    $email = $_POST["email"];
    $date_of_birth = $_POST["date_of_birth"];
    $password_hash = $_POST["password_hash"];
    $must_change_password = $_POST["must_change_password"];
    $qualifications = $_POST["qualifications"];
    $relationship = $_POST["relationship"];






   // Before we try and save data into the database, we should always run some data validation to check that everything is ok
        // This example checks if all inputs are filled in 
        if(emptyRegistrationInput($user_role, $first_tname, $last_name, $email, $date_of_birth,  $password_hash, $must_change_password, $qualifications, $relationship)){
            // Here we redirect the user back to the register page with an error code in the QueryString
            // This will be used to show an error in the page if the use left some fields empty
            header("location: ../new_registration_admin.php?error=emptyinput");
            exit();
        }
        // We should call each of our validation functions here


        // If all validation has passed, then the user has filled in the form correctly
        // In that case, we call our registerUser function to actually save the data in the database
        registerUser($conn,$user_role, $first_name, $last_name, $email, $date_of_birth,  $password_hash, $must_change_password, $qualifications, $relationship);

        // Once the data hase been saved in the database, we can redirect back to the registration page
        // Here we are adding a QueryString that states that the registration process has been successful
        // This will be used to show a success message to the user
        header("location: ../registration_admin.php?success=true");
        exit();
    }




?>