<?php
/*
    adapted from: CS 328 hw7 problem2
    by: Gracie Ceja, & Emilyo Garcia
    last modified: November 25, 2023

    you can run this using the URL: https://nrs-projects.humboldt.edu/~glc47/cs458/Unique_Builders-main/php/work_orders.php
    CS 458 Software Engineering
    Semester Project: Unique Builders Company Website & Database
    Team: Tech Titans
    Fall 2023
    Work Orders Page
    Requirement: 2.5 Job work orders

    This file is incomplete!
*/
    session_start();
    // get username from session variable
    $username = $_SESSION["username"];
?>

<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">

<!-- cs328 class HTML template: last modified 2023-02-22 -->

<head>
    <title>Employee Login | Unique Builders</title>
    <meta charset="utf-8" />

    <!-- favicon -->
    <link rel="icon" type="image/x-icon" href="../images/UB_logo.jpg" />

	<!-- default css to make the webpage look nearly the same on all browsers -->
    <link href="https://nrs-projects.humboldt.edu/~st10/styles/normalize.css"
          type="text/css" rel="stylesheet" />
    
	<!-- css file adapted from from cs328 homework 4, problem 9 -->
    <link href="../css/login.css" type="text/css" rel="stylesheet" />

</head>
<body>
        <!-- Personalized header because they entered their username -->
        <h1 id="welcomeheader">Welcome <?= $username ?></h1>
        <!-- Nav bar adapted from homepage -->
        <nav>
            <ul class="nav">
                <li><a href="../html/homepage.html">Home</a></li>
                <li><a href="../php/login_start.php">Employee Login</a></li>
                <li><a href="../php/cust_contact.php">Contact Us</a></li>
            </ul>
        </nav>
        
        <!-- The table form section below is adapted from: CS 328 hw7 problem2 -->
        <?php
        // Show a form with a table with information about work orders.

        // First, connect to database with connection object
        require_once("../../../private/database_connect.php");
        $connObj = db_conn_sess();
        /*==============
            db connection for when we have it setup
        ==================*/


        // next, query database for all the info about the work orders
        $work_orders_query = "Select workorder_id, emp_lname, job_title, salary
                                from Work_Order
                                order by emp_lname, emp_fname";
        $empls_stmt = oci_parse($connobj, $empls_query);
        oci_execute($empls_stmt, OCI_DEFAULT);  

        /*
        WORKORDER_ID CHAR(6),
        ADDRESS_ID CHAR(6),
        EMPL_ID CHAR(6),
        job_type VARCHAR2(30),
        call_date DATE,
        ext_company_name VARCHAR2(50),
        property_name VARCHAR2(50),
        PO_number char(7),
        invoice_estimate REAL,
        invoice_amount REAL,
        job_description CLOB,
        current_status VARCHAR(150),
        */

        // next, set up table:
        ?>
        <table>
        <caption>Current Employees of the company:</caption>
        <tr> 
            <th scope="col">First Name</th>
            <th scope="col">Last Name</th>
            <th scope="col">Job Title</th>
            <th scope="col">Salary</th> 
        </tr>

        <?php
        // getting data from the title table in the database:
        while (oci_fetch($empls_stmt))
        {
            // get data from each cell
            $first_name = oci_result($empls_stmt, 1);    // 1st column projected
            $last_name = oci_result($empls_stmt, 2); 
            $job = oci_result($empls_stmt, 3);
            $salary = oci_result($empls_stmt, 4); 


            // putting the data into the html table
            ?>
            <tr> 
                <td><?= $first_name ?></td>
                <td><?= $last_name ?></td>
                <td><?= $job ?></td>
                <td>$<?= $salary ?></td> 
            </tr>
            <?php
        }
        ?>
        </table>

        
        <?php
        // free statement & close the connection to the database
        oci_free_statement($empls_stmt);
        oci_close($connobj);
        ?>
        
</body>
</html>
