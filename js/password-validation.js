// Handle password match validation
document.getElementById('cpass').addEventListener('input', function () {
    const password = document.getElementById('pass').value;
    const confirmPassword = document.getElementById('cpass').value;
    const errorMessage = document.getElementById('password-error');

    if (password !== confirmPassword) {
        errorMessage.style.display = 'block';
        errorMessage.textContent = "Passwords do not match!";
        this.closest('.input-field').classList.add('error');  // Add error class to the input field
    } else {
        errorMessage.style.display = 'none';
        this.closest('.input-field').classList.remove('error');  // Remove error class
    }
});

// Toggle password visibility
document.addEventListener("DOMContentLoaded", () => {
    const passwordInput = document.querySelector("#pass");
    const confirmPasswordInput = document.querySelector("#cpass");
    const togglePassword = document.querySelector("#togglePassword");
    const toggleCPassword = document.querySelector("#toggleCPassword");

    // Function to toggle password visibility
    const togglePasswordVisibility = (inputField, icon) => {
        if (inputField.type === "password") {
            inputField.type = "text";
            icon.classList.replace("bx-hide", "bx-show");
        } else {
            inputField.type = "password";
            icon.classList.replace("bx-show", "bx-hide");
        }
    };

    // Event listener for password field
    togglePassword.addEventListener("click", () => {
        togglePasswordVisibility(passwordInput, togglePassword);
    });

    // Event listener for confirm password field
    toggleCPassword.addEventListener("click", () => {
        togglePasswordVisibility(confirmPasswordInput, toggleCPassword);
    });
});

// Password validation with requirements
document.addEventListener("DOMContentLoaded", () => {
    const passwordInput = document.querySelector("#pass");
    const confirmPasswordInput = document.querySelector("#cpass");
    const requirementList = document.querySelectorAll(".requirement-list li");
    const passwordRequirements = document.getElementById("password-requirements");
    const passwordError = document.getElementById("password-error");
    const form = document.querySelector("form");

    const requirements = [
        { regex: /.{8,}/, index: 0 }, // Minimum of 8 characters
        { regex: /[0-9]/, index: 1 }, // At least one number
        { regex: /[a-z]/, index: 2 }, // At least one lowercase letter
        { regex: /[^A-Za-z0-9]/, index: 3 }, // At least one special character
        { regex: /[A-Z]/, index: 4 }, // At least one uppercase letter
    ];

    let isPasswordValid = false;

    passwordInput.addEventListener("focus", () => {
        passwordRequirements.style.display = "block";
    });

    passwordInput.addEventListener("blur", () => {
        passwordRequirements.style.display = "none";
    });

    passwordInput.addEventListener("keyup", (e) => {
        let strength = 0;
        requirements.forEach(item => {
            const isValid = item.regex.test(e.target.value);
            const requirementItem = requirementList[item.index];

            if (isValid) {
                requirementItem.classList.add("valid");
                requirementItem.classList.remove("invalid");
                requirementItem.firstElementChild.className = "fa-solid fa-check"; // Checkmark icon
                strength++;
            } else {
                requirementItem.classList.add("invalid");
                requirementItem.classList.remove("valid");
                requirementItem.firstElementChild.className = "fa-solid fa-circle"; // Circle icon
            }
        });

        isPasswordValid = strength === requirements.length;

        let strengthText = "";
        if (strength < 3) {
            strengthText = "Weak";
        } else if (strength < 5) {
            strengthText = "Medium";
        } else {
            strengthText = "Strong";
        }
        console.log(strengthText); // Optional: Display strength on the UI

        validatePasswordMatch();
    });

    confirmPasswordInput.addEventListener("keyup", () => {
        validatePasswordMatch();
    });

    function validatePasswordMatch() {
        if (passwordInput.value !== confirmPasswordInput.value) {
            passwordError.innerHTML = '<i class="bx bx-error-circle error-icon"></i> Passwords do not match';
            confirmPasswordInput.setCustomValidity("Passwords do not match");
            passwordError.style.color = "white";
        } else {
            passwordError.innerHTML = "";
            confirmPasswordInput.setCustomValidity("");
        }
    }

    form.addEventListener("submit", (event) => {
        if (!isPasswordValid) {
            event.preventDefault();
            alert("Please ensure the password meets all requirements.");
            passwordRequirements.style.display = 'block'; // Show requirements if there's an error
        }

        if (passwordInput.value !== confirmPasswordInput.value) {
            event.preventDefault();
            alert("Passwords do not match.");
        }
    });
});
