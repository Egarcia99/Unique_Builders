function validateForm() {
    var firstname = document.getElementById("firstname").value;
    var lastname = document.getElementById("lastname").value;
    var email = document.getElementById("email").value;
    var phoneNum = document.getElementById("phoneNum").value;
    var password = document.getElementById("password").value;
    var confirmPassword = document.getElementById("confirmPassword").value;

    // Check if any of the fields are empty
    if (firstname === "" || lastname === "" || email === "" || phoneNum === "" || password === "" || confirmPassword === "") {
        alert("Please fill in all the required fields.");
        return false; // Prevent form submission
    }

    // Check if the first name and last name contain only letters
    var namePattern = /^[A-Za-z]+$/;
    if (!namePattern.test(firstname) || !namePattern.test(lastname)) {
        alert("First name and last name should contain only letters.");
        return false; // Prevent form submission
    }

    // Check if the email has a valid format
    var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
    if (!emailPattern.test(email)) {
        alert("Please enter a valid email address.");
        return false; // Prevent form submission
    }

    // Check if the phone number has a valid format
    var phonePattern = /^\d{10}$/; // Assumes a 10-digit phone number format
    if (!phonePattern.test(phoneNum)) {
        alert("Please enter a valid 10-digit phone number.");
        return false; // Prevent form submission
    }

    // Check if the password and confirmPassword match
    if (password !== confirmPassword) {
        alert("Passwords do not match. Please make sure they match.");
        return false; // Prevent form submission
    }

    return true; // Allow form submission
}