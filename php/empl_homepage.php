<?php
/*
    by: Gracie Ceja & Emilyo Garcia
    last modified: November 28, 2023

    you can run this using the URL: https://nrs-projects.humboldt.edu/~glc47/cs458/Unique_Builders-main/php/login_username.php
    CS 458 Software Engineering
    Semester Project: Unique Builders Company Website & Database
    Team: Tech Titans
    Fall 2023
    Employeee Homepage (as a function to be called in other pages)
*/


    function emplHomepage($username)
    {
        ?>
        <!DOCTYPE html>
        <html lang="en" xmlns="http://www.w3.org/1999/xhtml">

        <!-- cs328 class HTML template: last modified 2023-02-22 -->

        <head>
            <title>Employee Homepage</title>
            <meta charset="utf-8" />

            <link href="https://nrs-projects.humboldt.edu/~st10/styles/normalize.css"
            type="text/css" rel="stylesheet" />
            
            <link href="../css/login.css" type="text/css" rel="stylesheet" />
            
        </head>
        <body>
            <!-- Personalized header because they entered their username -->
            <h1 id="welcomeheader">Welcome <?= $username ?> </h1>
            <!-- Nav bar adapted from homepage -->
            <nav>
                <ul class="nav">
                    <li><a href="../html/homepage.html">Home</a></li>
                    <li><a href="../php/login_start.php">Employee Homepage</a></li>
                    <li><a href="../php/cust_contact.php">Contact Us</a></li>
                </ul>
            </nav>

            <table class="homepage">
                <tr class="homepage">
                    <td class="homepage"><a href="../php/work_orders.php">Work Orders</a></td>
                    <td class="homepage"><a href="../php/payroll.php">Payroll</a></td>
                </tr>
                <tr class="homepage">
                    <td class="homepage"><a href="../php/empl_info.php">Employee Information</a></td>
                    <td class="homepage"><a href="../php/logout.php">Log Out</a></td>
                </tr>
            </table>

        </body>
        </html>
        <?php
    }
?>