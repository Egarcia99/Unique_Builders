<?php
/* 
    update_work_order.php
    by: Colton Boyd
    update_work_order.php
    takes in the info from edit_work_order 
    last modified: December 6, 2023
*/

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    // Retrieve form data

    // Bind parameters
    $workOrderID = isset($_POST['workOrderID']) ? strip_tags($_POST['workOrderID']) : null;
    $address = isset($_POST['workAddress']) ? strip_tags($_POST['workAddress']) : null;
    $emplID = isset($_POST['emplID']) ? strip_tags($_POST['emplID']) : null;
    $jobType = isset($_POST['jobType']) ? strip_tags($_POST['jobType']) : null;
    $callDate = isset($_POST['callDate']) ? strip_tags($_POST['callDate']) : null;
    $extCompanyName = isset($_POST['extCompanyName']) ? strip_tags($_POST['extCompanyName']) : null;
    $propertyName = isset($_POST['propertyName']) ? strip_tags($_POST['propertyName']) : null;
    $invoiceEstimate = isset($_POST['invoiceEstimate']) ? strip_tags($_POST['invoiceEstimate']) : null;
    $invoiceAmount = isset($_POST['invoiceAmount']) ? strip_tags($_POST['invoiceAmount']) : null;
    $jobDescription = isset($_POST['jobDescription']) ? strip_tags($_POST['jobDescription']) : null;
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
    header("Location: work_orders.php");
} else 
{
    // Redirect to the form if accessed without form submission
    header("Location: work_orders.php");
}
?>
