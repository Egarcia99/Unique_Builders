<?php
/* 
    edit_work_order.php
    by: Colton Boyd
    last modified: November 28, 2023

    edit_work_order.php allows employee edit previous created work orders, 
    it will populate the form fields with stored work order info, the employee then can
    changes the values of the field and press the update button to input info into data 
    will be redirected to update_work_orders.php
*/


// Check if the workOrderID is provided in the URL
if (!isset($_GET['work_order_id'])) 
{
    header("Location: work_orders.php");
}
else
{
        $workOrderID = strip_tags($_GET['work_order_id']);

        // Connect to the database
        require_once("../../../private/database_connect.php");
        $connObj = dbConnSess();

        // Query to get the details of the specified work order
        $workOrderStr = "SELECT * 
                        FROM Work_Order
                        WHERE WORKORDER_ID = :workOrderID";
        $workOrderStmt = oci_parse($connObj, $workOrderStr);
        oci_bind_by_name($workOrderStmt, ":workOrderID", $workOrderID);
        oci_execute($workOrderStmt, OCI_DEFAULT);

        // Fetch the work order details
        if (oci_fetch($workOrderStmt)) 
        {
            $selectedEmplID = oci_result($workOrderStmt, "EMPL_ID");
            $emplName = oci_result($workOrderStmt, "EMPL_ID");
            $extCompanyName = oci_result($workOrderStmt, "EXT_COMPANY_NAME");
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
                <input type="hidden" name="oldWorkOrderID" value="<?= $workOrderID ?>">

                <label for="workOrderID">PO Number:</label>
                <input type="text" name="workOrderID" minlength="7"  maxlength="7" value="<?= $workOrderID ?>" required>

                <label for="emplID">Employee:</label>
                <select name="emplID">
                    <option value="">N/A</option>
                    <?php
                    // Connect to the database and retrieve the employee IDs
                    $connObj = dbConnSess();
                    $collectEmplStr = "SELECT empl_id, empl_first_name || ' ' || empl_last_name AS empl_name
                                        FROM employee
                                        Where empl_role = 'Field'
                                        ORDER BY empl_id";
                    $collectEmplStmt = oci_parse($connObj, $collectEmplStr);
                    oci_execute($collectEmplStmt);

                    // Fetch the employee IDs and populate the dropdown menu
                    while ($row = oci_fetch_assoc($collectEmplStmt)) 
                    {
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
                
                <label for="workAddress">Address :</label>
                <textarea name="workAddress" rows="4"><?= empty($address) ? null : $address ?></textarea>

                <label for="propertyName">Property Name:</label>
                <input type="text" name="propertyName" value="<?= empty($property) ? null : $property ?>" maxlength="50">

                <label for="invoiceEstimate">Invoice Estimate:</label>
                <input type="number" name="invoiceEstimate" step="0.01" value="<?= empty($invoiceEstimate) ? null : $invoiceEstimate ?>" placeholder="$">

                <label for="invoiceAmount">Invoice Amount:</label>
                <input type="number" name="invoiceAmount" step="0.01" value="<?= empty($invoiceAmount) ? null : $invoiceAmount ?>" placeholder="$">

                <label for="jobDescription">Job Description:</label>
                <textarea name="jobDescription" rows="4"><?= empty($description) ? null : $description ?></textarea>

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