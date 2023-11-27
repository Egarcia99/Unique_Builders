<?php
// add_work_order.php

session_start();

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{
    require_once("../../../private/database_connect.php");
    $connObj = db_conn_sess();

    $workOrderInsertStr = "INSERT INTO Work_Order (WORKORDER_ID, ADDRESS_ID, EMPL_ID,
                 job_type, call_date, ext_company_name, property_name,
                 PO_number, invoice_estimate, invoice_amount, job_description) 
                 VALUES (:workorder_id, :address_id, :empl_id, :job_type, 
             TO_DATE(:call_date, 'YYYY-MM-DD'), :ext_company_name, :property_name,
            :po_number, :invoice_estimate, :invoice_amount, :job_description)";

    $workOrderInsertStmt = oci_parse($connObj, $workOrderInsertStr);

    

    // Bind parameters
    $workorder_id = strip_tags($_POST['workorder_id']);
    $address_id = strip_tags($_POST['address_id']);
    $empl_id = strip_tags($_POST['empl_id']);
    $job_type = strip_tags($_POST['job_type']);
    $call_date = strip_tags($_POST['call_date']);
    $ext_company_name = strip_tags($_POST['ext_company_name']);
    $property_name = strip_tags($_POST['property_name']);
    $po_number = strip_tags($_POST['po_number']);
    $invoice_estimate = strip_tags($_POST['invoice_estimate']);
    $invoice_amount = strip_tags($_POST['invoice_amount']);
    $job_description = strip_tags($_POST['job_description']);
    
    oci_bind_by_name($workOrderInsertStmt, ':workorder_id', $workorder_id);
    oci_bind_by_name($workOrderInsertStmt, ':address_id', $address_id);
    oci_bind_by_name($workOrderInsertStmt, ':empl_id', $empl_id);
    oci_bind_by_name($workOrderInsertStmt, ':job_type', $job_type);
    oci_bind_by_name($workOrderInsertStmt, ':call_date', $call_date);
    oci_bind_by_name($workOrderInsertStmt, ':ext_company_name', $ext_company_name);
    oci_bind_by_name($workOrderInsertStmt, ':property_name', $property_name);
    oci_bind_by_name($workOrderInsertStmt, ':po_number', $po_number);
    oci_bind_by_name($workOrderInsertStmt, ':invoice_estimate', $invoice_estimate);
    oci_bind_by_name($workOrderInsertStmt, ':invoice_amount', $invoice_amount);
    oci_bind_by_name($workOrderInsertStmt, ':job_description', $job_description);

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
        <label for="employee">Employee ID:</label>
        <input type="text" name="employee" maxlength="6">
        
        <label for="ext_company_name">External Company Name:</label>
        <input type="text" name="ext_company_name" maxlength="50">
        
        <label for="job_type">Job Type:</label>
        <input type="text" name="job_type" maxlength="30" required>
        
        <label for="call_date">Call Date:</label>
        <input type="date" name="call_date"required>
        
        <label for="property_name">Property Name:</label>
        <input type="text" name="property_name" maxlength="50">
        
        <label for="address_id">Address ID:</label>
        <input type="text" name="address_id">
        
        <label for="po_number">PO Number:</label>
        <input type="text" name="po_number" maxlength="7">
        
        <label for="invoice_estimate">Invoice Estimate:</label>
        <input type="number" name="invoice_estimate" step="0.01" placeholder="$">
        
        <label for="invoice_amount">Invoice Amount:</label>
        <input type="number" name="invoice_amount" step="0.01" placeholder="$">
        
        <label for="job_description">Job Description:</label>
        <textarea name="job_description" rows="4"></textarea>
        
        <button type="submit">Submit Work Order</button>
    </form>
    
</body>
</html>
<?php
}
?>