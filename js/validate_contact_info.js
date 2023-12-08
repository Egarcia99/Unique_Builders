"use strict";

/*
    adapted from: CS 328 two-value.js example file by Professor Sharon Tuttle
    modified by: Gracie Ceja && Colton B
    last modified: December 7 , 2023

    this is used in the php file which you can run this using the URL: 
    https://nrs-projects.humboldt.edu/~glc47/cs458/loginTesting/forgot_password.php
    CS 458 Software Engineering
    Semester Project: Unique Builders Company Website & Database
    Team: Tech Titans
    Fall 2023
    Employeee Login: Forgot Password
    Requirements: 2.1 & 2.2
*/

function correctInfo(storedEmail, storedPhoneNum)
{
    let enteredEmail = document.getElementById('enteredEmail').value;
    let enteredPhoneNum = document.getElementById('enteredPhoneNum').value;
    let errorMessageElement = document.getElementById('error-message');

    // check if the contact info entered by the user matches that in the database
    
    if (enteredEmail === storedEmail || enteredPhoneNum.trim()== storedPhoneNum.trim()) {
        // Valid input, continue with the form submission
        return true;
    } else {
        // Invalid input, display an error message
        errorMessageElement.textContent = 'Invalid email or phone number. Please enter the correct information.';
        return false; // Prevent form submission
    }

}
 

