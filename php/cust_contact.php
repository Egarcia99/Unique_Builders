<?php
/*
    adapted from: CS 328 hw7 problem2
    by: Gracie Ceja & Emilyo Garcia
    last modified: November 25, 2023

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

    // time to contact the company with a potential job. but first:    
    // get customer's contact info from form
    $custName =  trim($_POST["name"]);
    $custEmail = trim($_POST["email"]);
    $custPhoneNum = trim($_POST["phone"]);
    $custJob = trim($_POST["job_description"]);
            
    // email to admin to help them contact the customer
    // this should send to admin's email, but I'll use mine for now
    if($_SERVER['REQUEST_METHOD'] === 'POST') 
    {
        // prepare the message
        $message = "Dear Admin,

        The potential customer " . $custName . " has contacted the company about a potential job.
        Here is their contact info: 
        email: " . $custEmail . "
        phone number: " . $custPhoneNum . "

        This is the job description they entered: 
        " . $custJob . "

        Sincerely,
        cust_contact.php in UniqueBuilders.net
        [This email was sent automatically; I cannot read any replies to it.]";

        // send the email
        mail("glc47@humboldt.edu", "Customer Contact request from: " . $custName,
        $message, "From: customerContactForm@UniqueBuilders.net");
    }
?>

<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">

<!-- cs328 class HTML template: last modified 2023-02-22 -->

<head>
    <title>Customer Contact Page</title>
    <meta charset="utf-8" />

    <link href="https://nrs-projects.humboldt.edu/~st10/styles/normalize.css"
    type="text/css" rel="stylesheet" />
    
    <link href="../css/main.css" type="text/css" rel="stylesheet" />
</head>
<body>

  <h1 id="welcomeheader"> Contact Us</h1>
  <form action="#" method="post">

    <div class="header">
      <h2 id="instructionheader">Please provide further information to ensure you get contacted accurately and as soon as possible </h2>
    </div>
    <!-- Nav bar adapted from homepage -->
    <nav>
        <ul class="navbar">
            <li><a href="../html/homepage.html">Home</a></li>
            <li><a href="../php/login_start.php">Employee Login</a></li>
            <li><a href="../php/cust_contact.php">Contact Us</a></li>
        </ul>
    </nav>

    <input type="text" name="name" placeholder="Please enter your first and last name" required="required">
    <input type="email" name="email" placeholder="Email Address" required="required">
    <input type="tel" name="phone" placeholder="Phone Number" required="required">
    <input type="text" name="job_description" placeholder="Job Description"  rows="4" cols="50" required="required"> 

    <input type="submit" value="Submit">
  </form>

</body>
</html>