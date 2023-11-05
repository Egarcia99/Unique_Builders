<?php
    /*-----
        function: db_conn_sess: string string -> connection
        purpose: expects an Oracle username and password,
            and has the side-effect of trying to connect to
            Oracle s database with the given
            username and password;
            returns the resulting connection object if
            successful, 
            BUT if not, it:
            *   complains, including a "try again" link to the
                calling document, 
            *   ends the document,
            *   destroys the current session, and
            *   exits the calling PHP
        last modified: 2023-11-04
    -----*/

        function db_conn_sess()
        {
            // set up db connection string

            $host = "cedar.humboldt.edu"; // The host where Oracle database is running
            $port = 1521; // The port for Oracle database
            $sid = "STUDENT"; // The Oracle service name
            $db_username = "your_username"; // Your Oracle username
            $db_password = "your_password"; // Your Oracle password

            $db_conn_str = 
            "(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)
                                        (HOST = $host)
                                        (PORT = $port))
                            (CONNECT_DATA = (SID = $sid)))";

            // Establish the Oracle database connection
            $connection = oci_connect($db_username, $db_password, $db_conn_str);

            if (!$connection) {
                $error = oci_error();
                die("Oracle Connection failed: " . $error['message']);
            }

        }
        
?>