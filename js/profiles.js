// Function to validate all fields before proceeding to the next form
function validateForm() {
    let isValid = true; // Assume form is valid unless proven otherwise

    // Validate First Name
    if (!validateFirstName(firstNameInput.value)) {
        firstNameDetails.textContent = "Invalid First Name. Only letters allowed and one space.";
        firstNameInput.setCustomValidity("Invalid First Name.");
        isValid = false;
    } else {
        firstNameDetails.textContent = "";
        firstNameInput.setCustomValidity(""); // Reset error
    }

    // Validate Middle Name
    if (!validateMiddleName(middleNameInput.value)) {
        middleNameDetails.textContent = "Invalid Middle Name. Only letters allowed.";
        middleNameInput.setCustomValidity("Invalid Middle Name.");
        isValid = false;
    } else {
        middleNameDetails.textContent = "";
        middleNameInput.setCustomValidity(""); // Reset error
    }

    // Validate Last Name
    if (!validateLastName(lastNameInput.value)) {
        lastNameDetails.textContent = "Invalid Last Name. Only letters allowed.";
        lastNameInput.setCustomValidity("Invalid Last Name.");
        isValid = false;
    } else {
        lastNameDetails.textContent = "";
        lastNameInput.setCustomValidity(""); // Reset error
    }

    // Ensure First Name, Middle Name, and Last Name do not match
    if (!validateNamesNotMatching(firstNameInput.value, middleNameInput.value, lastNameInput.value)) {
        lastNameDetails.textContent = "First Name, Middle Name, and Last Name must not match.";
        isValid = false;
    }

    // Validate Suffix
    const suffix = document.getElementById("suffix");
    if (suffix.value === "") {
        suffix.setCustomValidity("Please select a suffix.");
        isValid = false;
    } else {
        suffix.setCustomValidity("");
    }

    // Validate Gender
    const gender = document.getElementById("gender");
    if (gender.value === "") {
        gender.setCustomValidity("Please select a gender.");
        isValid = false;
    } else {
        gender.setCustomValidity("");
    }

    // Validate Phone Number
    const phone = document.getElementById("phone");
    const phoneError = document.getElementById("phone-number-error");
    if (phoneError.textContent !== "") {
        isValid = false;
        phone.setCustomValidity("Invalid phone number.");
    } else {
        phone.setCustomValidity("");
    }

    // Validate Email
    const email = document.getElementById("email");
    const emailError = document.getElementById("email-error");
    if (emailError.textContent !== "") {
        isValid = false;
        email.setCustomValidity("Invalid email.");
    } else {
        email.setCustomValidity("");
    }

    // Validate Age
    const ageError = document.getElementById("age-error");
    if (ageError.textContent !== "") {
        isValid = false;
    }

    // Additional field validations
    const requiredFields = document.querySelectorAll("input[required], select[required]");
    requiredFields.forEach(field => {
        if (!field.checkValidity()) {
            isValid = false;
            field.reportValidity(); // Shows built-in HTML validation message
        }
    });

    // If all validations pass, proceed
    if (isValid) {
        alert("Form is valid! Proceeding to next section.");
        // Proceed to the next form or enable the next section.
    } else {
        alert("Please correct the errors before proceeding.");
    }
}

// Example validation functions

// Validation for the first name allowing only one space
function validateFirstName(firstName) {
    const firstNamePattern = /^[A-Z][a-zA-Z]+( [A-Za-z]+)?$/; // Allows exactly one space for two-part names
    const noGibberishPattern = /(.)\1{2,}/; // Prevents repeated characters like "Arrrron"

    // Validate format and check for gibberish patterns
    return firstNamePattern.test(firstName) && !noGibberishPattern.test(firstName);
}

// Validation for middle name (single word)
function validateMiddleName(middleName) {
    const middleNamePattern = /^[A-Z][a-zA-Z]+$/; // Only allows letters, no spaces or special characters
    const noGibberishPattern = /(.)\1{2,}/; // Prevents repeated characters like "Aaa"

    return middleNamePattern.test(middleName) && !noGibberishPattern.test(middleName);
}

// Validation for last name (single word)
function validateLastName(lastName) {
    const lastNamePattern = /^[A-Z][a-zA-Z]+$/; // Only allows letters, no spaces or special characters
    const noGibberishPattern = /(.)\1{2,}/; // Prevents repeated characters like "Lllllast"

    return lastNamePattern.test(lastName) && !noGibberishPattern.test(lastName);
}

// Ensure first name, middle name, and last name do not match
function validateNamesNotMatching(firstName, middleName, lastName) {
    return firstName !== middleName && firstName !== lastName && middleName !== lastName;
}

function validateEmail(email) {
    const errorMessage = document.getElementById("email-error");
    const emailPattern = /^[A-Za-z0-9._%+-]+@gmail\.com$/;
    return emailPattern.test(email);
}

function validateZipCode(zipCode) {
    const zipCodePattern = /^\d{1,6}$/;
    return zipCodePattern.test(zipCode);
}

function validateSchoolID(input) {
    const errorMessage = document.getElementById("school-id-error");
    const phoneRegex = /^09\d{9}$/;

    if (!phoneRegex.test(input.value)) {
        errorMessage.innerText = "Please enter a valid phone number starting with '09'.";
        input.setCustomValidity("Invalid phone number.");
    } else {
        errorMessage.innerText = "";
        input.setCustomValidity("");
    }
}

function validatePhoneNumber(input) {
    const errorMessage = document.getElementById("phone-number-error");
    const phoneRegex = /^09\d{9}$/;

    if (!phoneRegex.test(input.value)) {
        errorMessage.innerText = "Please enter a valid phone number starting with '09'.";
        input.setCustomValidity("Invalid phone number.");
    } else {
        errorMessage.innerText = "";
        input.setCustomValidity("");
    }
}


// Calculate Age and validate it
function calculateAge() {
    const birthDateInput = document.getElementById('bdate');
    const ageInput = document.getElementById('age');
    const ageError = document.getElementById('age-error');

    if (birthDateInput.value) {
        const birthDate = new Date(birthDateInput.value);
        const currentDate = new Date();
        let age = currentDate.getFullYear() - birthDate.getFullYear();

        if (currentDate.getMonth() < birthDate.getMonth() || 
            (currentDate.getMonth() === birthDate.getMonth() && currentDate.getDate() < birthDate.getDate())) {
            age--;
        }

        ageInput.value = age;

        if (age < 18) {
            ageError.textContent = 'You must be at least 18 years old.';
            birthDateInput.setCustomValidity('You must be at least 18 years old.');
        } else {
            ageError.textContent = '';
            birthDateInput.setCustomValidity('');
        }
    } else {
        ageInput.value = '';
        ageError.textContent = '';
        birthDateInput.setCustomValidity('');
    }
}

// Add event listeners for validation on blur/change
document.getElementById("email").addEventListener("blur", function () {
    validateEmailField(this);
});

document.getElementById("bdate").addEventListener("change", calculateAge);

// Trigger age calculation on page load (if a birthdate is already selected)
calculateAge();

// Event listener for the birth date input
var bdateInput = document.getElementById("bdate");
bdateInput.addEventListener("change", calculateAge);

 // Function to validate email
function validateEmail(email) {
    const emailPattern = /^[A-Za-z0-9._%+-]+@gmail\.com$/; // Only allow Gmail addresses
    return emailPattern.test(email);
}

// Event listener for email validation
document.getElementById("email").addEventListener("blur", function () {
    const emailInput = this;
    const emailError = document.getElementById("email-error");
    
    const emailValue = emailInput.value;
    
    if (validateEmail(emailValue)) {
        // Email is valid
        emailError.textContent = ""; // Clear any previous error message
    } else {
        // Email is invalid
        emailError.textContent = "Invalid email. Please use a Gmail address.";
        emailInput.focus(); // Set focus back to the input field
    }
});

  // Function to validate the zip code
function validateZipCode(zipCode) {
    const zipCodePattern = /^\d{1,6}$/; // Zip code pattern: exactly 5 digits
    return zipCodePattern.test(zipCode);
}

// Event listener for zip code validation
document.getElementById("zip-code").addEventListener("blur", function () {
    const zipCodeInput = this;
    const zipCodeError = document.getElementById("zip-code-error");
    
    const zipCodeValue = zipCodeInput.value;
    
    if (validateZipCode(zipCodeValue)) {
        // Zip code is valid
        zipCodeError.textContent = ""; // Clear any previous error message
    } else {
        // Zip code is invalid
        zipCodeError.textContent = "Invalid zip code. Please enter a 5-digit zip code.";
        zipCodeInput.focus(); // Set focus back to the input field
    }
});


function validateUsername() {
        var username = document.getElementById("username").value;

        // Use a regular expression to check for at least one special character and one number
        var regex = /^(?=.*[!@#$%^&*(),.?":{}|<>0-9])/;

        if (!regex.test(username)) {
            alert("Username must contain at least one special character and one number.");
            return false;
        }

        return true;
    }

// Function to validate email
function validateEmail(email) {
    // Regular expression to match a basic email format
    const emailPattern = /^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$/;
    return emailPattern.test(email);
}

// Add event listener to validate the email field on blur (when the user leaves the field)
document.getElementById("email").addEventListener("blur", function () {
    const emailInput = this;
    const emailError = document.getElementById("email-error");
    
    // Get the value of the email input
    const emailValue = emailInput.value;
    
    // Validate the email format
    if (validateEmail(emailValue)) {
        // Email is valid
        emailError.textContent = ""; // Clear any previous error message
        emailInput.setCustomValidity(""); // Reset custom validity
    } else {
        // Email is invalid
        emailError.textContent = "Invalid email. Please enter a valid email address.";
        emailInput.setCustomValidity("Invalid email.");
        emailInput.focus(); // Optionally set focus back to the input field
    }
});
