<?php
    session_start();
            
    // first, get contact info so the js can check if the user enters the correct info
    // get username from session variable
    $username = $_SESSION["username"];
        
    // first, connect to database to get their contact info 
    // use account that can only see usernames & contact info (not an actual account on nrs-projects)
    $conn2Username = "SeeUsersAndContactInfo";
    $conn2Password = "SecretPassword80";


    // set up db connection string
    $dbConnStr = "(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)
                                            (HOST = cedar.humboldt.edu)
                                            (PORT = 1521))
                                            (CONNECT_DATA = (SID = STUDENT)))";   // this must be changed to info of DB for out project
    // connection object
    $connObj = oci_connect($conn2Username, $conn2Password, $dbConnStr);

    // check if the entered username exists in the database already or no.
    // set up query string & statement
    $contactInfoQueryString = "SELECT EMPL_ID, email, phone_number
                                FROM Employee
                                where EMPL_ID = :username";
    $contactInfoStmt = oci_parse($connObj, $contactInfoQueryString);
    oci_bind_by_name($contactInfoStmt, ":username", $username);

    // execute statement & get info from it
    oci_execute($contactInfoStmt, OCI_DEFAULT);
    
    // loop through usernames until username is found or all usernames have been checked
    while(oci_fetch($contactInfoStmt)){
        $usr = oci_result($contactInfoStmt, 1);  // get next username from database
        if($usr == $username){
            // get user's contact info
            $_SESSION["email"] = oci_result($contactInfoStmt, 2);
            $_SESSION["phoneNum"] = oci_result($contactInfoStmt, 3);
            break;
        }
    }

    // free the statement & close the connection
    oci_free_statement($contactInfoStmt);
    oci_close($connObj);
?>

<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">

<!-- cs328 class HTML template: last modified 2023-02-22 -->

<!--
    adapted from: CS 328 hw7 problem2
    by: Gracie Ceja
    last modified: November 4, 2023

    you can run this using the URL: https://nrs-projects.humboldt.edu/~glc47/cs458/loginTesting/forgot_password.php
    CS 458 Software Engineering
    Semester Project: Unique Builders Company Website & Database
    Team: Tech Titans
    Fall 2023
    Employeee Login: Forgot Password
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
        webpage 4.3 they got locked out from too many invalid password login attempts 

    total: 6 files
        
    This file is for: webpage 3.0 forgot password
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
    <link href="../css/login.css" type="text/css" rel="stylesheet" />4


    <!-- Variables for the following JS script -->
    <script type="text/javascript">
        var email = "<?php Print($_SESSION["email"]); ?>";
        var phoneNum = <?php Print($_SESSION["phoneNum"]); ?>;
    </script>

    <!-- js for checking if the form info is correct -->
    <script defer src="../js/validate_contact_info.js" type="text/javascript"></script>


</head>
<body>
        <?php
        // stage 3.0: forgot password  
        // webpage 3.1: enter contact info
        // initialize this to prepare for next page
        $_SESSION["infoSent"] = "False";


        ?>
            <!-- Personalized header because they entered their username -->
            <h1 id="welcomeheader">Welcome <?= $username ?></h1>

            <form method="post" id="contactInfoForm" action="https://nrs-projects.humboldt.edu/~glc47/cs458/loginTesting/inform_user.php">
                <h2 id="instructionheader">Please Provide Needed Information Below</h2>

                <input type="email" name="emailForgotPassword" class="rectangleinput" placeholder="Confirm Email Address" />

                <p id="or">Or</p>

                <input type="test" name="phoneNumForgotPassword" class="rectangleinput" placeholder="Confirm Phone Number" />

                <input type="submit" id="submit" value="Submit" />
            </form> mnn     

</body>
</html>

