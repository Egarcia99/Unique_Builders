<?php
/*
    adapted from: CS 328 hw7 problem2
    by: Gracie Ceja, & Emilyo Garcia & Colton Boyd
    last modified: November 28, 2023

    you can run this using the URL: https://nrs-projects.humboldt.edu/~glc47/cs458/Unique_Builders-main/php/work_orders.php
    CS 458 Software Engineering
    Semester Project: Unique Builders Company Website & Database
    Team: Tech Titans
    Fall 2023
    Work Orders Page
    Requirement: 2.5 Job work orders

    This file is incomplete?
*/
    
?>

<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">

<!-- cs328 class HTML template: last modified 2023-02-22 -->

<head>
    <title>Work Orders | Unique Builders</title>
    <meta charset="utf-8" />

    <!-- favicon -->
    <link rel="icon" type="image/x-icon" href="../images/UB_logo.jpg" />

	<!-- default css to make the webpage look nearly the same on all browsers -->
    <link href="https://nrs-projects.humboldt.edu/~st10/styles/normalize.css"
          type="text/css" rel="stylesheet" />
    
	<!-- css file adapted from from cs328 homework 4, problem 9 -->
    <link href="../css/login.css" type="text/css" rel="stylesheet" />
    <!-- css file for work_orders.php -->
    <link href="../css/table.css" type="text/css" rel="stylesheet" />

</head>
<body>
        <h1 id="welcomeheader">Work Orders</h1>
        <!-- Nav bar adapted from homepage -->
        <nav>
            <ul class="nav">
                <li><a href="../html/homepage.html">Home</a></li>
                <li><a href="../php/empl_homepage.php">Employee Homepage</a></li>
                <li><a href="../php/cust_contact.php">Contact Us</a></li>
            </ul>
        </nav>
        <!-- Add this button after the table section in your HTML body -->
        <button onclick="window.location.href='../php/work_order_insert.php'">Add Work Order</button>

        <!-- The table form section below is adapted from: CS 328 hw7 problem2 -->
        <?php
        // Show a form with a table with information about work orders.

        // First, connect to database with connection object
        require_once("../../../private/database_connect.php");
        $connObj = dbConnSess();

        /*==============
            db connection for when we have it setup
        ==================*/


        // next, query database for all the info about the work orders
        $workOrdersStr = "SELECT Work_Order.WORKORDER_ID, Employee.EMPL_FIRST_NAME || ' ' || Employee.EMPL_LAST_NAME, 
                                     Work_Order.EXT_COMPANY_NAME , Work_Order.CALL_DATE, Work_Order.JOB_TYPE, Work_Order.work_address, 
                                     Work_Order.property_name, Work_Order.INVOICE_ESTIMATE, Work_Order.INVOICE_AMOUNT,
                                     Work_Order.job_description,Work_Order.CURRENT_STATUS
                              FROM Work_Order
                              LEFT JOIN Employee ON Work_Order.EMPL_ID = Employee.EMPL_ID
                              ORDER BY Work_Order.WORKORDER_ID";
        $workOrderStmt = oci_parse($connObj, $workOrdersStr);
        oci_execute( $workOrderStmt, OCI_DEFAULT);
        // Check if the execution was successful
        if (!$workOrderStmt) 
        {
            // Log the error for debugging purposes (do not expose detailed errors to users)
            $error = oci_error($workOrderStmt);
            error_log("Error executing statement: " . $error['message']);
            // Display a user-friendly error message
            echo "An error occurred while retrieving work orders. Please try again later.";
            oci_free_statement($workOrderStmt);  
            oci_close($connObj);
        }
        else
        {

        
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
            <caption>Current Work Orders of the company:</caption>
            <tr> 
                <th scope="col"></th>  
                <th scope="col">Work Order ID</th>
                <th scope="col">Employee/s or Company</th>
                <th scope="col">Date Assigned</th>
                <th scope="col">Job Type</th> 
                <th scope="col">Address</th>
                <th scope="col">Property</th>
                <th scope="col">Invoice Estimate</th>
                <th scope="col">Invoice Amount</th>
                <th scope="col">Description</th>
                <th scope="col">Status</th>  
            </tr>

            <?php
            $company = NULL;
            $emplName = NULL;
            $previousWorkOrder = NULL;
            // getting data from the title table in the database:
            while (oci_fetch( $workOrderStmt))
            {
                $workOrder = oci_result($workOrderStmt, 1);
                $emplName = oci_result($workOrderStmt, 2);
                $company = oci_result($workOrderStmt, 3);
                $dataAssigned = oci_result($workOrderStmt, 4);
                $jobType = oci_result($workOrderStmt, 5);
                $address = oci_result($workOrderStmt, 6);
                $property = oci_result($workOrderStmt, 7);
                $invoiceEstimate = oci_result($workOrderStmt, 8);
                $invoiceAmount = oci_result($workOrderStmt, 9);
                $description = oci_result($workOrderStmt, 10);
                $status = oci_result($workOrderStmt, 11);
                // putting the data into the html table
                ?>
                <tr> 
                <?php 
                    if ($previousWorkOrder != $workOrder)
                    {
                ?>      <td><button><a href="../php/edit_work_order.php?work_order_id=<?= $workOrder ?>" style="text-decoration: none; color: inherit;">Edit</a></button></td>
                        <td><?= $workOrder ?></td>
                        <td><?= formatEmplCompanyCol($emplName, $company) ?></td>
                        <td><?= $dataAssigned ?></td>
                        <td><?= $jobType ?></td>
                        <td><?= $address ?></td>
                        <td><?= $property ?></td>
                        <td><?= $invoiceEstimate ?></td>
                        <td><?= $invoiceAmount ?></td>
                        <td><?= $description ?></td>
                        <td><?= $status ?></td>
                <?php
                    }
                    else
                    {
                ?>
                        <td><?= formatEmplCompanyCol($emplName, $company) ?></td>
                <?php
                    }
                ?>

                </tr>
                <?php
                $previousWorkOrder = $workOrder;
            }

            function formatEmplCompanyCol($emplName, $company) 
            {
                if ($company != NULL && $emplName != NULL) {
                    return $emplName . " / " . $company;
                } elseif ($company != NULL) {
                    return $company;
                } else {
                    return $emplName;
                }
            }
        
            ?>
            </table>
            <?php
            // free statement & close the connection to the database
            oci_free_statement($workOrderStmt);  
            oci_close($connObj);
        }
        
        ?>
        
</body>
</html>
