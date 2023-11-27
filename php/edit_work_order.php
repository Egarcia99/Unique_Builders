<?php
// edit_work_order.php

// Check if the workOrderID is provided in the URL
if (!isset($_GET['workOrderID'])) {
    echo "Work Order ID is missing.";
    exit();
}

$workOrderID = $_GET['workOrderID'];

// Connect to the database
require_once("../../../private/database_connect.php");
$connObj = db_conn_sess();

// Query to get the details of the specified work order
$work_order_query = "SELECT * 
                    FROM Work_Order 
                    WHERE WORKORDER_ID = :workOrderID";
$work_order_stmt = oci_parse($connObj, $work_order_query);
oci_bind_by_name($work_order_stmt, ":workOrderID", $workOrderID);
oci_execute($work_order_stmt, OCI_DEFAULT);

// Fetch the work order details
if (oci_fetch($work_order_stmt)) {
    $jobType = oci_result($work_order_stmt, "JOB_TYPE");
    $callDate = oci_result($work_order_stmt, "CALL_DATE");
    $extCompanyName = oci_result($work_order_stmt, "EXT_COMPANY_NAME");
    // ... Fetch other fields similarly
} else {
    echo "Work Order not found.";
    oci_free_statement($work_order_stmt);
    oci_close($connObj);
    exit();
}

// Close the statement
oci_free_statement($work_order_stmt);

// Close the database connection
oci_close($connObj);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Edit Work Order | Unique Builders</title>
    <meta charset="utf-8" />
    <link rel="icon" type="image/x-icon" href="../images/UB_logo.jpg" />
    <link href="https://nrs-projects.humboldt.edu/~st10/styles/normalize.css" type="text/css" rel="stylesheet" />
    <link href="../css/edit_work_order.css" type="text/css" rel="stylesheet" />
</head>

<body>
    <h1>Edit Work Order</h1>
    <form method="post" action="update_work_order.php">
        <label for="workOrderID">Work Order ID:</label>
        <input type="hidden" name="workOrderID" value="<?= $workOrderID ?>">
        
        <label for="employee">Employee ID:</label>
        <input type="text" name="employee" maxlength="6" value="<?= $workOrderID ?>>

        <label for="extCompanyName">External Company Name:</label>
        <input type="text" name="extCompanyName" value="<?= $extCompanyName ?>" required>
        
        <label for="callDate">Call Date:</label>
        <input type="text" name="callDate" value="<?= $callDate ?>" required>
        
        <label for="jobType">Job Type:</label>
        <input type="text" name="jobType" value="<?= $jobType ?>" required>

        <label for="work_address">Address :</label>
        <textarea name="work_address" rows="4"></textarea>

        <label for="property_name">Property Name:</label>
        <input type="text" name="property_name" maxlength="50">

        <label for="po_number">PO Number:</label>
        <input type="text" name="po_number" maxlength="7">

        <label for="invoice_estimate">Invoice Estimate:</label>
        <input type="number" name="invoice_estimate" step="0.01" placeholder="$">
        
        <label for="invoice_amount">Invoice Amount:</label>
        <input type="number" name="invoice_amount" step="0.01" placeholder="$">
        
        <label for="job_description">Job Description:</label>
        <textarea name="job_description" rows="4"></textarea>

        <label for="status">Status:</label>
        <select name="status">
            <option value="In Progress">In Progress</option>
            <option value="Completed">Completed</option>
        </select>
        <!-- Add other input fields for other details -->

        <input type="submit" value="Update Work Order">
    </form>
</body>

</html>
