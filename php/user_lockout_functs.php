<?php
/*
    file: user_lockout_functs.php
    by: Colton Boyd
    last modified: November 21, 2023

    This file contains some php functions for locking out users from logging in.
*/

function incrementFailedAttempts($connObj, $username) 
{
    // Update the UserLockout table to increment failed login attempts
    $updateLockoutQuery = "UPDATE UserLockout 
                           SET failed_attempts = failed_attempts + 1 
                           WHERE username = :username";
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
    ?>
    <h1 id="notpassword">Login Failed</h1>
    <p id="notpasswordmessage">Incorrct Password  Attempts left: <?php echo $attempts; ?>.
    <a href="https://nrs-projects.humboldt.edu/~crb119/Unique_Builders/php/login_username.php">Try again </a></p>
    
    <?php
    // Free the statement
    oci_free_statement($updateLockoutStmt);
} // end of function incrementFailedAttempts()


function getFailedAttempts($connObj, $username) 
{
    // Get the current number of failed attempts from the UserLockout table
    $getAttemptsQuery = "SELECT failed_attempts 
                         FROM UserLockout 
                         WHERE username = :username";
    $getAttemptsStmt = oci_parse($connObj, $getAttemptsQuery);
    oci_bind_by_name($getAttemptsStmt, ":username", $username);
    oci_execute($getAttemptsStmt);

    $failedAttempts = oci_fetch_assoc($getAttemptsStmt)['failed_attempts'];

    // Free the statement
    oci_free_statement($getAttemptsStmt);

    return $failedAttempts;
} // end of function getFailedAttempts()


function lockoutAccount($connObj, $username) 
{
    // Lock the account by setting unlock_time to current time + lockout duration
    $lockoutDurationMinutes = 24 * 60; // 24 hours in minutes
    $unlockTime = date('Y-m-d H:i:s', strtotime("+{$lockoutDurationMinutes} minutes"));
    
    // Update the UserLockout table
    $lockoutQuery = "UPDATE UserLockout 
                     SET unlock_time = TO_TIMESTAMP(:unlockTime, 'YYYY-MM-DD HH24:MI:SS') 
                     WHERE username = :username";
    
    $lockoutStmt = oci_parse($connObj, $lockoutQuery);
    oci_bind_by_name($lockoutStmt, ":username", $username);
    oci_bind_by_name($lockoutStmt, ":unlockTime", $unlockTime);
    oci_execute($lockoutStmt);
    // Commit the changes
    //oci_commit($connObj);

    ?>
    <h1 id="actlocked">Account Locked</h1>
    <p id="actlockedmessage">This account is temporarily locked. Please try again after <?php echo $unlockTime; ?>.</p>
    <?php

    // Free the statement
    oci_free_statement($lockoutStmt);
}   // end of function lockoutAccount()


function checkLockoutStatus($connObj, $username) 
{
    $checkLockoutQuery = "SELECT * 
                          FROM UserLockout 
                          WHERE username = :username AND unlock_time > SYSDATE";
    $checkLockoutStmt = oci_parse($connObj, $checkLockoutQuery);
    oci_bind_by_name($checkLockoutStmt, ":username", $username);
    oci_execute($checkLockoutStmt);

    if ($lockoutRow = oci_fetch_assoc($checkLockoutStmt)) 
    {
        // Account is locked out
        $unlockTime = $lockoutRow['unlock_time'];
        ?>
        <h1 id="notfoundheader">Account Locked</h1>
        <p id="notfoundmessage">This account is temporarily locked. Please try again after <?php echo $unlockTime; ?>.</p>
        <?php
        return $unlockTime;
    }

    return null; // Account is not locked out
}   // end of function checkLockoutStatus()
?>