<?php
    session_start();

    // time to contact admin for help! but first:
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
        // prepare the message
        $message = "Dear Admin,

        The user " . $username . " has requested a password reset because they forgot their password.
        Please send them a temporary password at their " . $contactType . ": " . $contactInfo . ".

        Sincerely,
        inform_user.php in UniqueBuilders.net
        [This email was sent automatically; I cannot read any replies to it.]";

        // send the email
        mail("glc47@humboldt.edu", "Password Reset request from user: " . $username,
        $message, "From: employeeLogin@UniqueBuilders.net");
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

<!--
    adapted from: CS 328 hw7 problem2
    by: Gracie Ceja
    last modified: November 6, 2023

    you can run this using the URL: https://nrs-projects.humboldt.edu/~glc47/cs458/loginTesting/inform_user.php
    CS 458 Software Engineering
    Semester Project: Unique Builders Company Website & Database
    Team: Tech Titans
    Fall 2023
    Employeee Login: Inform User that info was sent to Admin so they can reset their password
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
        
    This file is for: webpage 3.2 inform user
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
        <?php
            // stage 3.2: inform user that info was sent to admin to make new account
            if($infoSent === "True")
            {
                $_SESSION["infoSent"] = "True";
            ?>
                <!-- Personalized header because they entered their username -->
                <h1 id="welcomeheader">Thank You <?= $username ?></h1>

                <form method="post" action="https://nrs-projects.humboldt.edu/~glc47/cs458/loginTesting/temp_password.php" id="goToLogin">
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
    
                <form method="post" action="https://nrs-projects.humboldt.edu/~glc47/cs458/loginTesting/forgot_password.php" id="goToForgotPassword">
                    <table class="infoTable">
                        <tr> <td>Hello <?= $username ?></td> </tr>
                        <tr> <td>Please be patient as we could not send the admin an email 
                            to help you get a temporary password at this time.</td> </tr>
                        <tr> <td>Please go back and try again.</td> </tr>
                    </table>
                    
                    <!-- button to go back to login -->
                    <input type="submit" name="submit" value="Go back to Forgot Password form" />
                </form>
            <?php     
            }
        ?>


</body>
</html>