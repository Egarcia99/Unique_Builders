<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">

<!-- cs328 class HTML template: last modified 2023-02-22 -->

<!--
    adapted from: CS 328 hw7 problem2
    by: Gracie Ceja
    last modified: November 4, 2023

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