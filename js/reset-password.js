document.addEventListener('DOMContentLoaded', function() {
    const newPasswordInput = document.getElementById('new-password');
    const confirmPasswordInput = document.getElementById('confirm-password');
    const togglePasswordBtn = document.getElementById('togglePassword');
    const toggleConfirmPasswordBtn = document.getElementById('toggleConfirmPassword');
    const passwordRequirements = document.getElementById('password-requirements');
    
    // Password visibility toggle
    togglePasswordBtn.addEventListener('click', function() {
        togglePasswordVisibility(newPasswordInput, togglePasswordBtn);
    });

    toggleConfirmPasswordBtn.addEventListener('click', function() {
        togglePasswordVisibility(confirmPasswordInput, toggleConfirmPasswordBtn);
    });

    // Password requirements popup
    newPasswordInput.addEventListener('focus', function() {
        passwordRequirements.style.display = 'block';
    });

    newPasswordInput.addEventListener('blur', function() {
        setTimeout(() => {
            passwordRequirements.style.display = 'none';
        }, 200);
    });

    // Real-time password validation
    newPasswordInput.addEventListener('input', validatePassword);

    function togglePasswordVisibility(passwordField, toggleBtn) {
        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            toggleBtn.classList.replace('bx-hide', 'bx-show');
        } else {
            passwordField.type = 'password';
            toggleBtn.classList.replace('bx-show', 'bx-hide');
        }
    }

    function validatePassword() {
        const password = newPasswordInput.value;
        const requirementsList = document.querySelectorAll('.requirement-list li');

        // Length requirement
        const lengthReq = document.querySelector('.req-length');
        if (password.length >= 8) {
            lengthReq.classList.add('met');
        } else {
            lengthReq.classList.remove('met');
        }

        // Number requirement
        const numberReq = document.querySelector('.req-number');
        if (/\d/.test(password)) {
            numberReq.classList.add('met');
        } else {
            numberReq.classList.remove('met');
        }

        // Lowercase requirement
        const lowercaseReq = document.querySelector('.req-lowercase');
        if (/[a-z]/.test(password)) {
            lowercaseReq.classList.add('met');
        } else {
            lowercaseReq.classList.remove('met');
        }

        // Special character requirement
        const specialReq = document.querySelector('.req-special');
        if (/[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(password)) {
            specialReq.classList.add('met');
        } else {
            specialReq.classList.remove('met');
        }

        // Uppercase requirement
        const uppercaseReq = document.querySelector('.req-uppercase');
        if (/[A-Z]/.test(password)) {
            uppercaseReq.classList.add('met');
        } else {
            uppercaseReq.classList.remove('met');
        }
    }
});