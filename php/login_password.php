<?php
    session_start();
    require_once("login_info_form.php");
    require_once("verify_password.php");
    require_once("user_lockout_functs.php");
?>

<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">

<!-- cs328 class HTML template: last modified 2023-02-22 -->

<!--
    adapted from: CS 328 hw7 problem2
    by: Gracie Ceja and Colton Boyd
    last modified: November 21, 2023

    you can run this using the URL: https://nrs-projects.humboldt.edu/~crb119/public_html/CS_458/php/login_password.php
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
    webpage 1.0 for entering username                                                  (login_start.php)
    webpages 2.0 for entering password:                                                (login_password.php)
        webpage 2.1 for new users to also enter more info                              (user_info_input.php)
        webpage 2.2 for returning users to just enter password or pick forgot password (empl_handling.php & password_form.php)
        webpage 2.3 user doesn't exist, show error message and send back to username login
    webpages 3.0 for forgot password                                                    
        webpage 3.1 for entering contact info to request password reset from admin      (forgot_password.php & valid_contact_info.js)
        webpage 3.2 to inform the user that their info was sent to an admin             (inform_user.php)
        webpage 3.3 for them to login with a temporary password & make a new password   (temp_password.php)
    webpage 4.0 for trying to log them in to the database                               (login_empl.php & verify_password.php)
        webpage 4.1 correct password, they are logged in & go to employee homepage
        webpage 4.2 incorrect password, they are sent back to webpage 2.2
        webpage 4.3 they got locked out from too many invalid password login attempts 

    also, database_connect.php (used by many files)
    total: 17 files (16 php, 1 js)
        
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
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            /*  
            webpage 2.0 (displays either webpage 2.1 or webpage 2.2):
            user has attempted to login with username but not password yet
            */

            // next step: check if they are new or returning user, to determine the next state

            // connection section adapted from cs328 hw7 problem1
            // get username from form
            $username = strip_tags($_POST["username"]);
            $password = strip_tags($_POST["password"]);
            // put username into session variable to use again later to recconnect
            $_SESSION["username"] = $username;

            /* use account that can only see usernames (not an actual account on nrs-projects)
            this must be changed to info of DB for our project */
            
            // connection object
            require_once("../../../private/database_connect.php");
            $connObj = db_conn_sess();
            /*==============
                db connection for when we have it setup
            ==================*/

            // check if the entered username exists in the database already or no.
            // set up query string & statement
            $usernameQueryString = "SELECT empl_id,first_login, is_temporary
                                    FROM Employee
                                    WHERE empl_id = :username";
            $usernameStmt = oci_parse($connObj, $usernameQueryString);
            oci_bind_by_name($usernameStmt, ":username", $username);

            // execute statement & get info from it
            oci_execute($usernameStmt, OCI_DEFAULT);
            //echo $username;
            // loop through usernames until username is found or all usernames have been checked
            
            $usr = NULL;
            while(oci_fetch($usernameStmt)) {
                $usr = oci_result($usernameStmt, 'empl_id'); // get next username from database
                $newUser = oci_result($usernameStmt, 'first_login');
                $isTemporary = oci_result($usernameStmt, 'is_temporary');
            }
            oci_free_statement($usernameStmt);
            if(checkLockoutStatus($connObj, $username) !== NULL) {
                oci_close($connObj);
                exit;
            }

            if($usr == $username) {
                if(verifyPassword($username,$password)) {
                    oci_close($connObj);
                    // they are a new user, so ask them for info to put into the database
                    if($newUser == "Y") {
                        // return to regular login page after this
                        emplInfoForm($username);
                    }   // end of if for the create new account page (webpage 2.1)
                    elseif($isTemporary == "Y") {
                        newPasswordForm($username);
                    }
                    // user is a current user and not a new user, so give them form to enter password to log in
                    else {
                        //homepage
                    }
                }   // end of if for the returning user login page (webpage 2.2)
                else {
                    // the password was incorrect, so increment the failed attempts in the database
                    // and send them back to the login page with message of attempts
                    incrementFailedAttempts($connObj, $username);
                    // close the connection
                    oci_close($connObj);
                }
            } 
            else {
                // the user does not have an account.
                // free the statement & close the connection
                oci_close($connObj);
                
                ?>
                <h1 id="notfoundheader">Incorrect information</h1>
                <p id="notfoundmessage">If you need assistance, please contact the IT admin.</p>
                
                <a href="https://nrs-projects.humboldt.edu/~crb119/Unique_Builders/php/login_start.php">Try again </a>
                
                <?php
            }
        } else {
            // Redirect back to the login page
            header("Location: https://nrs-projects.humboldt.edu/~crb119/Unique_Builders/php/login_start.php");
            exit;
        }

    ?>

</body>
</html>