<?php
/*
    file: assign_temp_pass.php
    function generateTempPassword creates a random password
    that updates the empl_id(username) in the database and set the is_temporay flag true.
    Then email the I.T admin the username, the temp password and the info to contact the 
    user/employee

    by: Colton Boyd
    last modified: 2023-12-06
*/

function generateTempPassword($username, $contactType, $contactInfo) 
{
    // Define characters that can be used in the temporary password
    $uppercase = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $lowercase = 'abcdefghijklmnopqrstuvwxyz';
    $numbers = '0123456789';
    $specialCharacters = '!@#$%^&*()_-+=<>?';

    // Combine all character sets
    $allCharacters = $uppercase . $lowercase . $numbers . $specialCharacters;

    // Set the length of the temporary password
    $passwordLength = 12;

    // Initialize an empty temporary password
    $tempPassword = '';

    // Ensure at least one special character is included
    $tempPassword .= $specialCharacters[random_int(0, strlen($specialCharacters) - 1)];

    // Generate the remaining part of the temporary password
    for ($i = 1; $i < $passwordLength; $i++) {
        $tempPassword .= $allCharacters[random_int(0, strlen($allCharacters) - 1)];
    }

    // Shuffle the characters to make the password more random
    $tempPassword = str_shuffle($tempPassword);
    

    $storedPassword = password_hash($tempPassword, PASSWORD_BCRYPT);

    require_once("../../../private/database_connect.php");
    $connObj = dbConnSess();

    $passwordQueryString = "UPDATE Employee
                            SET empl_password = :emplpass,
                                is_temporary = 'Y'
                            WHERE empl_id = :username";

    $passwordStmt = oci_parse($connObj, $passwordQueryString);
    oci_bind_by_name($passwordStmt, ":emplpass", $storedPassword);
    oci_bind_by_name($passwordStmt, ":username", $username);
    oci_execute($passwordStmt, OCI_DEFAULT);

   if (oci_execute($passwordStmt, OCI_DEFAULT)) 
   {
        oci_commit($connObj);
        oci_free_statement($passwordStmt);


        // Email content formatting
        $subject = "Password Reset request from user: " . $username;
        $message = "Dear Admin,\n\nThe user " . $username . " has requested a password reset because they forgot their password."
            . "\nPlease send them a temporary password: " . $tempPassword . " at their " . $contactType . ": " . $contactInfo . ".\n\n"
            . "Sincerely,\ninform_user.php in UniqueBuilders.net\n[This email was sent automatically; I cannot read any replies to it.]";

        // Send the email and check for errors
        if (mail("glc47@humboldt.edu", $subject, $message, "From: employeeLogin@UniqueBuilders.co")) 
        {
            echo "Email sent successfully.";
        } else {
            echo "Error sending email.";
        }

    oci_close($connObj);
    } 
    else 
    {
        echo "Error updating password.";
    }
}

?>