<?php
   
   /*=====
   
       file: new_password.php
       
       by: Colton Boyd, Gracie Ceja, & Emilyo Garcia
       last modified: 2023-11-25
   =====*/
   
   

?>
<?php
    function newPasswordForm($username)
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

            <form method="post" action="../php/new_password_input.php" onsubmit="return validateForm()">
                <h2 id="instructionheader">Please Provide Needed Information Below</h2>

                <label for="newPassword">Password:</label>
                <input type="password" id ="newPassword" name="newPassword" class="rectangleinput" placeholder="New Password" />
                
                <label for="confirmPassword">Confirm Password:</label>
                <input type="password" id ="confirmPassword" name="confirmPassword" class="rectangleinput" placeholder="Confirm Password" />

                <p>Password requirements:</p>
                <ul>
                    <li>Must contain at least one special character (!@#$%^&*()_-+=<>?)</li>
                    <li>Must be at least 12 characters long</li>
                </ul>

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
                    if (!password.match(/^(?=.*[!@#\$%\^&\*\(\)_\-\+=<>?])/)) {
                        console.log("Password must contain at least one special character");
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
    }   // end of function newPasswordForm()
       
        
    
        
   

   