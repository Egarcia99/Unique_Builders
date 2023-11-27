<?php
// add_work_order.php

session_start();

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{
    require_once("../../../private/database_connect.php");
    $connObj = db_conn_sess();

    $workOrderInsertStr = "INSERT INTO Work_Order (WORKORDER_ID, work_address, empl_id,
                 job_type, call_date, ext_company_name, property_name,
                 PO_number, invoice_estimate, invoice_amount, job_description) 
                 VALUES (:workorder_id, :work_address, :empl_id, :job_type, 
             TO_DATE(:call_date, 'YYYY-MM-DD'), :ext_company_name, :property_name,
            :po_number, :invoice_estimate, :invoice_amount, :job_description)";

    $workOrderInsertStmt = oci_parse($connObj, $workOrderInsertStr);

    

    // Bind parameters
    $workOrderID = strip_tags($_POST['workOrderID']);
    $address = strip_tags($_POST['workAddress']);
    $emplID = strip_tags($_POST['emplID']);
    $jobType = strip_tags($_POST['jobType']);
    $callDate = strip_tags($_POST['callDate']);
    $extCompanyName = strip_tags($_POST['extCompanyName']);
    $propertyName = strip_tags($_POST['propertyName']);
    $poNumber = strip_tags($_POST['poNumber']);
    $invoiceEstimate = strip_tags($_POST['invoiceEstimate']);
    $invoiceAmount = strip_tags($_POST['invoiceAmount']);
    $jobDescription = strip_tags($_POST['jobDescription']);
    
    oci_bind_by_name($workOrderInsertStmt, ':workorder_id', $workOrderID);
    oci_bind_by_name($workOrderInsertStmt, ':address_id', $address);
    oci_bind_by_name($workOrderInsertStmt, ':empl_id', $emplID);
    oci_bind_by_name($workOrderInsertStmt, ':job_type', $jobType);
    oci_bind_by_name($workOrderInsertStmt, ':call_date', $callDate);
    oci_bind_by_name($workOrderInsertStmt, ':ext_company_name', $extCompanyName);
    oci_bind_by_name($workOrderInsertStmt, ':property_name', $propertyName);
    oci_bind_by_name($workOrderInsertStmt, ':po_number', $poNumber);
    oci_bind_by_name($workOrderInsertStmt, ':invoice_estimate', $invoiceEstimate);
    oci_bind_by_name($workOrderInsertStmt, ':invoice_amount', $invoiceAmount);
    oci_bind_by_name($workOrderInsertStmt, ':job_description', $jobDescription);

    // Execute the statement
    oci_execute($workOrderInsertStmt);

    // Optionally, you can check if the execution was successful
    if (oci_num_rows($workOrderInsertStmt) > 0) {
    echo "Work order inserted successfully!";
    } else {
    echo "Error inserting work order.";
    }

    // Free the statement
    oci_free_statement($workOrderInsertStmt);

    // Close the database connection
    oci_close($connObj);
    header("Location: work_orders.php");
    }
else 
{
    ?>

<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Add Work Order | Unique Builders</title>
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
    <h1>id=Add Work Order</h1>
    <button onclick="window.location.href='../php/work_orders.php'">Return to Work Orders </button>
    <form action="" method="post">
        <label for="workOrderID">Work Order ID:</label>
        <input type="text" name="workOrderID" maxlength="6">
        
        <label for="emplID">Employee ID:</label>
        <input type="text" name="emplID" maxlength="6">
        
        <label for="extCompanyName">External Company Name:</label>
        <input type="text" name="extCompanyName" maxlength="50">
        
        <label for="jobType">Job Type:</label>
        <input type="text" name="jobType" maxlength="30" required>
        
        <label for="callDate">Call Date:</label>
        <input type="date" name="callDate"required>
        
        <label for="propertyName">Property Name:</label>
        <input type="text" name="propertyName" maxlength="50">
        
        <label for="workAddress">Address :</label>
        <textarea name="workAddress" rows="4"></textarea>
        
        <label for="poNumber">PO Number:</label>
        <input type="text" name="poNumber" maxlength="7">
        
        <label for="invoiceEstimate">Invoice Estimate:</label>
        <input type="number" name="invoiceEstimate" step="0.01" placeholder="$">
        
        <label for="invoiceAmount">Invoice Amount:</label>
        <input type="number" name="invoiceAmount" step="0.01" placeholder="$">
        
        <label for="jobDescription">Job Description:</label>
        <textarea name="jobDescription" rows="4"></textarea>
        
        <button type="submit">Submit Work Order</button>
    </form>
    
</body>
</html>
<?php
}
?>
    