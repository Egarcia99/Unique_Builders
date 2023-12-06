<?php
/* 
    update_work_order.php
    by: Colton Boyd
    last modified: November 28, 2023
*/

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $workOrderID = $_POST['workOrderID'];
    $emplID = $_POST['emplID'];
    $extCompanyName = $_POST['extCompanyName'];
    $jobType = $_POST['jobType'];
    $callDate = $_POST['callDate'];
    $workAddress = $_POST['work_address'];
    $propertyName = $_POST['property_name'];
    $invoiceEstimate = $_POST['invoice_estimate'];
    $invoiceAmount = $_POST['invoice_amount'];
    $jobDescription = $_POST['job_description'];
    $status = $_POST['status'];

    // Connect to the database
    require_once("../../../private/database_connect.php");
    $connObj = dbConnSess();

    // Update the work order in the database
    $updateWorkOrderStr = "UPDATE Work_Order
                  SET EMPL_ID = :emplID,
                      EXT_COMPANY_NAME = :extCompanyName,
                      JOB_TYPE = :jobType,
                      CALL_DATE = TO_DATE(:callDate, 'YYYY-MM-DD'),
                      WORK_ADDRESS = :workAddress,
                      PROPERTY_NAME = :propertyName,
                      INVOICE_ESTIMATE = :invoiceEstimate,
                      INVOICE_AMOUNT = :invoiceAmount,
                      JOB_DESCRIPTION = :jobDescription,
                      CURRENT_STATUS = :updateStatus
                  WHERE WORKORDER_ID = :workOrderID";

    $updateWorkOrderStmt = oci_parse($connObj, $updateWorkOrderStr);
    
    // Bind parameters
    oci_bind_by_name($updateWorkOrderStmt, ":emplID", $emplID);
    oci_bind_by_name($updateWorkOrderStmt, ":extCompanyName", $extCompanyName);
    oci_bind_by_name($updateWorkOrderStmt, ":jobType", $jobType);
    oci_bind_by_name($updateWorkOrderStmt, ":callDate", $callDate);
    oci_bind_by_name($updateWorkOrderStmt, ":workAddress", $workAddress);
    oci_bind_by_name($updateWorkOrderStmt, ":propertyName", $propertyName);
    oci_bind_by_name($updateWorkOrderStmt, ":invoiceEstimate", $invoiceEstimate);
    oci_bind_by_name($updateWorkOrderStmt, ":invoiceAmount", $invoiceAmount);
    oci_bind_by_name($updateWorkOrderStmt, ":jobDescription", $jobDescription);
    oci_bind_by_name($updateWorkOrderStmt, ":updateStatus", $status);
    oci_bind_by_name($updateWorkOrderStmt, ":workOrderID", $workOrderID);

    // Execute the update statement
    $success = oci_execute($updateWorkOrderStmt, OCI_DEFAULT);

    if ($success) {
        oci_commit($connObj);
    } else {
        oci_rollback($connObj);
    }

    // Free the statement and close the database connection
    oci_free_statement($updateWorkOrderStmt);
    oci_close($connObj);
    header("Location: edit_work_order.php");
} else {
    // Redirect to the form if accessed without form submission
    header("Location: edit_work_order.php");
}
?>
