<?php
/*
    adapted from: CS 328 hw7 problem2
    by: Gracie Ceja & Emilyo Garcia
    last modified: November 24, 2023

    you can run this using the URL: https://nrs-projects.humboldt.edu/~glc47/public_html/Unique_Builders-main/php/inform_user.php
    CS 458 Software Engineering
    Semester Project: Unique Builders Company Website & Database
    Team: Tech Titans
    Fall 2023
    Employeee Login: Inform User that info was sent to Admin so they can reset their password
    Requirements: 2.1 & 2.2
*/
    session_start();

    // time to contact admin for help, but first:
    // get info from previous page:
    // get username & infoSent from session variables
    $username = $_SESSION["username"];
    $infoSent = $_SESSION["infoSent"]; 
    // get contact info from form, but first determine which was entered
    if(null != trim($_POST["emailForgotPassword"]))
    {
        $contactInfo = $_POST["emailForgotPassword"];
        $contactType = "email address";
    }
    else
    {
        $contactInfo = $_POST["phoneNumForgotPassword"];
        $contactType = "phone number";
    }
            
    // email to admin to ask them to help user to reset password
    // this should send to admin's email, but I'll use mine for now
    if($_SERVER['REQUEST_METHOD'] === 'POST' && $infoSent == "False") 
    {
        require_once("../../../private/assign_temp_pass.php");
        generateTempPassword($username, $contactType, $contactInfo);
        $infoSent = "True";
        $_SESSION["infoSent"] = "True";
    }
    // don't send the email again
    elseif($infoSent == "True")
    {
        $infoSent = "True";
        $_SESSION["infoSent"] = "True";
    }
    else
    {
        $infoSent = "False";
        $_SESSION["infoSent"] = "False";
    }

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
        // inform user that info was sent to admin to make new account
        if($infoSent === "True")
        {
            $_SESSION["infoSent"] = "True";
        ?>
            <!-- Personalized header because they entered their username -->
            <h1 id="welcomeheader">Thank You <?= $username ?></h1>
            <!-- Nav bar adapted from homepage -->
            <nav>
                <ul class="nav">
                    <li><a href="../html/homepage.html">Home</a></li>
                    <li><a href="../php/login_start.php">Employee Login</a></li>
                    <li><a href="../php/cust_contact.php">Contact Us</a></li>
                </ul>
            </nav>

            <form method="post" action="../php/login_start.php" id="goToLogin">
                <table class="infoTable">
                    <tr> <td>Hello <?= $username ?></td> </tr>
                    <tr> <td>Please be patient as we send you an email or text message 
                        with a temporary password for the next time you want to login.</td> </tr>
                    <tr> <td>Information will be sent to:
                        <?= $contactInfo ?></td> </tr>
                </table>
                
                <!-- button to go back to login -->
                <input type="submit" name="submit" value="Go back to Login" />
            </form>
        <?php
        }   // end of if for when info was sent
        else
        {
            ?>
            <!-- Personalized header because they entered their username -->
            <h1 id="welcomeheader">Thank You <?= $username ?></h1>
            <!-- Nav bar adapted from homepage -->
            <nav>
                <ul class="nav">
                    <li><a href="../html/homepage.html">Home</a></li>
                    <li><a href="../php/login_start.php">Employee Login</a></li>
                    <li><a href="../php/cust_contact.php">Contact Us</a></li>
                </ul>
            </nav>

            <form method="post" action="../php/forgot_password.php" id="goToForgotPassword">
                <table class="infoTable">
                    <tr> <td style="color:white;" >Hello <?= $username ?></td> </tr>
                    <tr> <td style="color:white;">Please be patient as we could not send the admin an email 
                        to help you get a temporary password at this time.</td> </tr>
                    <tr> <td style="color:white;">Please go back and try again.</td> </tr>
                </table>
                
                <!-- button to go back to login -->
                <input type="submit" name="submit" value="Go back to Forgot Password form" />
            </form>
        <?php     
        }
    ?>


</body>
</html>