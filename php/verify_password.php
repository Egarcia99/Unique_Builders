<?php
    /*=====

        file: verify_password.php
        this file check either the password enter by a new user 
        and existing user matches password stored for the user(employee)

        by: Colton Boyd
        last modified: 2023-12-6
    =====*/

?>
<?php
    function  verifyPassword($username, $password)
    {
        require_once("../../../private/database_connect.php");
        $connObj = dbConnSess();

        
        $passwordQueryString = "SELECT empl_password, first_login
                                FROM Employee
                                WHERE empl_id = :username";
        $passwordStmt = oci_parse($connObj, $passwordQueryString);
        oci_bind_by_name($passwordStmt, ":username", $username);
        oci_execute($passwordStmt, OCI_DEFAULT);
        $verified = false;
        if (!$passwordStmt) {
            // Log the error for debugging purposes (do not expose detailed errors to users)
            $error = oci_error($connObj);
            error_log("Error executing statement: " . $error['message']);
            // Display a more specific error message
            echo "An error occurred while processing your request. Please try again later.";
            return false; // Return false to indicate failure
        }
        
        if(oci_fetch($passwordStmt))
        {   
            $storedPass = oci_result($passwordStmt, 1);
            $firstLogin = oci_result($passwordStmt, 2);
            if($firstLogin == "Y" && $password == $storedPass)
            {
                $verified = true;
            }
            elseif(password_verify($password, $storedPass))
            {
                $verified = true;
            }
            else
            {   
                $verified = false;
            }
        }
        else
        {   
            $verified = false;
        }
        oci_free_statement($passwordStmt);
        oci_close($connObj);
        return $verified;
        
    }
?>