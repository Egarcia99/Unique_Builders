<?php
/*
    by: Gracie Ceja and Colton Boyd
    last modified: November 21, 2023

    CS 458 Software Engineering
    Semester Project: Unique Builders Company Website & Database
    Team: Tech Titans
    Fall 2023
    Employeee Login: Enter Password
    Requirements: 2.1 & 2.2

    This file creates a form for an employee to enter their password so they can log in to the website.
*/

    function emplHandling()
    {
        // webpage 2.2: username is in system, load page to login (enter password)
        
        // next stage: 4.0 (logging in to database)
        // initialize these to prepare for next stage
        $_SESSION["badPasswordAttempts"] = 0;
        $_SESSION["locked_out"] = false;
        $username = $_SESSION["username"];
        require_once("password_form.php");
        passwordForm($username);
                
    }   // end of function for the login (enter password) page     
?>