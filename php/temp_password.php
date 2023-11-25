<?php
/*
    adapted from: CS 328 hw7 problem2
    by: Gracie Ceja & Emilyo Garcia
    last modified: November 24, 2023

    you can run this using the URL: https://nrs-projects.humboldt.edu/~glc47/cs458/loginTesting/temp_password.php
    CS 458 Software Engineering
    Semester Project: Unique Builders Company Website & Database
    Team: Tech Titans
    Fall 2023
    Employeee Login: Login with Temporary Password and Make New Password
    Requirements: 2.1 & 2.2
*/
    session_start();
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

    <!-- login with temporary password & make new password-->
    <?php
        // next stage: log in to database
        // initialize these to prepare for next stage
        $_SESSION["badPasswordAttempts"] = 0;
        $_SESSION["locked_out"] = false;

        // get username from session variable
        $username = $_SESSION["username"];
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

    <form method="post" action="../php/login_empl.php">
        <h2 id="instructionheader">Please Provide Needed Information Below</h2>

        <input type="password" name="tempPassword" class="rectangleinput" placeholder="Temporary Password" />
        </br>

        <input type="password" name="newPassword" class="rectangleinput" placeholder="New Password" />
        <input type="password" name="confirmPassword" class="rectangleinput" placeholder="Confirm Password" />

        <input type="submit" value="Submit" />
    </form>

</body>
</html>

