<?php
    /*=====
   
       file: new_password.php
        this file take the input from form on new_password.php 
        and updates the empl_id password in the datebase
        for their new password.
       
       by: Colton Boyd, Gracie Ceja, & Emilyo Garcia
       last modified: 2023-12-6
   =====*/
   
    session_start();
    require_once("empl_homepage.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") 
{
    
    $empl_id = $_SESSION["username"];
    $newPassword = password_hash($_POST["newPassword"], PASSWORD_BCRYPT);
    // connection object
    //$connObj = oci_connect($conn1Username, $conn1Password, $dbConnStr);
    require_once("../../../private/database_connect.php");
    $connObj = dbConnSess();

    /*==============
        db connection for when we have it setup
    ==================*/
    $passwordUpdateQuery = "UPDATE Employee 
                            SET empl_password = :emplpass,
                                is_temporary = 'N'
                            WHERE empl_id = :username";

    $passwordUpdateStmt = oci_parse($connObj, $passwordUpdateQuery);
    oci_bind_by_name($passwordUpdateStmt, ":username", $empl_id);
    oci_bind_by_name($passwordUpdateStmt, ":emplpass", $newPassword);
    oci_execute($passwordUpdateStmt, OCI_DEFAULT);
    oci_commit($connObj); //testing purposes don't want on 
    oci_free_statement($passwordUpdateStmt);

    oci_close($connObj);
    
    // the user is logged in
    $_SESSION["logged_in"] = "T";
    // take them to the employee homepage
    emplHomepage($empl_id);
}

?>