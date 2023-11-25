<?php
/*
    by: Gracie Ceja & Emilyo Garcia
    last modified: November 24, 2023

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
        <!-- Nav bar adapted from homepage -->
        <nav>
            <ul class="nav">
                <li><a href="../html/homepage.html">Home</a></li>
                <li><a href="../php/login_start.php">Employee Login</a></li>
                <li><a href="../php/cust_contact.php">Contact Us</a></li>
            </ul>
        </nav>

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