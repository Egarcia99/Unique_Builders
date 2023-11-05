<?php
    /*=====
        function: createEmplAct():
        purpose: expects empl info from the empl info form 
                 then input the information into the database for
                 expected username

        by: Colton Boyd, Gracie Ceja
        last modified: 2023-11-04
    =====*/
    require_once("login_password.php");
?>
<?php
    function createEmplAct($empl_id)
    {
        $firstName = strip_tags($_POST["firstname"]);
        $lastName = strip_tags($_POST["lastname"]);
        $email = strip_tags($_POST["email"]);
        $phoneNum = strip_tags($_POST["phoneNum"]);
        $passWord = password_hash($_POST["password"], PASSWORD_BCRYPT);
        
        $dbConnStr = "(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)
                                                  (HOST = cedar.humboldt.edu)
                                                  (PORT = 1521))
                                                  (CONNECT_DATA = (SID = STUDENT)))";   // this must be changed to info of DB for out project
        // connection object
        $connObj = oci_connect($conn1Username, $conn1Password, $dbConnStr);
        require_once("database_connect.php");
        //$connObj = db_conn_sess();
        /*==============
            db connection for when we have it setup
        ==================*/
        $emplUpdateString = "UPDATE Employee 
            SET empl_first_name = :firstname,
                empl_last_name = :lastname,
                empl_password = :emplpass,
                email = :email,
                phone_number = :phone
            WHERE empl_id = :username";

        $emplUpdateStmt = oci_parse($connObj, $emplUpdateString);
        oci_bind_by_name($emplUpdateStmt, ":firstname", $firsName);
        oci_bind_by_name($emplUpdateStmt, ":emplpass", $passWord);
        oci_bind_by_name($emplUpdateStmt, ":email", $email);
        oci_bind_by_name($emplUpdateStmt, ":phone", $phoneNum);
        oci_bind_by_name($emplUpdateStmt, ":username", $empl_id);

        oci_execute($emplUpdateStmt, OCI_DEFAULT);

        oci_free_statement($emplUpdateStmt);
        oci_close($connObj);

    }