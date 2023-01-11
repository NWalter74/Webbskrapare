<?php

include 'connect.php';

if(isset($_POST["submit"]))
{
    //variabels in breackets are the names in the sign in form
    $userID = $_POST["userID"];
    $username = $_POST["username"];
    $password = $_POST["pwd"];
    $passwordRepeat = $_POST["pwdRepeat"];

    require_once 'functions.inc.php';

    //ERRORHANDLERS
    //if the function returns anything besides false, then throw an error
    if(emptyInputSignup($userID, $username, $password, $passwordRepeat) !== false)
    {
        header("location: signup.php?error=emptyinput");
        
        //stopps the script from running if something happens
        exit();
    }

    if(invalidUsername($username) !== false)
    {
        header("location: signup.php?error=invalidUsername");
        
        //stopps the script from running if something happens
        exit();
    }

    if(pwdMatch($password, $passwordRepeat) !== false)
    {
        header("location: signup.php?error=passwordsDontMatch");
        
        //stopps the script from running if something happens
        exit();
    }

    if(usernameExists($conn, $username) !== false)
    {
        header("location: signup.php?error=usernameExists");
        
        //stopps the script from running if something happens
        exit();
    }

    createUser($conn, $userID, $username, $password);
}
else
{
    header("location: signup.php");
    exit();
}