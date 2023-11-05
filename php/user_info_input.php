<?php
    /*=====
        function: passWordForm: string -> void
        purpose: expects a password and submits the password to be checked
        if it matches the hashed and salted password in the database to the 
        associated user.

        by: Colton Boyd, Gracie Ceja
        last modified: 2023-11-04
    =====*/
    require_once("login_password.php");
?>
<?php
    function createEmplAct()
    {
        $firstname = strip_tags($_POST["firstname"]);
        $lastname = strip_tags($_POST["lastname"]);
        $email = strip_tags($_POST["email"]);
        $phoneNum = strip_tags($_POST["phoneNum"]);
        $password = password_hash($_POST["password"], PASSWORD_BCRYPT);
        
        $dbConnStr = "(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)
                                                  (HOST = cedar.humboldt.edu)
                                                  (PORT = 1521))
                                                  (CONNECT_DATA = (SID = STUDENT)))";   // this must be changed to info of DB for out project
        // connection object
        $connObj = oci_connect($conn1Username, $conn1Password, $dbConnStr);
        
        if (!$connObj) {
            die("Connection failed: " . $conn->connect_error);
        }
        $emplUpdateString = "UPDATE Employee 
            SET empl_first_name = :firstname,
                empl_last_name = :lastname,
                empl_password = :emplpass,
                email = :email,
                phone_number = :phone
            WHERE empl_id = :username";

        $emplUpdateStmt = oci_parse($connObj, $emplUpdateString);
        oci_bind_by_name($emplUpdateStmt, ":firstname", $firstname);
        oci_bind_by_name($emplUpdateStmt, ":lastname", $lastname);
        oci_bind_by_name($emplUpdateStmt, ":emplpass", $password);
        oci_bind_by_name($emplUpdateStmt, ":email", $email);
        oci_bind_by_name($emplUpdateStmt, ":phone", $phoneNum);
        oci_bind_by_name($emplUpdateStmt, ":username", $username);

        oci_execute($emplUpdateStmt, OCI_DEFAULT);

        oci_free_statement($emplUpdateStmt);
        oci_close($connObj);

    }