<?php
/*
    by: Gracie Ceja & Emilyo Garcia
    last modified: November 25, 2023

    you can run this using the URL: https://nrs-projects.humboldt.edu/~glc47/cs458/Unique_Builders-main/php/logout.php
    CS 458 Software Engineering
    Semester Project: Unique Builders Company Website & Database
    Team: Tech Titans
    Fall 2023
    Employeee Logout
    Requirement: 2.1
*/
    session_start();
?>

<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">

<!-- cs328 class HTML template: last modified 2023-02-22 -->

<head>
    <title>Employee Logout | Unique Builders</title>
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
    // log out the user
    $_SESSION["logged_in"] = "F";
    unset($_SESSION["username"]);
    // Destroy the session
    session_destroy();
    ?>

    <!-- Generic header because they logged out -->
    <h1 id="welcomeheader">Goodbye</h1>
    <!-- Nav bar adapted from homepage -->
    <nav>
        <ul class="nav">
            <li><a href="../html/homepage.html">Home</a></li>
            <li><a href="../php/login_start.php">Employee Login</a></li>
            <li><a href="../php/cust_contact.php">Contact Us</a></li>
        </ul>
    </nav>

    <form method="post" action="../php/login_start.php">
        <h2 id="instructionheader">You are now logged out.</h2>

        <input type="submit" value="Go back to Login" />
    </form>


</body>
</html>