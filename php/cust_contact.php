<?php
/*
    adapted from: CS 328 hw7 problem2
    by: Gracie Ceja & Emilyo Garcia
    last modified: November 28, 2023

    you can run this using the URL: https://uniquebuilders.co/cs458/php/cust_contact.php
    (or, for testing purposes: https://nrs-projects.humboldt.edu/~glc47/cs458/Unique_Builders-main/php/cust_contact.php)
    CS 458 Software Engineering
    Semester Project: Unique Builders Company Website & Database
    Team: Tech Titans
    Fall 2023
    Customer Contact Form
    Requirement: 2.6

    This webpage allows the customer to contact the company to talk about a potential job for them.
*/

    session_start();

?>

<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">

<!-- cs328 class HTML template: last modified 2023-02-22 -->

<head>
    <title>Customer Contact | Unique Builders</title>
    <meta charset="utf-8" />

    <link href="https://nrs-projects.humboldt.edu/~st10/styles/normalize.css"
    type="text/css" rel="stylesheet" />

    <link href="../css/login.css" type="text/css" rel="stylesheet" />
</head>
<body>

  <h1 id="welcomeheader">Contact Us</h1>
  <!-- Nav bar adapted from homepage -->
  <nav>
      <ul class="nav">
          <li><a href="../html/homepage.html">Home</a></li>
          <li><a href="../php/login_start.php">Employee Login</a></li>
          <li><a href="../php/cust_contact.php">Contact Us</a></li>
      </ul>
  </nav>


  <form action="../php/contact_confirm.php" method="post">
    <div class="header">
      <h2 id="instructionheader">Please provide further information to ensure you get contacted accurately and as soon as possible </h2>
    </div>

    <label for="name">First and Last Name:</label>
    <input type="text" id="name" name="name" placeholder="Please enter your first and last name" required="required">

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" placeholder="Email Address" required="required">

    <label for="phoneNum">Phone Number:</label>
    <input type="tel" id="phoneNum" name="phone" placeholder="Phone Number" required="required">

    <label for="jobDesc">Job Description:</label>
    <input type="text" id="jobDesc" name="job_description" placeholder="Job Description"  rows="4" cols="50" required="required"> 

    <input type="submit" value="Submit">
  </form>

</body>
</html>