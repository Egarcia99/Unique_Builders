
<?php
    session_start();
?>


<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">

<!-- cs328 class HTML template: last modified 2023-02-22 -->

<!--
    adapted from: cs328 hw7 problem2
    by: Gracie Ceja
    last modified: October 19, 2023

    you can run this using the URL: https://nrs-projects.humboldt.edu/~glc47/cs458/prototype-sprint3/login-demo.php

    CS 458 Software Engineering
    Semester Project: Unique Builders Company Website & Database
    Team: Tech Titans
    Fall 2023
    Prototype/Demo of Employeee Login
    Requirements: 2.1 & 2.2
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
    <link href="css/login.css" type="text/css" rel="stylesheet" />

</head>
<body>
    <?php
    /* This webpage displays all the various pages of login (such as enter username & forgot password)
        as different stages:
        stage 1.0 for entering username
        stage 2.0 for entering password:
            stage 2.1 for new users to also enter more info
            stage 2.2 for returning users to just enter password or select forgot password
        stage 3.0 for forgot password
            stage 3.1 for entering contact info to request password reset from admin
            stage 3.2 to inform the user that their info was sent to an admin
            stage 3.3 for them to login wit ha temporary password & make a new password
        stage 4.0 for trying to log them in to the database
            stage 4.1 correct password, they are lgoged in successfully & go to employee homepage?
            stage 4.2 incorrect password, they are sent back to stage 2.2
            stage 4.3 they got locked out from too many invalid password login attempts (looks like stage 2.2)
    */



    // old stage logic just in case
    // start stage 1.0
    /* if (($_SERVER["REQUEST_METHOD"] == "GET" || ($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_POST["username"])) 
        && $_POST["submit"] != "Forgot Password?")
        && !isset($_POST["emailForgotPassword"]) && !isset($_POST["phoneNumForgotPassword"])) 
    { */
    // start stage 2.0
    // elseif (isset($_POST["username"]) && !isset($_POST["password"]))



    // outer if else block for stages of the webpage
    // stage 1.0:
    // if method is get, the user has not logged in. so, give them the login form (for them to enter their username).

    if($_SERVER["REQUEST_METHOD"] == "GET" || isset($_POST["name"]))
    {
        // this is for later
        $_SESSION["badPasswordAttempts"] = 0;

        // after this, go to stage 2.0
        $_SESSION["stage"] = 2.0;
        ?>    
        <!-- Generic header because they didn't yet enter their username -->
        <h1 id="welcomeheader">Welcome</h1>

        <!-- log in form adapted from hw4 of cs328 -->
        <form method="post" action="https://nrs-projects.humboldt.edu/~glc47/cs458/prototype-sprint3/login-demo.php">
            <h2 id="instructionheader">Please Enter Your Username Below</h2>

            <input type="text" name="username" class="roundedinput" required="required" />

            <input type="submit" name="stage" value="Submit" />
        </form>

        <?php
    }   
    // end if for first state of the page
    // stage 2.0 (displays either stage 2.1 or stage 2.2):
    // user has attempted to login with username but not password yet
    elseif ($_SESSION["stage"] == 2.0)
    {
        // next step: check if they are new or returning user, to determine the next state

        // connection section adapted from hw7 problem1
        // get username from form
        $username = strip_tags($_POST["username"]);
        // put username into session variable to use again later to recconnect
        $_SESSION["username"] = $username;

        // use account that can only see usernames
        $conn1Username = "SeeUsers";
        $conn1Password = "SecretPassword42";


        // set up db connection string
        $dbConnStr = "(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)
                                                  (HOST = cedar.humboldt.edu)
                                                  (PORT = 1521))
                                                  (CONNECT_DATA = (SID = STUDENT)))";   // this must be changed to info of DB for out project
        // connection object
        $connObj = oci_connect($conn1Username, $conn1Password, $dbConnStr);

        // check if the entered username exists in the database already or no.
        // set up query string & statement
        $usernameQueryString = "SELECT :username
                                FROM Employee";
        $usernameStmt = oci_parse($connObj, $usernameQueryString);
        oci_bind_by_name($usernameStmt, ":username", $username);

        // execute statement & get info from it
        oci_execute($usernameStmt, OCI_DEFAULT);
        
        // loop through usernames until username is found or all usernames have been checked
        $currentUser = "FALSE";
        while(oci_fetch($usernameStmt)){
            $usr = oci_result($usernameStmt, 1);  // get next username from database
            if($usr == $username){
                // this means the user currently has an account.
                $currentUser = "TRUE";
                break;
            }
        }

        // free the statement & close the connection
        oci_free_statement($usernameStmt);
        oci_close($connObj);

        // 2 possible webpage states in stage 2: state 2.1 for new users, state 2.2 for returning users

        // state 2.1, for new users: username is not in system, load page to create new account
        // (the thing about testpasswordlogin is so I can test the other page. remove it once it is no longer neccessary)
        if($currentUser = "FALSE" && $username != "testpasswordlogin")
        {
            // return to regular login page after this
            $_SESSION["stage"] = 1.0;
            ?>
            <!-- Personalized header because they entered their username -->
            <h1 id="welcomeheader">Welcome <?= $username ?></h1>

            <!-- log in form adapted from hw4 of cs328 -->
            <form method="post" action="https://nrs-projects.humboldt.edu/~glc47/cs458/prototype-sprint3/login-demo.php">
                <h2 id="instructionheader">Please Provide Further Information Below</h2>

                <input type="text" name="name" class="rectangleinput" placeholder="First and last name or username" required="required" />
                <input type="text" name="email" class="rectangleinput" placeholder="Email Address" required="required" />
                <input type="text" name="phonenum" class="rectangleinput" placeholder="Phone Number" required="required" />
                <input type="password" name="password" class="rectangleinput" placeholder="Password" required="required" />
                <input type="password" name="confirmpassword" class="rectangleinput" placeholder="Confirm Password" required="required" />

                <input type="submit" name="submit" value="Submit" />
            </form> 
            <?php
            /* need to implement a way for this info to get into the database
            it should be emailed to admin so they can manually add the employee.
            idk how tho.
            */
            
            // close session
            unset($_POST["username"]);
            unset($_POST["password"]);
            $_POST["stage1"] = "true";
            session_destroy();

        }   // end of if for the create new account page (stage 2.1)
        // stage 2.2: username is in system, load page to login (enter password)
        else
        {
            // put username into session variable to use again later
            $_SESSION["username"] = $username;
            // next stage: 4.0 (logging in to database)
            $_SESSION["stage"] = 4.0;

            ?>
            <!-- Personalized header because they entered their username -->
            <h1 id="welcomeheader">Welcome <?= $username ?></h1>

            <!-- log in form adapted from hw4 of cs328 -->
            <form method="post" action="https://nrs-projects.humboldt.edu/~glc47/cs458/prototype-sprint3/login-demo.php">
                <h2 id="instructionheader">Please Enter Your Password Below</h2>

                <input type="password" name="password" class="roundedinput" required="required" />
                <input type="submit" name="stage" value="Forgot Password?" id="forgotpassword" />

                <input type="submit" name="submit" value="Submit" />
            </form>
            <?php
        // need to add 2 things: 1. actual login functionality 2. js for inccorect password

        }   // end of else for the login (enter password) page



    }   // end first elseif (stages 2.0, 2.1, 2.2)
    // stage 3.0: forgot password
    elseif ($_POST["stage"] == "Forgot Password?" || $_SESSION["stage"] == 3.2 || $_SESSION["stage"] == 3.3){    
        // get username from session variable
        $username = $_SESSION["username"];
        
        
        // stage 3.1: enter contact info
        if($_SESSION["stage"] != 3.2 && $_SESSION["stage"] != 3.3)
        {
            // next stage
            $_SESSION["stage"] = 3.2;
            ?>
            <!-- Personalized header because they entered their username -->
            <h1 id="welcomeheader">Welcome <?= $username ?></h1>

            <form method="post" action="https://nrs-projects.humboldt.edu/~glc47/cs458/prototype-sprint3/login-demo.php">
                <h2 id="instructionheader">Please Provide Needed Information Below</h2>

                <input type="text" name="emailForgotPassword" class="rectangleinput" placeholder="Confirm Email Address" />

                <p id="or">Or</p>

                <input type="text" name="phoneNumForgotPassword" class="rectangleinput" placeholder="Confirm Phone Number" />

                <input type="submit" name="stage" value="Submit" />
            </form>
            <?php
        }
        // stage 3.2: inform user that info was sent to admin to make new account
        elseif($_SESSION["stage"] == 3.2)
        {
            // next stage
            $_SESSION["stage"] = 3.3;
            ?>
            <!-- Personalized header because they entered their username -->
            <h1 id="welcomeheader">Thank You <?= $username ?></h1>

            <form method="post" action="https://nrs-projects.humboldt.edu/~glc47/cs458/prototype-sprint3/login-demo.php" id="goToLogin">
                <table class="infoTable">
                    <tr> <td>Hello <?= $username ?></td> </tr>
                    <tr> <td>Please be patient as we send you an email or text message 
                        with a temporary password for the next time you want to login.</td> </tr>
                    <tr> <td>Information sent to :
                        <?= $contactInfo ?></td> </tr>
                </table>
                
                <!-- button to go back to login -->
                <input type="submit" name="submit" value="Go back to Login" />
            </form>

            <?php
        }
        // stage 3.3: login with temporary password & make new password
        elseif($_POST["submit"] == "Go back to Login")
        {
            ?>
            <!-- Personalized header because they entered their username -->
            <h1 id="welcomeheader">Welcome <?= $username ?></h1>

            <form method="post" action="https://nrs-projects.humboldt.edu/~glc47/cs458/prototype-sprint3/login-demo.php">
                <h2 id="instructionheader">Please Provide Needed Information Below</h2>

                <input type="text" name="tempPassword" class="rectangleinput" placeholder="Temporary Password" />
                </br>

                <input type="text" name="newPassword" class="rectangleinput" placeholder="New Password" />
                <input type="text" name="confirmPassword" class="rectangleinput" placeholder="Confirm Password" />

                <input type="submit" name="stage" value="Submit" />
            </form>
            <?php
        }
        // stage 3.4: log them in with the temp password & change password. Then go to homepage?
        elseif(isset($_POST["tempPassword"]))
        {
            // update the user's password in the database & log them in


            // connection section adapted from hw7 problem1
            // get username & passwords from form
            $username = strip_tags($_POST["username"]);
            $tempPassword = strip_tags($_POST["tempPassword"]);
            $newPassword = strip_tags($_POST["newPassword"]);
            // put username & password into session variable to use again later to recconnect
            $_SESSION["username"] = $username;
            $_SESSION["password"] = $newPassword;

            // login with temp password to update password
            // set up db connection string
            $dbConnStr = "(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)
                                                    (HOST = cedar.humboldt.edu)
                                                    (PORT = 1521))
                                                    (CONNECT_DATA = (SID = STUDENT)))";   // this must be changed to info of DB for out project
            // connection object
            $connObj = oci_connect($username, $tempPassword, $dbConnStr);


            // update password in database
            // set up query string & statement
            $passwordUpdateString = "UPDATE Employee
                                    SET password = :newPassword
                                    WHERE username = :username";
            $passwordStmt = oci_parse($connObj, $passwordUpdateString);
            oci_bind_by_name($passwordStmt, ":newPassword", $newPassword);
            oci_bind_by_name($passwordStmt, ":username", $username);

            // execute statement, then free it.
            oci_execute($passwordStmt, OCI_DEFAULT);
            oci_free_statement($passwordStmt);

            // commit the change 
            oci_commit($connobj);

            // here should be code to go to the page for when the employee is logged in
            ?>
                <!-- Personalized header because they logged in -->
                <h1 id="welcomeheader">Welcome <?= $username ?></h1>

                <!-- insert Employee homepage here -->
                <p>Employee Homepage</p>
            
            <?php
        }
    }   // end of stage 3 elseif
    // stage 4.0: try to login actually after enter username & password
    elseif($_SESSION["stage"] == 4.0)
    {
        ?>
            <h1>testing header!!! stage 4.0!!! bad attempts = <?= $_SESSION["badPasswordAttempts"] ?> </h1>
        <?php
        // get username from session variable
        $username = $_SESSION["username"];

        // attempt to login

        // connection section adapted from hw7 problem1
        // get username & password from form
        $username = strip_tags($_SESSION["username"]);
        $password = strip_tags($_POST["password"]);
        // put username & password into session variable to use again later to recconnect
        $_SESSION["username"] = $username;
        $_SESSION["password"] = $password;

        // login with username & password
        // set up db connection string
        $dbConnStr = "(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)
                                                (HOST = cedar.humboldt.edu)
                                                (PORT = 1521))
                                                (CONNECT_DATA = (SID = STUDENT)))";   // this must be changed to info of DB for out project
        // connection object
        $connObj = oci_connect($username, $password, $dbConnStr);
           
        // if can't log in, password is bad
        if (! $connobj)
        {
            $_SESSION["badPasswordAttempts"]++;

            // stage 4.3: 
            // timeout because too many inccorect password attempts
            // 5 is just an example value, idk what the limit should be.
            if($_SESSION["badPasswordAttempts"] > 5)
            {
                // close session
                unset($_POST["username"]);
                unset($_POST["password"]);
                $_SESSION["stage"] = 1.0;
                session_destroy();

                ?>
                <!-- Personalized header because they entered their username -->
                <h1 id="welcomeheader">Welcome <?= $username ?></h1>
    
                <!-- log in form adapted from hw4 of cs328 -->
                <form method="get" action="https://nrs-projects.humboldt.edu/~glc47/cs458/prototype-sprint3/login-demo.php">
                    <h2 id="instructionheader">Please Enter Your Password Below</h2>
    
                    <input type="password" name="lockedOut" class="roundedinput" required="required" />
                    <input type="submit" name="timedOut" value="Forgot Password?" id="forgotpassword" />
    
                    <p id="timeoutMessage">
                        You have been Timeout due to too many inaccurate password attempts
                        try again in 24 hours
                    </p>

                    <input type="submit" name="submit" value="Submit" />
                </form>
                <?php
                // should have functionality for them to be locked out but idk how.
            }
            // stage 4.2:
            // don't lock them out yet
            else
            {
                // next stage: 4.0 (logging in to database)
                $_SESSION["stage"] = 4.0;
    
                ?>
                <!-- Personalized header because they entered their username -->
                <h1 id="welcomeheader">Welcome <?= $username ?></h1>
    
                <!-- log in form adapted from hw4 of cs328 -->
                <form method="post" action="https://nrs-projects.humboldt.edu/~glc47/cs458/prototype-sprint3/login-demo.php">
                    <h2 id="instructionheader">Please Enter Your Password Below</h2>
    
                    <input type="password" name="password" class="roundedinput" required="required" />
                    <input type="submit" name="submit" value="Forgot Password?" id="forgotpassword" />


                    <input type="submit" name="submit" value="Submit" />
                </form>
                <?php   
            }


        }   // end of if block for when password is incorrect (stage 4.2 & 4.3)
        // their password is correct & they have logged in succesfully.
        else
        {
            // current stage = 4.1
            $_SESSION["stage"] = 4.1;

            // here should be code to go to the page for when the employee is logged in
            ?>
                <!-- Personalized header because they logged in -->
                <h1 id="welcomeheader">Welcome <?= $username ?></h1>

                <!-- insert Employee homepage here -->
                <p>Employee Homepage</p>
            
            <?php
        }

    } // end of elseif for stage 4.0




    ?>
</body>
</html>
login-demo.php
Displaying login-demo.php.