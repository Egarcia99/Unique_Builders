<?php
/*
    file: user_lockout_functs.php
    by: Colton Boyd, Emilyo Garcia, & Gracie Ceja
    last modified: November 25, 2023

    This file contains some php functions for locking out users from logging in.
*/

function incrementFailedAttempts($connObj, $username) {
    // Check if the user exists in the UserLockout table
    $checkUserQuery = "SELECT * FROM UserLockout WHERE username = :username";
    $checkUserStmt = oci_parse($connObj, $checkUserQuery);
    oci_bind_by_name($checkUserStmt, ":username", $username);
    oci_execute($checkUserStmt);

    $userExists = oci_fetch_assoc($checkUserStmt);

    // Free the statement
    oci_free_statement($checkUserStmt);

    if ($userExists) 
    {
        // User exists, update the UserLockout table to increment failed login attempts
        $updateLockoutQuery = "UPDATE UserLockout 
                               SET failed_attempts = failed_attempts + 1 
                               WHERE username = :username";
    } 
    else 
    {
        // User does not exist, insert a new record into the UserLockout table
        $updateLockoutQuery = "INSERT INTO UserLockout (username, lockout_time, failed_attempts) 
                               VALUES (:username, CURRENT_TIMESTAMP, 1)";
    }

    $updateLockoutStmt = oci_parse($connObj, $updateLockoutQuery);
    oci_bind_by_name($updateLockoutStmt, ":username", $username);
    oci_execute($updateLockoutStmt);

    // Commit the changes
    //oci_commit($connObj);

    // Check if the user has reached the maximum number of failed attempts, and lock the account if necessary
    $maxAttempts = 5; // Adjust this value based on your security policy
    if (getFailedAttempts($connObj, $username) >= $maxAttempts) {
        lockoutAccount($connObj, $username);
        exit;
    }

    $attempts = getFailedAttempts($connObj, $username);
    
    // the user is not logged in
    $_SESSION["logged_in"] = "F";
    
    ?>
    <h1 id="notpassword">Login Failed</h1>
    <!-- Nav bar adapted from homepage -->
    <nav>
        <ul class="nav">
            <li><a href="../html/homepage.html">Home</a></li>
            <li><a href="../php/login_start.php">Employee Login</a></li>
            <li><a href="../php/cust_contact.php">Contact Us</a></li>
        </ul>
    </nav>

    <p id="notpasswordmessage">Incorrect Password. Attempts left: <?php echo 5-$attempts; ?>.
    <a href="../php/login_start.php">Try again</a></p>
    <?php

    // Free the statement
    oci_free_statement($updateLockoutStmt);
}


function getFailedAttempts($connObj, $username) {
    // Get the current number of failed attempts from the UserLockout table
    $getAttemptsQuery = "SELECT failed_attempts 
                         FROM UserLockout 
                         WHERE username = :username";
    $getAttemptsStmt = oci_parse($connObj, $getAttemptsQuery);
    oci_bind_by_name($getAttemptsStmt, ":username", $username);
    oci_execute($getAttemptsStmt);
    
    if(oci_fetch($getAttemptsStmt)) {
        $failedAttempts = oci_result($getAttemptsStmt, 1);
    }
    else {
        $failedAttempts = 0;
    }

    // Free the statement
    oci_free_statement($getAttemptsStmt);

    return $failedAttempts;
}

function lockoutAccount($connObj, $username) {
    // Lock the account by setting unlock_time to lockout_time + 24 hours in database
    
    // Update the UserLockout table
    $lockoutQuery = "UPDATE UserLockout 
                     SET lockout_time = CURRENT_TIMESTAMP
                     WHERE username = :username";
    
    $lockoutStmt = oci_parse($connObj, $lockoutQuery);
    oci_bind_by_name($lockoutStmt, ":username", $username);
    oci_bind_by_name($lockoutStmt, ":unlockTime", $unlockTime);
    oci_execute($lockoutStmt);
    // Commit the changes
    //oci_commit($connObj);

    // the user is not logged in
    $_SESSION["logged_in"] = "F";
    ?>
    <h1 id="actlocked">Account Locked</h1>
    <!-- Nav bar adapted from homepage -->
    <nav>
        <ul class="nav">
            <li><a href="../html/homepage.html">Home</a></li>
            <li><a href="../php/login_start.php">Employee Login</a></li>
            <li><a href="../php/cust_contact.php">Contact Us</a></li>
        </ul>
    </nav>

    <p id="actlockedmessage">This account is temporarily locked. Please try again after 24 hours.</p>
    <?php

    // Free the statement
    oci_free_statement($lockoutStmt);
}


function checkLockoutStatus($connObj, $username) {
    $checkLockoutQuery = "SELECT TO_CHAR(unlock_time, 'Mon-DD-RR HH:MI') AS formatted_time,
                                  TO_CHAR(unlock_time, 'AM') AS am_pm
                          FROM UserLockout 
                          WHERE username = :username AND unlock_time > SYSDATE";
    $checkLockoutStmt = oci_parse($connObj, $checkLockoutQuery);
    oci_bind_by_name($checkLockoutStmt, ":username", $username);
    oci_execute($checkLockoutStmt);

    if (oci_fetch($checkLockoutStmt)) {
        // Account is locked out
        $formattedTime = oci_result($checkLockoutStmt, 'FORMATTED_TIME');
        $amPm = oci_result($checkLockoutStmt, 'AM_PM');
            
        // the user is not logged in
        $_SESSION["logged_in"] = "F";

        ?>
        <h1 id="notfoundheader">Account Locked</h1>
        <!-- Nav bar adapted from homepage -->
        <nav>
            <ul class="nav">
                <li><a href="../html/homepage.html">Home</a></li>
                <li><a href="../php/login_start.php">Employee Login</a></li>
                <li><a href="../php/cust_contact.php">Contact Us</a></li>
            </ul>
        </nav>

        <p id="notfoundmessage">This account is temporarily locked. Please try again after <?php echo $formattedTime; echo ' ' . $amPm; ?>.</p>
        <?php
        return $formattedTime;
    }

    return null; // Account is not locked out
}

?>