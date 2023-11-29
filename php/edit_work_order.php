<?php
/* 
    edit_work_order.php
    by: Colton Boyd
    last modified: November 28, 2023
*/


// Check if the workOrderID is provided in the URL
if (!isset($_GET['work_order_id'])) {
    echo "Work Order ID is missing.";
    header("Location: work_orders.php");
}
else
{
        $workOrderID = $_GET['work_order_id'];

        // Connect to the database
        require_once("../../../private/database_connect.php");
        $connObj = db_conn_sess();

        // Query to get the details of the specified work order
        $workOrderStr = "SELECT * 
                        FROM Work_Order
                        WHERE WORKORDER_ID = :workOrderID";
        $workOrderStmt = oci_parse($connObj, $workOrderStr);
        oci_bind_by_name($workOrderStmt, ":workOrderID", $workOrderID);
        oci_execute($workOrderStmt, OCI_DEFAULT);

        // Fetch the work order details
        if (oci_fetch($workOrderStmt)) {
            $workOrder = oci_result($workOrderStmt, "WORKORDER_ID");
            $selectedEmplID = oci_result($workOrderStmt, "EMPL_ID");
            $emplName = oci_result($workOrderStmt, "EMPL_ID");
            $company = oci_result($workOrderStmt, "EXT_COMPANY_NAME");
            $dataAssigned = oci_result($workOrderStmt, "CALL_DATE");
            $jobType = oci_result($workOrderStmt, "JOB_TYPE");
            $address = oci_result($workOrderStmt, "WORK_ADDRESS");
            $property = oci_result($workOrderStmt, "PROPERTY_NAME");
            $invoiceEstimate = oci_result($workOrderStmt, "INVOICE_ESTIMATE");
            $invoiceAmount = oci_result($workOrderStmt, "INVOICE_AMOUNT");
            $description = oci_result($workOrderStmt, "JOB_DESCRIPTION");
            // ... Fetch other fields similarly
        } else {
            echo "Work Order not found.";
            oci_free_statement($workOrderStmt);
            oci_close($connObj);
            exit();
        }

        // Close the statement
        oci_free_statement($workOrderStmt);

        // Close the database connection
        oci_close($connObj);
        ?>


        <!DOCTYPE html>
        <html lang="en">

        <head>
            <title>Edit Work Order | Unique Builders</title>
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
            <h1>Edit Work Order</h1>
            <form method="post" action="update_work_order.php">
                <label for="workOrderID">PO Number:</label>
                <input type="text" name="workOrderID" maxlength="7" value="<?= $workOrderID ?>" required>

                <label for="emplID">Employee:</label>
                <select name="emplID">
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
                        if ($emplID == $selectedEmplID) {
                            echo "<option value=\"$emplID\" selected>$emplName</option>";
                        } else {
                            echo "<option value=\"$emplID\">$emplName</option>";
                        }
                    }

                    // Free the statement and close the database connection
                    oci_free_statement($collectEmplStmt);
                    oci_close($connObj);
                    ?>
                </select>

                <label for="extCompanyName">External Company Name:</label>
                <input type="text" name="extCompanyName" value="<?= empty($extCompanyName) ? null : $extCompanyName ?>">

                <label for="jobType">Job Type:</label>
                <input type="text" name="jobType" value="<?= empty($jobType) ? null : $jobType ?>" required>

                
                <label for="callDate">Call Date:</label>
                <input type="date" name="callDate" value="<?= empty($dataAssigned) ? null : date('Y-m-d', strtotime($dataAssigned)) ?>" required>
                
                <label for="work_address">Address :</label>
                <textarea name="work_address" rows="4"><?= empty($address) ? null : $address ?></textarea>

                <label for="property_name">Property Name:</label>
                <input type="text" name="property_name" value="<?= empty($property) ? null : $property ?>" maxlength="50">

                <label for="invoice_estimate">Invoice Estimate:</label>
                <input type="number" name="invoice_estimate" step="0.01" value="<?= empty($invoiceEstimate) ? null : $invoiceEstimate ?>" placeholder="$">

                <label for="invoice_amount">Invoice Amount:</label>
                <input type="number" name="invoice_amount" step="0.01" value="<?= empty($invoiceAmount) ? null : $invoiceAmount ?>" placeholder="$">

                <label for="job_description">Job Description:</label>
                <textarea name="job_description" rows="4"><?= empty($description) ? null : $description ?></textarea>

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
<?php
}