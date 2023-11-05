"use strict";

/*
    adapted from: CS 328 two-value.js example file by Professor Sharon Tuttle
    modified by: Gracie Ceja
    last modified: November 4, 2023

    this is used in the php file which you can run this using the URL: 
    https://nrs-projects.humboldt.edu/~glc47/cs458/loginTesting/forgot_password.php
    CS 458 Software Engineering
    Semester Project: Unique Builders Company Website & Database
    Team: Tech Titans
    Fall 2023
    Employeee Login: Forgot Password
    Requirements: 2.1 & 2.2
*/


// add event handlers once the window is loaded
window.onload =
    function()
    {
        // add an onsubmit event handler to the form element to validate the form
        let contactInfoForm = document.getElementById("contactInfoForm");

        // if this form exists
        if (contactInfoForm != null)
        {
           contactInfoForm.onsubmit = correctInfo;
        }
    };

/*---
    signature: void -> boolean
    returns true if the user-entered contact info is correct, returns false otherwise,
       and complains in a new paragraph element.
---*/

function correctInfo()
{
    // get the DOM object for the document's body element
    let bodyObjectArray = document.getElementsByTagName("body");
    let bodyObject = bodyObjectArray[0]; 

    // get my textfield objects to validate
    let emailField = document.getElementById("enteredEmail");
    let phoneNumField = document.getElementById("enteredPhoneNum");
    // get values from these objects
    let enteredEmail = emailField.value;
    let enteredPhoneNum = phoneNumField.value;

    let result = true;

    // create an errors paragraph unless on already exists

    let errorsParagraph = document.getElementById("errors");

    if (errorsParagraph)
    {
        errorsParagraph.innerHTML = "";
        // remove it from the body until I know if I need it
        bodyObject.removeChild(errorsParagraph);
    }
    else
    {
        errorsParagraph = document.createElement("p");
        errorsParagraph.id = "errors";
    }

    // check if the contact info entered by the user matches that in the database

    // first, check if both are empty on submit. It is fine if only one is empty.
    // if it is not true after trimming, that means it is empty. 
    if ( (! enteredEmail.trim())  && (! enteredPhoneNum.trim()) )
    {
        errorsParagraph.innerHTML = "The Information Provided is incorrect.";
        result = false;
    }

    // next, check if they entered both email & phone number
    if ( (enteredEmail.trim())  && (enteredPhoneNum.trim()) )
    {
        errorsParagraph.innerHTML = "The Information Provided is incorrect.";
        result = false;
    }

    // now, check if email is incorrect 
    if ( (enteredEmail.trim() != email) && (! enteredPhoneNum.trim()) )
    {
        errorsParagraph.innerHTML = "The Information Provided is incorrect.";
        result = false;
    }

    // now, check if phone number is incorrect 
    if ( (enteredPhoneNum.trim() != phoneNum) && (! enteredEmail.trim()) )
    {
        errorsParagraph.innerHTML = "The Information Provided is incorrect.";
        result = false;
    } 

    
    // this one is just for testing
    if ( enteredPhoneNum.trim() == "testing123" )
    {
        errorsParagraph.innerHTML = "The Information Provided is incorrect.";
        result = false;
    }


    // ONLY add the error paragraph if result is false
    if (result == false)
    {
        // get the DOM object for the submit button of the form
        let submitButtonObject = document.getElementById("submit");

        // insert the error paragraph before the submit button
        bodyObject.insertBefore(errorsParagraph, submitButtonObject);
    }

    return result;
}
 

