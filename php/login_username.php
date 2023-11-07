<?php
    session_start();

    /*
    we are no longer using this,
    instead of emailing admin, we just put their info directly into the database

    // user's first time to this, so just initialize these variables
    if($_SERVER['REQUEST_METHOD'] == 'GET')
    {
        $_SESSION["username"] = null;
        $_SESSION["newUser"] = null;
        $_SESSION["newInfoSent"] = "False";

    }
    else
    {
        // check if the user is a new user
        $newUser = $_SESSION["newUser"];
        // if they are a new user, send an email to contact admin to create new account
        if($newUser == "True")
        {
            // get info from previous page via $_SESSION variable
            $newInfoSent = $_SESSION["newInfoSent"];

            // email to admin to ask them to help user to create an account
            // this should send to admin's email, but I'll use mine for now
            if($newInfoSent == "False") 
            {
                // get user info from $_SESSION & $_POST variables
                $username = $_SESSION["username"];
                $name = $_POST["name"];
                $email = $_POST["email"];
                $phoneNum = $_POST["phoneNum"];
                $password = $_POST["password"];

                // prepare the message
                $message = "Dear Admin,

                The employee " . $name . " has requested a new user account.
                Please make them an account with the following info: 
                username: " . $username . "
                email: " . $email . "
                phone number: " . $phoneNum . "
                password: " . $password . "

                Sincerely,
                login_username.php in UniqueBuilders.net
                [This email was sent automatically; I cannot read any replies to it.]";

                // send the email
                mail("glc47@humboldt.edu", "New account request from user: " . $name,
                $message, "From: employeeLogin@UniqueBuilders.net");
                $newInfoSent = "True";
                $_SESSION["newInfoSent"] = "True";
            }   // end if of sending email
        }   // end if of checking of user is a new user
    }
    */

?>


<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">

<!-- cs328 class HTML template: last modified 2023-02-22 -->

<!--
    adapted from: CS 328 hw7 problem2
    by: Gracie Ceja
    last modified: November 6, 2023

    you can run this using the URL: https://nrs-projects.humboldt.edu/~glc47/cs458/loginTesting/login_username.php
    CS 458 Software Engineering
    Semester Project: Unique Builders Company Website & Database
    Team: Tech Titans
    Fall 2023
    Employeee Login: Enter Username
    Requirements: 2.1 & 2.2
-->

<!-- 
    This website displays all the various pages of login (such as enter username & forgot password)
    as different webpages:
    webpage 1.0 for entering username                                                  (login_username.php)
    webpages 2.0 for entering password:                                                (login_password.php)
        webpage 2.1 for new users to also enter more info
        webpage 2.2 for returning users to just enter password or select forgot password
    webpages 3.0 for forgot password                                                    
        webpage 3.1 for entering contact info to request password reset from admin      (forgot_password.php)
        webpage 3.2 to inform the user that their info was sent to an admin             (inform_user.php)
        webpage 3.3 for them to login with a temporary password & make a new password   (temp_password.php)
    webpage 4.0 for trying to log them in to the database                               (login_empl.php)
        webpage 4.1 correct password, they are logged in & go to employee homepage
        webpage 4.2 incorrect password, they are sent back to webpage 2.2
        webpage 4.3 they got locked out from too many invalid password login attempts (looks like webpage 2.2)

    total: 6 files
        
    This file is for: webpage 1.0 enter username.
-->



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

    <!-- Generic header because they didn't yet enter their username -->
    <h1 id="welcomeheader">Welcome</h1>

    <!-- log in form adapted from hw4 of cs328 -->
    <form method="post" action="https://nrs-projects.humboldt.edu/~glc47/cs458/loginTesting/login_password.php">
        <h2 id="instructionheader">Please Enter Your Username Below</h2>

        <input type="text" name="username" class="roundedinput" required="required" />

        <input type="submit" value="Submit" />
    </form>

</body>
</html>