<?php
/*
    by: Gracie Ceja & Emilyo Garcia & Colton Boyd
    last modified: November 28, 2023

    you can run this using the URL: https://nrs-projects.humboldt.edu/~glc47/public_html/Unique_Builders-main/php/forgot_password.php
    CS 458 Software Engineering
    Semester Project: Unique Builders Company Website & Database
    Team: Tech Titans
    Fall 2023
    Employeee Login: Forgot Password
    Requirements: 2.1 & 2.2
*/
    require_once("redirect_user.php");
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

        <!-- Variables for the following JS script -->
        <!-- js for checking if the form info is correct -->
        <script defer src="../js/validate_contact_info.js" type="text/javascript"></script>
        
    </head>
    <?php
     
     
     if($_SERVER['REQUEST_METHOD'] === "GET")
     {
        ?>
        <h1 id="welcomeheader">Welcome</h1>
        <nav>
            <ul class="nav">
                <li><a href="../html/homepage.html">Home</a></li>
                <li><a href="../php/login_start.php">Employee Login</a></li>
                <li><a href="../php/cust_contact.php">Contact Us</a></li>
            </ul>
        </nav>

        <form method="post" action="">
            <h2 id="instructionheader">Please Enter Username</h2>

            <label for="username">Username:</label>
            <input type="text" id="username" name="username" class="roundedinput" required="required" />
            <input type="submit" value="Submit" />
        </form>
        <?php
        
     }
    else
    {

        // first, get contact info so the js can check if the user enters the correct contact info
        // get username from session variable
        $username = strip_tags($_POST["username"]);
        
        // first, connect to database to get their contact info 
        // use account that can only see usernames & contact info (not an actual account on nrs-projects)
        // set up db connection 
        require_once("../../../private/database_connect.php");
        $connObj = dbConnSess();

        /*==============
            db connection for when we have it setup
        ==================*/

        // check if the entered username exists in the database already or no.
        // set up query string & statement
        $contactInfoQueryString = "SELECT empl_id , email, phone_number, first_login, is_temporary
                                    FROM Employee
                                    where empl_id = :username";
        $contactInfoStmt = oci_parse($connObj, $contactInfoQueryString);
        oci_bind_by_name($contactInfoStmt, ":username", $username);

        // execute statement & get info from it
        oci_execute($contactInfoStmt, OCI_DEFAULT);
        $usr = NULL;
        // loop through usernames until username is found or all usernames have been checked
        while(oci_fetch($contactInfoStmt))
        {
            $usr = oci_result($contactInfoStmt, 1);  // get next username from database
                // get user's contact info
            $email = oci_result($contactInfoStmt, 2);
            $phoneNum = oci_result($contactInfoStmt, 3);
            //if a new user not allowed to reset password.
            $newUser = oci_result($contactInfoStmt,4);
            //already requested a new password.
            $isTemporary= oci_result($contactInfoStmt,5);
        
        }
        // free the statement & close the connection
        oci_free_statement($contactInfoStmt);
        oci_close($connObj);
        if($usr == $username)
        {
            if($newUser == "Y")
            {
                
                ?>  
                    <h1 id="invalidEntryheader">Invalid Entry</h1>
                    <p id="invalidEntrymessage">First time user not allowed. If you need assistance, please contact the IT admin.</p>
                <?php
                    redirect("../php/forgot_password.php");
            }
            elseif($isTemporary == "Y")
            {
                ?>  
                    <<form method="post" action="../php/forgot_password.php" id="goToForgotPassword">
                <table class="infoTable">
                    <tr> <td style="color:white;" >Hello <?= $username ?></td> </tr>
                    <tr> <td style="color:white;">We could not send the admin an email 
                        to help you get a temporary password at this time.</td> </tr>
                </table>
                </form>
                <?php
                    redirect("../php/forgot_password.php");
            }
            else
            {
                ?>
                <body>
                        <?php
                            echo $phoneNum
                        ?>

                        <!-- Personalized header because they entered their username -->
                        <h1 id="welcomeheader">Welcome <?= $username ?></h1>
                        <!-- Nav bar adapted from homepage -->
                        <nav>
                            <ul class="nav">
                                <li><a href="../html/homepage.html">Home</a></li>
                                <li><a href="../php/login_start.php">Employee Login</a></li>
                                <li><a href="../php/cust_contact.php">Contact Us</a></li>
                            </ul>
                        </nav>

                        <form method="post" id="contactInfoForm" action="../php/inform_user.php" onsubmit="return correctInfo('<?=$email?>', '<?=$phoneNum?>')">
                            <h2 id="instructionheader">Please Provide Needed Information Below</h2>
                            <input type="hidden" name="username" value="<?= $username ?>">

                            <label for="enteredEmail">Email:</label>
                            <input type="email" id="enteredEmail" name="emailForgotPassword" class="rectangleinput" placeholder="Confirm Email Address" />

                            <p id="or">Or</p>

                            <label for="enteredPhoneNum">Phone Number:</label>
                            <input type="text" id="enteredPhoneNum" name="phoneNumForgotPassword" class="rectangleinput" placeholder="Confirm Phone Number" />
                            
                            <div id="error-message" style="color: red; padding-bottom: 1em;"></div>

                            <input type="submit" id="submit" value="Submit" />
                        </form> 

                </body>
                <?php
            }
        }
        else
        {
            ?>
            <h1 id="notfoundheader">Incorrect information</h1>
            <p id="notfoundmessage">If you need assistance, please contact the IT admin.</p>
                
            
        <?php
            redirect("../php/forgot_password.php");
        }
        ?>
    </html>
    <?php
    }   // end of else for when the form was submitted
    ?>