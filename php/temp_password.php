<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">

<!-- cs328 class HTML template: last modified 2023-02-22 -->

<!--
    adapted from: CS 328 hw7 problem2
    by: Gracie Ceja
    last modified: November 21, 2023

    you can run this using the URL: https://nrs-projects.humboldt.edu/~glc47/cs458/loginTesting/temp_password.php
    CS 458 Software Engineering
    Semester Project: Unique Builders Company Website & Database
    Team: Tech Titans
    Fall 2023
    Employeee Login: Login with Temporary Password and Make New Password
    Requirements: 2.1 & 2.2
-->

<!-- 
    This website displays all the various pages of login (such as enter username & forgot password)
    as different webpages:
    webpage 1.0 for entering username                                                  (login_start.php)
    webpages 2.0 for entering password:                                                (login_password.php)
        webpage 2.1 for new users to also enter more info                              (user_info_input.php)
        webpage 2.2 for returning users to just enter password or pick forgot password (empl_handling.php & password_form.php)
    webpages 3.0 for forgot password                                                    
        webpage 3.1 for entering contact info to request password reset from admin      (forgot_password.php & valid_contact_info.js)
        webpage 3.2 to inform the user that their info was sent to an admin             (inform_user.php)
        webpage 3.3 for them to login with a temporary password & make a new password   (temp_password.php)
    webpage 4.0 for trying to log them in to the database                               (login_empl.php & verify_password.php)
        webpage 4.1 correct password, they are logged in & go to employee homepage
        webpage 4.2 incorrect password, they are sent back to webpage 2.2
        webpage 4.3 they got locked out from too many invalid password login attempts 

    also, database_connect.php (used by many files)
    total: 17 files (16 php, 1 js)
        
    This file is for: webpage 3.3 the user logs in with a temporary password & makes a new password 
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

    <!-- stage 3.3: login with temporary password & make new password-->
    <?php
        // next stage: 4.0 (logging in to database)
        // initialize these to prepare for next stage
        $_SESSION["badPasswordAttempts"] = 0;
        $_SESSION["locked_out"] = false;

        // get username from session variable
        $username = $_SESSION["username"];
    ?>

    <!-- Personalized header because they entered their username -->
    <h1 id="welcomeheader">Welcome <?= $username ?></h1>

    <form method="post" action="https://nrs-projects.humboldt.edu/~glc47/cs458/loginTesting/login_empl.php">
        <h2 id="instructionheader">Please Provide Needed Information Below</h2>

        <input type="password" name="tempPassword" class="rectangleinput" placeholder="Temporary Password" />
        </br>

        <input type="password" name="newPassword" class="rectangleinput" placeholder="New Password" />
        <input type="password" name="confirmPassword" class="rectangleinput" placeholder="Confirm Password" />

        <input type="submit" value="Submit" />
    </form>

</body>
</html>

