<?php
    /*=====

        file: password_form.php
        
        by: Colton Boyd, Gracie Ceja, & Emilyo Garcia
        last modified: 2023-11-25
    =====*/

?>
<?php
    function  passwordForm($username)
    {
        ?>

        <h1 id="welcomeheader">Welcome <?= $username ?></h1>
        <!-- Nav bar adapted from homepage -->
        <nav>
            <ul class="nav">
                <li><a href="../html/homepage.html">Home</a></li>
                <li><a href="../php/login_start.php">Employee Login</a></li>
                <li><a href="../php/cust_contact.php">Contact Us</a></li>
            </ul>
        </nav>

        <!-- log in form adapted from hw4 of cs328 -->
        <form method="post" action="../php/login_empl.php">
            <h2 id="instructionheader">Please Enter Your Password Below</h2>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" class="roundedinput" required="required" />

            <p><a href="../php/forgot_password.php" id="forgotpasswordlink">Forgot Password?</a></p>

            <input type="submit" name="submit" value="Submit" />
        </form>

        <?php
    }
?>