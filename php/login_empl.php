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

    you can run this using the URL: https://nrs-projects.humboldt.edu/~glc47/cs458/loginTesting/login_empl.php
    CS 458 Software Engineering
    Semester Project: Unique Builders Company Website & Database
    Team: Tech Titans
    Fall 2023
    Employeee Login: Enter Password
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
        
    This file is for: webpage 2.0 enter password
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
    // webpage 4.0: try to login actually after enter username & password

        // get username from session variable
        $username = strip_tags($_SESSION["username"]);
        // password from form, but first check whether regular or temp password
        if(null !== trim($_POST["tempPassword"]))
        {
            $password = $_POST["tempPassword"];
        }
        else
        {
            $password = $_POST["password"];
        }
        


        // connection section adapted from cs328 hw7 problem1
        // put password into session variable to use again later to recconnect
        $_SESSION["password"] = $password;

        // login with username & password
        // set up db connection string
        
        // connection object
        $connObj = oci_connect($username, $password, $dbConnStr);
        require_once("database_connect.php");
        //$connObj = db_conn_sess();
        /*==============
            db connection for when we have it setup
        ==================*/
        // if can't log in, password is bad
        require_once("verify_password.php");
        if (!verifyPassword($username,$password))
        {
            $_SESSION["badPasswordAttempts"]++;

            // stage 4.3: 
            // timeout because too many inccorect password attempts
            // 5 is just an example value, idk what the limit should be.
            if($_SESSION["badPasswordAttempts"] > 5 || ($_SESSION["locked_out"] == true && date_diff(date(), $_SESSION["lockout_time"])->h < 24))
            {
                // close session & try to lock them out
                unset($_POST["username"]);
                unset($_POST["password"]);
                $_SESSION["locked_out"] = true;
                // if they were already locked out, don't reset the timer
                if(date_diff(date(), $_SESSION["lockout_time"])->h >= 24)
                {
                    $_SESSION["lockout_time"] = date();
                }
                ?>
                

                <!-- Personalized header because they entered their username -->
                <h1 id="welcomeheader">Welcome <?= $username ?></h1>
    
                <!-- log in form adapted from hw4 of cs328 -->
                <form method="get" action="https://nrs-projects.humboldt.edu/~glc47/cs458/loginTesting/login_empl.php">
                    <h2 id="instructionheader">Please Enter Your Password Below</h2>
    
                    <input type="password" name="lockedOut" class="roundedinput" required="required" disabled/>
                    <input type="submit" name="timedOut" value="Forgot Password?" id="forgotpassword" disabled />
    
                    <p id="timeoutMessage">
                        You have been Timeout due to too many inaccurate password attempts
                        try again in 24 hours
                    </p>

                    <input type="submit" name="Timeout" value="Submit" />
                </form>
                <?php
                // should have functionality for them to be locked out even when session is over, but idk how.
                // maybe they have a value in the database of lockout time that can be updated? idk
            }
            // stage 4.2:
            // don't lock them out yet
            else
            {
                // make sure they are not locked out
                $_SESSION["locked_out"] = false;
                $_SESSION["lockout_time"] = strtotime('May 1, 2023');
                passwordForm($username);
            }


        }   // end of if block for when password is incorrect (stage 4.2 & 4.3)
        // their password is correct & they have logged in succesfully.
        else
        {
            // here should be code to go to the page for when the employee is logged in
            ?>
                <!-- Personalized header because they logged in -->
                <h1 id="welcomeheader">Welcome <?= $username ?></h1>

                <!-- insert Employee homepage here -->
                <p>Employee Homepage</p>
            
            <?php
        }

    ?>

    
</body>
</html>