<?php
    /*
    by: Colton Boyd
    last modified: December 6, 2023

    you can run this using the URL: https://nrs-projects.humboldt.edu/~glc47/cs458/loginTesting/login_empl.php
    CS 458 Software Engineering
    Semester Project: Unique Builders Company Website & Database
    Team: Tech Titans
    Fall 2023
    Employeee Login: Make New Account
    Requirement: 2.1 Employee Login

    This file adds a password and contact info for a new user to the database.
    Then, it redirects them to the employee login page so they can login with their password.
    */
    session_start();
    require_once("empl_homepage.php");
?>
<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") 
{
    $email = strip_tags($_POST["email"]);
    $phoneNum = strip_tags($_POST["phoneNum"]);
    $emplID = $_SESSION["username"];
    $password = password_hash($_POST["password"], PASSWORD_BCRYPT);

    // connection object
    //$connObj = oci_connect($conn1Username, $conn1Password, $dbConnStr);
    require_once("../../../private/database_connect.php");
    $connObj = dbConnSess();

    /*==============
        db connection for when we have it setup
    ==================*/
    $emplUpdateString = "UPDATE Employee 
        SET empl_password = :emplpass,
            email = :email,
            phone_number = :phone,
            first_login = 'N'
        WHERE empl_id = :username";

    $emplUpdateStmt = oci_parse($connObj, $emplUpdateString);

    oci_bind_by_name($emplUpdateStmt, ":emplpass", $password);
    oci_bind_by_name($emplUpdateStmt, ":email", $email);
    oci_bind_by_name($emplUpdateStmt, ":phone", $phoneNum);
    oci_bind_by_name($emplUpdateStmt, ":username", $emplID);

    oci_execute($emplUpdateStmt, OCI_DEFAULT);
    if (!$emplUpdateStmt) 
    {
        // Log the error for debugging purposes (do not expose detailed errors to users)
        $error = oci_error($emplUpdateStmt);
        error_log("Error executing statement: " . $error['message']);
        // Display a more specific error message
        echo "An error occurred while processing your request. Please try again later.";
        oci_free_statement($emplUpdateStmt);
        oci_close($connObj);
        exit;
    }

    oci_commit($connObj);// testing purposes don't want on 
    oci_free_statement($emplUpdateStmt);

    oci_close($connObj);
    
    // the user is logged in
    $_SESSION["logged_in"] = "T";
    // take them to the employee homepage
    emplHomepage($emplID);
}
else
{
    header("Location: ../php/login_start.php");
}
