document.addEventListener('DOMContentLoaded', () => {
    const passwordField = document.querySelector('.password');
    const eyeIcon = document.querySelector('.eye-icon');
    const loginButton = document.querySelector('button[type="submit"]');
    const signupLink = document.querySelector('.signup-link');
    const countdownElement = document.getElementById('countdown');

    // Show/Hide password
    if (passwordField && eyeIcon) {
        eyeIcon.addEventListener('click', () => {
            passwordField.type = passwordField.type === 'password' ? 'text' : 'password';
            eyeIcon.classList.toggle('bx-show');
            eyeIcon.classList.toggle('bx-hide');
        });
    }

    // Lockout Countdown Timer Logic
    if (typeof remainingTime !== 'undefined' && remainingTime > 0) {
        // Disable login and signup during lockout
        if (loginButton) loginButton.disabled = true;
        if (signupLink) signupLink.style.pointerEvents = 'none';

        function startCountdown(duration, display) {
            let timer = duration;
            const countdownInterval = setInterval(() => {
                const minutes = Math.floor(timer / 60);
                const seconds = Math.floor(timer % 60);
                display.textContent = `Please wait ${minutes}:${seconds < 10 ? '0' : ''}${seconds} to try again.`;

                if (--timer < 0) {
                    clearInterval(countdownInterval);
                    location.reload();  // Reload the page when the lockout ends
                }
            }, 1000);
        }

        startCountdown(remainingTime, countdownElement);
    }

    // Display "Forgot Password?" after 2 wrong attempts
    if (typeof wrongPasswordAttempts !== 'undefined' && wrongPasswordAttempts >= 2) {
        const forgotPasswordMessage = document.createElement('p');
        forgotPasswordMessage.innerHTML = '< href="forgot_password.php">Forgot Password?</ <a href="forgot_password.php">Reset Here</a>';
        forgotPasswordMessage.style.color = 'red';
        forgotPasswordMessage.style.textAlign = 'center';
        document.querySelector('.form-content').prepend(forgotPasswordMessage);
    }

    // Display "Signup" during lockout
    if (signupLink && remainingTime > 0) {
        signupLink.style.display = 'block';  // Show the signup link during lockout
    }
});
