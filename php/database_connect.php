<?php
    /*-----
		adapted from cs328 file by Sharon Tuttle
        modified by: Colton Boyd and Gracie Ceja

        function: db_conn_sess: void -> connection
        purpose: tries to connect to
            Oracle's database with the given
            username and password;
            returns the resulting connection object if
            successful, 
            But, if not, it:
            *   complains, including a "try again" link to the
                calling document, 
            *   ends the document,
            *   destroys the current session, and
            *   exits the calling PHP

       last modified: 2023-12-06
    -----*/

        function dbConnSess()
        {
            // set up db connection string
            // first, declare variables for the connection (must use an actual username and password for it to work)
            $host = "cedar.humboldt.edu"; // The host where Oracle database is running
            $port = 1521; // The port for Oracle database
            $sid = "STUDENT"; // The Oracle service name
            $dbUsername = "your_username"; // Your Oracle username
            $dbPassword = "your_password"; // Your Oracle password

            $dbConnStr = 
            "(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)
                                        (HOST = " . $host . ")
                                        (PORT = " . $port . "))
                            (CONNECT_DATA = (SID = " . $sid . ")))";

            // Establish the Oracle database connection
            $connection = oci_connect($dbUsername, $dbPassword, $dbConnStr);

            if (!$connection) {
                $error = oci_error();
                die("Oracle Connection failed: " . $error['message']);
            }
            return $connection;
        }   // end of function db_conn_sess
        
?>