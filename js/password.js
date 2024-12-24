const passwordInput = document.getElementById("password");
const confirmPasswordInput = document.getElementById("confirm-password");
const confirmPasswordError = document.getElementById("confirm-password-error");

passwordInput.addEventListener("input", validatePassword);
confirmPasswordInput.addEventListener("input", validatePassword);

function validatePassword() {
    const password = passwordInput.value;
    const confirmPassword = confirmPasswordInput.value;
    const regex = /^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?!.*[:;,"'/\\ ])[A-Za-z\d]{8,20}$/;

    if (regex.test(password)) {
        confirmPasswordError.textContent = "";

        if (password === confirmPassword) {
            confirmPasswordError.textContent = "Passwords match!";
        } else {
            confirmPasswordError.textContent = "Passwords do not match.";
        }
    } else {
        confirmPasswordError.textContent =
            "Password must be 8-20 characters, contain at least one uppercase letter, one lowercase letter, one number, and no special characters or spaces.";
    }
}

function togglePassword(inputId) {
    const passwordInput = document.getElementById(inputId);
    const eyeIcon = document.getElementById(`toggle-${inputId}`);

    if (passwordInput.type === "password") {
        passwordInput.type = "text";
        eyeIcon.className = "bx bx-show eye-icon";
    } else {
        passwordInput.type = "password";
        eyeIcon.className = "bx bx-hide eye-icon";
    }
}

