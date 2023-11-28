<?php
/*
    by: Gracie Ceja and Colton Boyd
    last modified: November 24, 2023

    you can run this using the URL: https://nrs-projects.humboldt.edu/~crb119/public_html/CS_458/php/login_password.php
    CS 458 Software Engineering
    Semester Project: Unique Builders Company Website & Database
    Team: Tech Titans
    Fall 2023
    Employeee Login: Enter Password
    Requirements: 2.1 & 2.2
*/

    session_start();
    require_once("login_info_form.php");
    require_once("verify_password.php");
    require_once("user_lockout_functs.php");
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
            $usernameQueryString = "SELECT empl_id, first_login, is_temporary
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
                $usr = oci_result($usernameStmt, 1); // get next username from database
                $newUser = oci_result($usernameStmt, 2);
                $isTemporary = oci_result($usernameStmt, 3);
            }
            oci_free_statement($usernameStmt);
            if(checkLockoutStatus($connObj, $username) !== NULL) {
                oci_close($connObj);
                exit;
            }
            // the username is in the database
            if($usr == $username) 
            {
                // the user entered the correct password
                if(verifyPassword($username,$password)) 
                {
                    // close the connection to the database
                    oci_close($connObj);
                    if($newUser == "Y") 
                    {
                        // they are a new user, so ask them for info to put into the database (create new account page)
                        emplInfoForm($username);
                    } 
                    elseif($isTemporary == "Y") 
                    {
                        // they logged in with temp password, so give them form to make new password
                        newPasswordForm($username);
                    }
                    else {
                        // user is a current user and not a new user, so take them to the employee homepage
                        // the user is logged in
                        $_SESSION["logged_in"] = "T";
                        // take them to the employee homepage
                        emplHomepage($username);
                    }
                }
                else {
                    // the password was incorrect, so increment the failed attempts in the database
                    // and send them back to the login page with message of attempts
                    incrementFailedAttempts($connObj, $username);
                    // close the connection to the database
                    oci_close($connObj);
                }
            } 
            else {
                // the user does not have an account.
                // free the statement & close the connection to the database
                oci_close($connObj);
                
                ?>
                <h1 id="notfoundheader">Incorrect information</h1>
                <p id="notfoundmessage">If you need assistance, please contact the IT admin.</p>
                
                <a href="../php/login_start.php">Try again </a>
                
                <?php
            }
        } 
        else 
        {
            // Redirect back to the login page
            header("Location: ../php/login_start.php");
            exit;
        }

    ?>

</body>
</html>