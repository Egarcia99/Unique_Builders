<?php
    /*=====

        file: password_form.php
        
        by: Colton Boyd, Gracie Ceja, & Emilyo Garcia
        last modified: 2023-11-25
    =====*/

?>
<?php
    function emplInfoForm($username)
    {
        ?>
             
            <!-- Personalized header because they entered their username -->
            <h1 id="welcomeheader">Welcome <?= $username ?></h1>
            <!-- Nav bar adapted from homepage -->
            <nav>
                <ul class="nav">
                    <li><a href="../html/homepage.html">Home</a></li>
                    <li><a href="../php/login_start.php">Employee Login</a></li>
                    <li><a href="../php/cust_contact.php">Contact Us</a></li>
                </ul>
            </nav>

            <!-- login form adapted from hw4 of cs328 -->
            <form method="post" action="../php/user_info_input.php" id="myForm" onsubmit="return validateForm()">
                <h2 id="instructionheader">Please Provide Further Information Below</h2>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" class="rectangleinput" placeholder="Email Address" required="required" />
                
                <label for="phoneNum">Phone Number:</label>
                <input type="tel" id="phoneNum" name="phoneNum" class="rectangleinput" placeholder="Phone Number" required="required" pattern="[0-9]{10}" title="10 digit phone number" />
                
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" class="rectangleinput" placeholder="Password" required="required" />
                
                <label for="confirmPassword">Confirm Password:</label>
                <input type="password" id="confirmPassword" name="confirmPassword" class="rectangleinput" placeholder="Confirm Password" required="required" />

                <input type="submit" name="submit" value="Submit" />
            </form>

            <script>
                function validateForm() 
                {
                    var password = document.getElementById("password").value;
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
    }   // end of function emplInfoForm()
?>