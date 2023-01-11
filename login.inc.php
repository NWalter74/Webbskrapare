<?php

include 'connect.php';

if(isset($_POST["submit"]))
{
    $username = $_POST["username"];
    $password = $_POST["pwd"];

    require_once 'functions.inc.php';

    //ERRORHANDLERS
    //if the function returns anything besides false, then throw an error
    if(emptyInputLogin($username, $password) !== false)
    {
        header("location: login.php?error=emptyinput");
        //stopps the script from running if something happens
        exit();
    }

    loginUser($conn, $username, $password);
}
else
{
    header("location: login.php");
    //stopps the script from running if something happens
    exit();
}