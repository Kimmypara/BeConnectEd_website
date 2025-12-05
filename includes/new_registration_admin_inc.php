<?php
require_once "functions.php";
require_once "dbh.php";
    //print_r($_POST);
//check if data submitted
if(!isset($_POST["submit"])){
    //user trying to access this file without submitting a form

    //redirect user back to registration page
    header("location: ../register.php");
    exit();
}
else{
    $username = $_POST["username"];
    $password = $_POST["password"];
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $age = $_POST["age"];

if(emptyRegistrationInput($username, $password, $firstname, $lastname, $age)){
     header("location: ../register.php?error=emptyinput");
    exit();
}

//we should call each of our validation function here


//all good register
registerUser($conn,$username, $password, $firstname, $lastname, $age);
    header("location: ../register.php?success=true");
    exit();
}

?>