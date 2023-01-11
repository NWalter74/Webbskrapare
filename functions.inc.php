<?php

function emptyInputSignup($userID, $username, $password, $passwordRepeat)
{
    $result = true;;

    if(empty($userID) || empty($username) || empty($password) || empty($passwordRepeat))
    {
        $result = true;
    }
    else
    {
        $result = false;
    }
    return $result;
}

function invalidUsername($username)
{
    $result = true;;

    if(!preg_match("/^[a-zA-Z0-9]*$/", $username))
    {
        $result = true;
    }
    else
    {
        $result = false;
    }
    return $result;
}

function pwdMatch($password, $passwordRepeat)
{
    $result = true;

    if($password !== $passwordRepeat)
    {
        $result = true;
    }
    else
    {
        $result = false;
    }
    return $result;
}

function usernameExists($conn, $username)
{
    //? = placeholder for security and to protect for sql injections
    $sql = "SELECT * FROM användarinfo WHERE ANV_NAMN = ?;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql))
    {
        header("location: signup.php?error=stmtfailed");
        //stopps the script from running if something happens
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if($row = mysqli_fetch_assoc($resultData))
    {
        return $row;
    }
    else
    {
        $result = false;
        return $result;
    }

    mysqli_stmt_close($stmt);
}

function createUser($conn, $userID, $username, $password)
{
    // //hashing to the password to make it unreadable
    // $hashedPwd = password_hash($password, PASSWORD_DEFAULT);

    // $sql = $conn->query(query:"INSERT INTO användarinfo (ANV_ID, ANV_NAMN, ANV_LOSEN) VALUES ('$userID', '$username', '$hashedPwd')");

    $sql = "INSERT INTO användarinfo (ANV_ID, ANV_NAMN, ANV_LOSEN) VALUES (?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);

    // if ($sql->num_rows > 0)
    if (!mysqli_stmt_prepare($stmt, $sql))
    {
        header("location: signup.php?error=stmtfailed");
        //stopps the script from running if something happens
        exit();
    }

    //hashing to the password to make it unreadable
    //$hashedPwd = password_hash($password, PASSWORD_DEFAULT);

    mysqli_stmt_bind_param($stmt, "sss", $userID, $username, $password);   
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("location: signup.php?error=none");
    exit();
}

function emptyInputLogin($username, $password)
{
    $result = true;;

    if(empty($username) || empty($password))
    {
        $result = true;
    }
    else
    {
        $result = false;
    }
    return $result;
}

function loginUser($conn, $username, $password)
{
    $userIdExists = usernameExists($conn, $username, $password);

    if($userIdExists === false)
    {
        header("location: login.php?error=wronglogin");
        //stopps the script from running if something happens
        exit();
    }

    // $pwdHashed = $userIdExists["ANV_LOSEN"];
    // $checkPwd = password_verify($password, $pwdHashed);

    $data = $conn->query("SELECT ANV_ID FROM användarinfo WHERE ANV_NAMN = '$username' AND ANV_LOSEN = '$password'");

    // if($checkPwd === false)
    if($data->num_rows > 0)
    {
        session_start();
        $_SESSION["userId"] = $userIdExists["ANV_ID"];
        $_SESSION["username"] = $userIdExists["ANV_NAMN"];
        header("location: prospektlista.php");
        //stopps the script from running if something happens
        exit();

        // header("location: login.php?error=wronglogin");
        // //stopps the script from running if something happens
        // exit();
    }
    // else if ($checkPwd === true)
    {
        // session_start();
        // $_SESSION["userId"] = $userIdExists["ANV_ID"];
        // $_SESSION["username"] = $userIdExists["ANV_NAMN"];
        // header("location: prospektlista.php");
        // //stopps the script from running if something happens
        // exit();

        header("location: login.php?error=wronglogin");
        //stopps the script from running if something happens
        exit();

    }
}