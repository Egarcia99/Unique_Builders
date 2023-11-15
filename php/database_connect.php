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

        last modified: November 7, 2023
    -----*/

        function db_conn_sess()
        {
            // set up db connection string
            // first, declare variables for the connection (must use an actual username and password for it to work)
            $host = "https://www.uniquebuilders.co"; // The host where MySQL database is running
            $port = 21098; // The port for MySQL database
            $db_name = "uniqijnw_uniquebuilders"; // Your MySQL database name
            $db_username = "your_username"; // Your MySQL username
            $db_password = "your_password"; // Your MySQL password

            // Establish the MySQL database connection
            $connection = mysqli_connect($host, $db_username, $db_password, $db_name, $port);

            if (!$connection) {
                die("MySQL Connection failed: " . mysqli_connect_error());
            }
            return $connection;
        }   // end of function db_conn_sess
        
?>