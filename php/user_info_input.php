<?php
    /*=====
        need a description here
    =====*/
    session_start();
    require_once("empl_handling.php");
?>
<?php
   
    {
        $firstName = strip_tags($_POST["firstname"]);
        $lastName = strip_tags($_POST["lastname"]);
        $email = strip_tags($_POST["email"]);
        $phoneNum = strip_tags($_POST["phoneNum"]);
        $empl_id = $_SESSION["username"];
        $passWord = password_hash($_POST["password"], PASSWORD_BCRYPT);
        
        // connection object
        //$connObj = oci_connect($conn1Username, $conn1Password, $dbConnStr);
        require_once("../../../private/database_connect.php");
        $connObj = db_conn_sess();
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
        oci_bind_by_name($emplUpdateStmt, ":firstname", $firstName);
        oci_bind_by_name($emplUpdateStmt, ":lastname", $lastName);
        oci_bind_by_name($emplUpdateStmt, ":emplpass", $passWord);
        oci_bind_by_name($emplUpdateStmt, ":email", $email);
        oci_bind_by_name($emplUpdateStmt, ":phone", $phoneNum);
        oci_bind_by_name($emplUpdateStmt, ":username", $empl_id);

        oci_execute($emplUpdateStmt, OCI_DEFAULT);
        //oci_commit($connObj); testing purposes don't want on 
        oci_free_statement($emplUpdateStmt);

        oci_close($connObj);
        emplHandling();

        // ... remaining code ...
    }