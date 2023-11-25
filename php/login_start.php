<?php
/*
    adapted from: CS 328 hw7 problem2
    by: Gracie Ceja, Colton Boyd, & Emilyo Garcia
    last modified: November 25, 2023

    you can run this using the URL: https://nrs-projects.humboldt.edu/~glc47/cs458/Unique_Builders-main/php/login_start.php
    CS 458 Software Engineering
    Semester Project: Unique Builders Company Website & Database
    Team: Tech Titans
    Fall 2023
    Employeee Login part 1: Enter Username & Password
    Requirements: 2.1 & 2.2
*/
    session_start();
    require_once("empl_homepage.php");
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
    // the user is already logged in
    if(isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == "T")
    {
        emplHomepage();
    }
    // the user isn't logged in, give them the login form
    else
    {
        $_SESSION["logged_in"] = "F";
        ?>

        <!-- Generic header because they didn't yet enter their username -->
        <h1 id="welcomeheader">Welcome</h1>
        <!-- Nav bar adapted from homepage -->
        <nav>
            <ul class="nav">
                <li><a href="../html/homepage.html">Home</a></li>
                <li><a href="../php/login_start.php">Employee Login</a></li>
                <li><a href="../php/cust_contact.php">Contact Us</a></li>
            </ul>
        </nav>

        <!-- log in form adapted from hw4 of cs328 -->
        <form method="post" action="../php/login_password.php">
            <h2 id="instructionheader">Please Enter Infomation</h2>

            <label for="username">Username:</label>
            <input type="text" id="username" name="username" class="roundedinput" required="required" />
            
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" class="roundedinput" required="required" />
            
            <p><a href="../php/forgot_password.php" id="forgotpasswordlink">Forgot Password?</a></p>
            <input type="submit" value="Submit" />
        </form>
        
        <?php
    }
    ?>

</body>
</html>