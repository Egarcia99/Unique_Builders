<?php
    /*=====

        file: verify_password.php
        // 
        by: Colton Boyd
        last modified: 2023-04-21
    =====*/

?>
<?php
    function  verifyPassword($username, $password)
    {
        require_once("../../../private/database_connect.php");
        $connObj = db_conn_sess();
        
        $passwordQueryString = "SELECT empl_password
                                FROM Employee
                                WHERE empl_id = :username";
        $passwordStmt = oci_parse($connObj, $passwordQueryString);
        oci_bind_by_name($passwordStmt, ":username", $username);
        oci_execute($passwordStmt, OCI_DEFAULT);

        if(oci_fetch($passwordStmt))
        {
            $storedPass = oci_result($passwordStmt, 1);
            if(password_verify($password, $storedPass))
            {
                return true;
            }
            else
            {
                return false;
            }
        }
        else
        {
            // this means the user currently has an account.
            return false;
        }
        
        oci_free_statement($passwordStmt);
        oci_close($connObj);
        
    }
?>