<?php
   
   /*=====
   
       file: new_password.php
       
       by: Colton Boyd, Gracie Ceja, & Emilyo Garcia
       last modified: 2023-11-24
   =====*/
   
   

?>
<?php
    function newPasswordForm($username)
    {
        if ($_SERVER["REQUEST_METHOD"] === "GET")
        {
        ?>
            <!-- login form adapted from hw4 of cs328 -->
            <h1 id="welcomeheader">Welcome <?= $username ?></h1>
            <!-- Nav bar adapted from homepage -->
            <nav>
                <ul class="nav">
                    <li><a href="../html/homepage.html">Home</a></li>
                    <li><a href="../php/login_start.php">Employee Login</a></li>
                    <li><a href="../php/cust_contact.php">Contact Us</a></li>
                </ul>
            </nav>

            <form method="post" action="">
                <h2 id="instructionheader">Please Provide Needed Information Below</h2>

                <input type="password" id ="newPassword" name="newPassword" class="rectangleinput" placeholder="New Password" />
                <input type="password" id ="confirmPassword" name="confirmPassword" class="rectangleinput" placeholder="Confirm Password" />

                <input type="submit" value="Submit" />
            </form>

            <script>
                function validateForm() 
                {
                    var password = document.getElementById("newPassword").value;
                    var confirmPassword = document.getElementById("confirmPassword").value;

                    // checking if the 2 user-entered passwords match
                    if (password != confirmPassword) 
                    {
                        alert("Confirmed Password do not match Password");
                        return false;
                    }
                    
                    // checking if the password meets the requirements
                    if (!password.match(/^(?=.*[!@#$%^&*()_-+=<>?])/)) 
                    {
                        alert("Password must contain at least one special character");
                        return false;
                    }
                    if(password.length < 12)
                    {
                        alert("Password must be at least 12 characters long");
                        return false;
                    }
                    
                    // the new password meets the requirements
                    return true;
                }   // end of function validateForm()
            </script>
        <?php
        }
        else
        {
            $newPassword = password_hash($_POST["newPassword"], PASSWORD_BCRYPT);
            updatePassword($username, $newPassword);
        }
        
    } // end of function newPasswordForm()

    function updatePassword($username, $newPassword)
    {
        // connection object
        //$connObj = oci_connect($conn1Username, $conn1Password, $dbConnStr);
        require_once("../../../private/database_connect.php");
        $connObj = db_conn_sess();
        /*==============
            db connection for when we have it setup
        ==================*/
        $passwordUpdateQuery = "UPDATE Employee 
                                SET empl_password = :emplpass,
                                    is_temporary = 'N'
                                WHERE empl_id = :username";

        $passwordUpdateStmt = oci_parse($connObj, $passwordUpdateQuery);

        oci_bind_by_name($passwordUpdateStmt, ":emplpass", $newPassword);
        oci_execute($passwordUpdateStmt, OCI_DEFAULT);
        //oci_commit($connObj); testing purposes don't want on 
        oci_free_statement($passwordUpdateStmt);

        oci_close($connObj);
    }
?>