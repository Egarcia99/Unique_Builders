<?php

/*
    by: Gracie Ceja and Colton Boyd
    last modified: November 5, 2023

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
            }   // end of function for the login (enter password) page     
    ?>