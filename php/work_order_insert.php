<?php
// add_work_order.php
require_once("../../../private/database_connect.php");
session_start();

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{
   
    $connObj = db_conn_sess();

    $workOrderInsertStr = "INSERT INTO Work_Order (WORKORDER_ID, work_address, empl_id,
                 job_type, call_date, ext_company_name, property_name,
                 invoice_estimate, invoice_amount, job_description) 
                 VALUES (:workorder_id, :work_address, :empl_id, :job_type, 
             TO_DATE(:call_date, 'YYYY-MM-DD'), :ext_company_name, :property_name,
              :invoice_estimate, :invoice_amount, :job_description)";

    $workOrderInsertStmt = oci_parse($connObj, $workOrderInsertStr);

    

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
    
    oci_bind_by_name($workOrderInsertStmt, ':workorder_id', $workOrderID);
    oci_bind_by_name($workOrderInsertStmt, ':work_address', $address);
    oci_bind_by_name($workOrderInsertStmt, ':empl_id', $emplID);
    oci_bind_by_name($workOrderInsertStmt, ':job_type', $jobType);
    oci_bind_by_name($workOrderInsertStmt, ':call_date', $callDate);
    oci_bind_by_name($workOrderInsertStmt, ':ext_company_name', $extCompanyName);
    oci_bind_by_name($workOrderInsertStmt, ':property_name', $propertyName);
    oci_bind_by_name($workOrderInsertStmt, ':invoice_estimate', $invoiceEstimate);
    oci_bind_by_name($workOrderInsertStmt, ':invoice_amount', $invoiceAmount);
    oci_bind_by_name($workOrderInsertStmt, ':job_description', $jobDescription);

    // Execute the statement
    oci_execute($workOrderInsertStmt);

    // Optionally, you can check if the execution was successful
   /* if (oci_num_rows($workOrderInsertStmt) > 0) {
    echo "Work order inserted successfully!";
    } else {
    echo "Error inserting work order.";
    }
   */
    // Free the statement
    oci_free_statement($workOrderInsertStmt);
    oci_commit($connObj);
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
    <h1 id="welcomeheader">Add Work Order</h1>
    <button onclick="window.location.href='../php/work_orders.php'">Return to Work Orders </button>
    <form action="" method="post">
        <label for="workOrderID">PO Number:</label>
        <input type="text" name="workOrderID" maxlength="7" required>
        
        <label for="emplID">Employee:</label>
        <select name="emplID">
        <option value="NULL">Select an Employee</option>
        <option value="NULL">N/A</option>
        <?php
        // Connect to the database and retrieve the employee IDs
        $connObj = db_conn_sess();
        $collectEmplStr = "SELECT empl_id, empl_first_name || ' ' || empl_last_name AS empl_name
                            FROM employee
                            Where empl_role = 'Field'
                            ORDER BY empl_id";
        $collectEmplStmt = oci_parse($connObj, $collectEmplStr);
        oci_execute($collectEmplStmt);

        // Fetch the employee IDs and populate the dropdown menu
        while ($row = oci_fetch_assoc($collectEmplStmt)) {
            $emplID = $row['EMPL_ID'];
            $emplName = $row['EMPL_NAME'];
            echo "<option value=\"$emplID\">$emplName</option>";
        }  

        // Free the statement and close the database connection
        oci_free_statement($collectEmplStmt);
        oci_close($connObj);
        ?>
        </select>

        
        <label for="extCompanyName">External Company Name:</label>
        <input type="text" name="extCompanyName" maxlength="50">
        
        <label for="jobType">Job Type:</label>
        <input type="text" name="jobType" maxlength="30" required>
        
        <label for="callDate">Call Date:</label>
        <input type="date" name="callDate"required>
        
        <label for="propertyName">Property Name:</label>
        <input type="text" name="propertyName" maxlength="50" required>
        
        <label for="workAddress">Address :</label>
        <textarea name="workAddress" rows="4"></textarea>
        
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
    