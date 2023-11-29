<?php
/*
    adapted from: CS 328 hw7 problem2
    by: Gracie Ceja & Emilyo Garcia
    last modified: November 28, 2023

    you can run this using the URL: https://nrs-projects.humboldt.edu/~glc47/public_html/Unique_Builders-main/php/contact_confirm.php
    CS 458 Software Engineering
    Semester Project: Unique Builders Company Website & Database
    Team: Tech Titans
    Fall 2023
    Employeee Login: Inform Potential Customer whether they successfully contacted the company about a potential job.
    Requirement: 2.6
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
        $custName =  trim($_POST["name"]);
        $custEmail = trim($_POST["email"]);
        $custPhoneNum = trim($_POST["phone"]);
        $custJob = trim($_POST["job_description"]);
        $message = "Dear Admin,

        The potential customer " . $custName . " has contacted the company about a potential job.
        Here is their contact info: 
        email: " . $custEmail . "
        phone number: " . $custPhoneNum . "

        This is the job description they entered: 
        " . $custJob . "

        Sincerely,
        contact_confirm.php in UniqueBuilders.co
        [This email was sent automatically; I cannot read any replies to it.]";

        // send the email
        mail("crb119@humboldt.edu", "Customer Contact request from: " . $custName,
        $message, "From: customerContactForm@UniqueBuilders.co");
        
        $_SESSION["contactSent"] = "True";
    }
    else
    {
      $_SESSION["contactSent"] = "False";
    }

?>

<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">

<!-- cs328 class HTML template: last modified 2023-02-22 -->

<head>
    <title>Contact Us | Unique Builders</title>
    <meta charset="utf-8" />

    <!-- favicon -->
    <link rel="icon" type="image/x-icon" href="../images/UB_logo.jpg" />

        <!-- css file adapted from from cs328 homework 4, problem 9 -->
    <link href="../css/login.css" type="text/css" rel="stylesheet" />

        <!-- default css to make the webpage look nearly the same on all browsers -->
    <link href="https://nrs-projects.humboldt.edu/~st10/styles/normalize.css"
          type="text/css" rel="stylesheet" />

</head>
<body>
    <?php
        // inform user that info about a potential job was sent
        if($_SESSION["contactSent"] === "True")
        {
            ?>
            <!-- Personalized header because they entered their name -->
            <h1 id="welcomeheader">Thank You <?= $custName ?></h1>
            <!-- Nav bar adapted from homepage -->
            <nav>
                <ul class="nav">
                    <li><a href="../html/homepage.html">Home</a></li>
                    <li><a href="../php/login_start.php">Employee Login</a></li>
                    <li><a href="../php/cust_contact.php">Contact Us</a></li>
                </ul>
            </nav>

            <form method="post" action="../php/cust_contact.php">
                <table class="infoTable">
                    <tr> <td>Hello <?= $custName ?></td> </tr>
                    <tr> <td>You have successfully contacted the company about a potential job! Please be patient as we review your message.</td> </tr>
                    <tr> <td>We will reply to you at your email:
                        <?= $custEmail ?>, or your phone number: <?= $custPhoneNum ?> </td> </tr>
                </table>

                <!-- button to go back to login -->
                <input type="submit" name="submit" value="Go back to Contact Form" />
            </form>
        <?php
        }   // end of if for when info was sent
        else
        {
          if(!isset($custName))
          {
            $custName = "User";
          }
            ?>
            <!-- Personalized header because they entered their name -->
            <h1 id="welcomeheader">Thank You <?= $custName ?></h1>
            <!-- Nav bar adapted from homepage -->
            <nav>
                <ul class="nav">
                    <li><a href="../html/homepage.html">Home</a></li>
                    <li><a href="../php/login_start.php">Employee Login</a></li>
                    <li><a href="../php/cust_contact.php">Contact Us</a></li>
                </ul>
            </nav>

            <form method="post" action="../php/cust_contact.php">
                <table class="infoTable">
                    <tr> <td class="lightText">Hello <?= $custName ?></td> </tr>
                    <tr> <td class="lightText">Please be patient as we could not send the company an email 
                        about your potential job at this time.</td> </tr>
                    <tr> <td class="lightText">Please go back and try again.</td> </tr>
                </table>

                <!-- button to go back to login -->
                <input type="submit" name="submit" value="Go back to Contact Form" />
            </form>
        <?php     
        }
    ?>


</body>
</html>