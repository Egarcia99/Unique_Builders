<?php
/* 
    update_work_order.php
    takes in the info from edit_work_order.php and 
    updates the corresponding work order in the database with the provided information
    if the work order ID was changed from the current one it deletes the old one from the database
    and inserts the new one.

    by: Colton Boyd
    last modified: December 6, 2023
*/

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    // Retrieve form data

    // Bind parameters
    $oldWorkOrderID = isset($_POST['oldWorkOrderID']) ? strip_tags($_POST['oldWorkOrderID']) : null;
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
    if($workOrderID == $oldWorkOrderID)
    {
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
        oci_free_statement($updateWorkOrderStmt);
        if ($success) 
        {
            oci_commit($connObj);
        }
        else 
        {
            oci_rollback($connObj);
            $error = oci_error($updateWorkOrderStmt);
            error_log("Error updating work order: " . $error['message']);
            // Display a user-friendly error message
            echo "An error occurred while updating the work order. Please try again later.";
        }
        oci_close($connObj);

        // Free the statement and close the database connection
    }
    else
    {
        $deleteOldWorkOrderStr = "DELETE 
                                  FROM Work_Order 
                                  WHERE WORKORDER_ID = :oldWorkOrderID";
        $deleteOldWorkOrderStmt = oci_parse($connObj, $deleteOldWorkOrderStr);
        oci_bind_by_name($deleteOldWorkOrderStmt, ":oldWorkOrderID", $oldWorkOrderID);
        $deleteSuccess = oci_execute($deleteOldWorkOrderStmt, OCI_DEFAULT);
        oci_free_statement($deleteOldWorkOrderStmt);
        
        if ($deleteSuccess) 
        {
            $workOrderInsertStr = "INSERT INTO Work_Order (WORKORDER_ID, work_address, empl_id,
                                                job_type, call_date, ext_company_name, property_name,
                                                invoice_estimate, invoice_amount, job_description,current_status) 
                                   VALUES (:workOrderID, :workAddress, :emplID, :jobType, 
                                            TO_DATE(:callDate, 'YYYY-MM-DD'), :extCompanyName, :propertyName,
                                            :invoiceEstimate, :invoiceAmount, :jobDescription, :updateStatus)";

            $workOrderInsertStmt = oci_parse($connObj, $workOrderInsertStr);
            oci_bind_by_name($workOrderInsertStmt,":workOrderID", $workOrderID);
            oci_bind_by_name($workOrderInsertStmt, ":emplID", $emplID);
            oci_bind_by_name($workOrderInsertStmt, ":extCompanyName", $extCompanyName);
            oci_bind_by_name($workOrderInsertStmt, ":jobType", $jobType);
            oci_bind_by_name($workOrderInsertStmt, ":callDate", $callDate);
            oci_bind_by_name($workOrderInsertStmt, ":workAddress", $workAddress);
            oci_bind_by_name($workOrderInsertStmt, ":propertyName", $propertyName);
            oci_bind_by_name($workOrderInsertStmt, ":invoiceEstimate", $invoiceEstimate);
            oci_bind_by_name($workOrderInsertStmt, ":invoiceAmount", $invoiceAmount);
            oci_bind_by_name($workOrderInsertStmt, ":jobDescription", $jobDescription);
            oci_bind_by_name($workOrderInsertStmt, ":updateStatus", $status);

            oci_free_statement($workOrderInsertStmt);
            oci_commit($connObj);
        } 
        else 
        {
            oci_rollback($connObj);
            $error = oci_error($workOrderInsertStmt);
            error_log("Error inserting new work order: " . $error['message']);
            // Display a user-friendly error message
            echo "An error occurred while inserting the new work order. Please try again later.";
        }
            oci_close($connObj);
            header("Location: work_orders.php");
    }
    
} 
else 
{
    // Redirect to the form if accessed without form submission
    header("Location: work_orders.php");
}
?>
