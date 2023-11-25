<?php
/*
    adapted from: CS 328 hw7 problem2
    by: Gracie Ceja & Emilyo Garcia
    last modified: November 24, 2023

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
?>

<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">

<!-- cs328 class HTML template: last modified 2023-02-22 -->


<!-- this file doesn't seem to use Colton's lockout features... -->

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
        $_SESSION["badPasswordAttempts"]++;

        // stage 4.3: 
        // timeout because too many incorrect password attempts
        // 5 is just an example value, idk what the limit should be.
        if($_SESSION["badPasswordAttempts"] > 5 || ($_SESSION["locked_out"] == true && date_diff(date(), $_SESSION["lockout_time"])->h < 24))
        {
            // close session & try to lock them out
            unset($_POST["username"]);
            unset($_POST["password"]);
            $_SESSION["locked_out"] = true;
            // if they were already locked out, don't reset the timer
            if(date_diff(date(), $_SESSION["lockout_time"])->h >= 24)
            {
                $_SESSION["lockout_time"] = date();
            }
            ?>
            

            <!-- Personalized header because they entered their username -->
            <h1 id="welcomeheader">Welcome <?= $username ?></h1>
            <!-- Nav bar adapted from homepage -->
            <nav>
                <ul class="nav">
                    <li><a href="../html/homepage.html">Home</a></li>
                    <li><a href="../php/login_start.php">Employee Login</a></li>
                    <li><a href="../php/cust_contact.php">Contact Us</a></li>
                </ul>
            </nav>

            <!-- log in form adapted from hw4 of cs328 -->
            <form method="get" action="https://nrs-projects.humboldt.edu/~glc47/cs458/loginTesting/login_empl.php">
                <h2 id="instructionheader">Please Enter Your Password Below</h2>

                <input type="password" name="lockedOut" class="roundedinput" required="required" disabled/>
                <input type="submit" name="timedOut" value="Forgot Password?" id="forgotpassword" disabled />

                <p id="timeoutMessage">
                    You have been Timeout due to too many inaccurate password attempts
                    try again in 24 hours
                </p>

                <input type="submit" name="Timeout" value="Submit" />
            </form>
            <?php
            // should have functionality for them to be locked out even when session is over, but idk how.
            // maybe they have a value in the database of lockout time that can be updated? idk
        }
        // stage 4.2:
        // don't lock them out yet
        else
        {
            // make sure they are not locked out
            $_SESSION["locked_out"] = false;
            $_SESSION["lockout_time"] = strtotime('May 1, 2023');
            passwordForm($username);
        }


    }   // end of if block for when password is incorrect (stage 4.2 & 4.3)
    // their password is correct & they have logged in succesfully.
    else
    {
        // here should be code to go to the page for when the employee is logged in
        ?>
            <!-- Personalized header because they logged in -->
            <h1 id="welcomeheader">Welcome <?= $username ?></h1>

            <!-- insert Employee homepage here -->
            <p>Employee Homepage</p>
        
        <?php
    }
    ?>

    
</body>
</html>