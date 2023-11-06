<?php

    // need to add description of what this file does
    ?>
   
    
    <?php
            function emplHandling()
            {
        
                // next step: check if they are new or returning user, to determine the next state
                // 2 possible webpage states in webpage 2: webpage 2.1 for new users, webpage 2.2 for returning users

                // webpage 2.1, for new users: username is not in system, load page to create new account
                // (the thing about testpasswordlogin is so I can test the other page. remove it once it is no longer neccessary)
                
                   // end of if for the create new account page (webpage 2.1)
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
                }   // end of else for the login (enter password) page
                
    ?>