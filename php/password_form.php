<?php
    /*=====

        file: password_form.php
        // 
        by: Colton Boyd, Gracie Ceja
        last modified: 2023-11-05
    =====*/

?>
<?php
    function  passwordForm($username)
    {
        ?>

        <h1 id="welcomeheader">Welcome <?= $username ?></h1>

        <!-- log in form adapted from hw4 of cs328 -->
        <form method="post" action="https://nrs-projects.humboldt.edu/~crb119/CS_458/php/login_empl.php">
            <h2 id="instructionheader">Please Enter Your Password Below</h2>

            <input type="password" name="password" class="roundedinput" required="required" />

            <p><a href="https://nrs-projects.humboldt.edu/~crb119/CS_458/php/forgot_password.php" id="forgotpasswordlink">Forgot Password?</a></p>

            <input type="submit" name="submit" value="Submit" />
        </form>

        <?php
    }
?>