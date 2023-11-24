<?php
/*
    by: Gracie Ceja
    last modified: November 23, 2023

    you can run this using the URL: https://nrs-projects.humboldt.edu/~glc47/cs458/Unique_Builders-main/php/login_username.php
    CS 458 Software Engineering
    Semester Project: Unique Builders Company Website & Database
    Team: Tech Titans
    Fall 2023
    Employeee Homepage (as a function to be called in other pages)
*/
    session_start();

    // get username from session variable
    $username = $_SESSION["username"];

    function emplHomepage()
    {
        ?>
        <!-- Personalized header because they entered their username -->
        <h1 id="welcomeheader">Welcome <?= $username ?></h1>

        <table>
            <tr>
                <td><a href="work_orders.php">Work Orders</a></td>
                <td><a href="payroll.php">Payroll</a></td>
            </tr>
            <tr>
                <td><a href="empl_info.php">Employee Information</a></td>
                <td><a href="logout.php">Log Out</a></td>
            </tr>
        </table>

        <?php
    }
?>