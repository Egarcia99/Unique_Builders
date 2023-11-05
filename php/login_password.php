<?php
    session_start();
?>

<?php
    require_once("user_info_input.php");
?>
<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">

<!-- cs328 class HTML template: last modified 2023-02-22 -->

<!--
    adapted from: CS 328 hw7 problem2
    by: Gracie Ceja
    last modified: November 4, 2023

    you can run this using the URL: https://nrs-projects.humboldt.edu/~glc47/cs458/loginTesting/login_password.php
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
        /*  
        webpage 2.0 (displays either webpage 2.1 or webpage 2.2):
        user has attempted to login with username but not password yet
        */

        // next step: check if they are new or returning user, to determine the next state

        // connection section adapted from cs328 hw7 problem1
        // get username from form
        $username = strip_tags($_POST["username"]);
        // put username into session variable to use again later to recconnect
        $_SESSION["username"] = $username;

        // use account that can only see usernames (not an actual account on nrs-projects)
        $conn1Username = "SeeUsers";
        $conn1Password = "SecretPassword42";


        // set up db connection string
        $dbConnStr = "(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)
                                                  (HOST = cedar.humboldt.edu)
                                                  (PORT = 1521))
                                                  (CONNECT_DATA = (SID = STUDENT)))";   // this must be changed to info of DB for out project
        // connection object
        $connObj = oci_connect($conn1Username, $conn1Password, $dbConnStr);
        require_once("database_connect.php");
        //$connObj = db_conn_sess();
        /*==============
            db connection for when we have it setup
        ==================*/
        // check if the entered username exists in the database already or no.
        // set up query string & statement
        $usernameQueryString = "SELECT empl_id empl_password
                                FROM Employee
                                WHERE empl_id = :username";
        $usernameStmt = oci_parse($connObj, $usernameQueryString);
        oci_bind_by_name($usernameStmt, ":username", $username);

        // execute statement & get info from it
        oci_execute($usernameStmt, OCI_DEFAULT);
        
        // loop through usernames until username is found or all usernames have been checked
        $newUser = false;
        $currentUser = false;
        while(oci_fetch($usernameStmt)){
            $usr = oci_result($usernameStmt, 1); // get next username from database
            $passWord = oci_result($usernameStmt,2);
            if($usr == $username){
                // this means the user currently has an account.
                $currentUser = true;
                if($passWord == NULL)
                {
                    $newUser = true;    
                }
            }
        }

        // free the statement & close the connection
        oci_free_statement($usernameStmt);
        oci_close($connObj);

        // 2 possible webpage states in webpage 2: webpage 2.1 for new users, webpage 2.2 for returning users

        // webpage 2.1, for new users: username is not in system, load page to create new account
        // (the thing about testpasswordlogin is so I can test the other page. remove it once it is no longer neccessary)
        if($currentUser == true && $newUser == true)
        {
            // return to regular login page after this
    
            ?>
 
            <!-- Personalized header because they entered their username -->
            <h1 id="welcomeheader">Welcome <?= $username ?></h1>

            <!-- log in form adapted from hw4 of cs328 -->
            <form method="post" action="https://nrs-projects.humboldt.edu/~glc47/cs458/loginTesting/login_username.php" onsubmit="return validateForm();">
                <h2 id="instructionheader">Please Provide Further Information Below</h2>

                <input type="text" name="firstname" class="rectangleinput" placeholder="First name" required="required" />
                <input type="text" name="lastname" class="rectangleinput" placeholder="Last name" required="required" />
                <input type="email" name="email" class="rectangleinput" placeholder="Email Address" required="required" />
                <input type="text" name="phoneNum" class="rectangleinput" placeholder="Phone Number" required="required" />
                <input type="password" name="password" class="rectangleinput" placeholder="Password" required="required" />
                <input type="password" name="confirmPassword" class="rectangleinput" placeholder="Confirm Password" required="required" />

                <input type="submit" name="submit" value="Submit" />
            </form> 
            <script src="empl_info_val.js"></script>
            
            <?php
            createEmplAct($username);
            $newUser = false;
        }   // end of if for the create new account page (webpage 2.1)
        // webpage 2.2: username is in system, load page to login (enter password)
        elseif($currentUser == true && $newUser == false)
        {
            // next stage: 4.0 (logging in to database)
            // initialize these to prepare for next stage
            $_SESSION["badPasswordAttempts"] = 0;
            $_SESSION["locked_out"] = false;
    
            ?>

            <!-- Personalized header because they entered their username -->
            <h1 id="welcomeheader">Welcome <?= $username ?></h1>

            <!-- log in form adapted from hw4 of cs328 -->
            <form method="post" action="https://nrs-projects.humboldt.edu/~glc47/cs458/loginTesting/login_empl.php">
                <h2 id="instructionheader">Please Enter Your Password Below</h2>

                <input type="password" name="password" class="roundedinput" required="required" />

                <p><a href="https://nrs-projects.humboldt.edu/~glc47/cs458/loginTesting/forgot_password.php" id="forgotpasswordlink">Forgot Password?</a></p>

                <input type="submit" name="submit" value="Submit" />
            </form>

            <?php
        }   // end of else for the login (enter password) page
        else
        {
            ?>
            <h1 id="notfoundheader">Employee Not Found</h1>
            <p id="notfoundmessage">The employee you are trying to log in as does not exist. If you need assistance, please contact the IT admin.</p>
            <?php
            header("Location: https://nrs-projects.humboldt.edu/~glc47/cs458/loginTesting/login_username.php");
            exit;
        }

    ?>
    
</body>
</html>