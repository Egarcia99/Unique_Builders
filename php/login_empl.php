<?php
/*
    adapted from: CS 328 hw7 problem2
    by: Gracie Ceja, Colton Boyd, & Emilyo Garcia
    last modified: November 25, 2023

    you can run this using the URL: https://nrs-projects.humboldt.edu/~glc47/cs458/loginTesting/login_empl.php
    CS 458 Software Engineering
    Semester Project: Unique Builders Company Website & Database
    Team: Tech Titans
    Fall 2023
    Employeee Login
    Requirements: 2.1 & 2.2
*/

    session_start();
    require_once("empl_homepage.php");
    require_once("user_lockout_functs.php");
?>

<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">

<!-- cs328 class HTML template: last modified 2023-02-22 -->

<head>
    <title>Employee Login | Unique Builders</title>
    <meta charset="utf-8" />

    <!-- favicon -->
    <link rel="icon" type="image/x-icon" href="../images/UB_logo.jpg" />

	<!-- default css to make the webpage look nearly the same on all browsers -->
    <link href="https://nrs-projects.humboldt.edu/~st10/styles/normalize.css"
          type="text/css" rel="stylesheet" />
          

	<!-- css file adapted from from cs328 homework 4, problem 9 -->
    <link href="../css/login.css" type="text/css" rel="stylesheet" />

</head>
<body>

<?php
    // try to login actually after enter username & password

    // get username from session variable
    $username = strip_tags($_SESSION["username"]);
    // get password from form, but first check whether it's a regular or temp password
    // get temp password
    if(isset($_POST["tempPassword"]))
    {
        $_SESSION["tempPassword"] = trim($_POST["tempPassword"]);
    }
    $tempPass = $_SESSION["tempPassword"];

    // check if a temporary password was entered
    if(isset($tempPass))
    {
        $password = $_POST["tempPassword"];
    }
    // they didn't enter a temp password, just a regular one
    else
    {
        $password = $_POST["password"];
    }
        

    // connection section adapted from cs328 hw7 problem1
    // put password into session variable to use again later to recconnect
    $_SESSION["password"] = $password;

    // login with username & password
    // set up db connection 
    require_once("../../../database_connect.php");
    $connObj = db_conn_sess();
    /*==============
        db connection for when we have it setup
    ==================*/


    // if can't log in, password is bad
    require_once("verify_password.php");
    if (!verifyPassword($username,$password))
    {
        // the password was incorrect, so increment the failed attempts in the database
        // and send them back to the login page with message of attempts
        incrementFailedAttempts($connObj, $username);
        // close the connection to the database
        oci_close($connObj);
    } 
    // their password is correct & they have logged in succesfully.
    else
    {
        // take them to the employee homepage
        emplHomepage();
    }
    ?>

    
</body>
</html>