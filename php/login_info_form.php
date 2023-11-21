<?php
    /*=====

        file: password_form.php
        // 
        by: Colton Boyd, Gracie Ceja
        last modified: 2023-11-19
    =====*/

?>
<?php
    function  emplInfoForm($username)
    {
        ?>
             
            <!-- Personalized header because they entered their username -->
            <h1 id="welcomeheader">Welcome <?= $username ?></h1>

            <!-- login form adapted from hw4 of cs328 -->

<form method="post" action="https://nrs-projects.humboldt.edu/~crb119/CS_458/php/user_info_input.php" id="myForm" onsubmit="return validateForm()">
                <h2 id="instructionheader">Please Provide Further Information Below</h2>

                <input type="email" id="email" name="email" class="rectangleinput" placeholder="Email Address" required="required" />
                <input type="tel" id="phoneNum" name="phoneNum" class="rectangleinput" placeholder="Phone Number" required="required" pattern="[0-9]{10}" title="10 digit phone number" />
                <input type="password" id="password" name="password" class="rectangleinput" placeholder="Password" required="required" />
                <input type="password" id="confirmPassword" name="confirmPassword" class="rectangleinput" placeholder="Confirm Password" required="required" />

                <input type="submit" name="submit" value="Submit" />
            </form>

            <script>
                    function validateForm() {
                        var password = document.getElementById("password").value;
                        var confirmPassword = document.getElementById("confirmPassword").value;

                        if (password != confirmPassword) {
                            alert("Confirmed Password do not match Password");
                            return false;
                        }
                        
                        if (!password.match(/^(?=.*[!@#$%^&*()_-+=<>?])/)) {
                                        alert("Password must contain at least one special character");
                                        return false;
                                    }
                        if(password.length < 12){
                            alert("Password must be at least 12 characters long");
                            return false;
                        }
                        return true;
                    }
                </script>

        <?php
    }
?>