document.addEventListener('DOMContentLoaded', () => {
    let failedAttempts = typeof wrongPasswordAttempts !== 'undefined' ? wrongPasswordAttempts : 0;
    let lockoutDurations = [0, 0, 15, 30, 60];  // Seconds for 0, 3, 6, and 9 attempts
    let maxAttempts = 9;
    let remainingTime = typeof remainingTime !== 'undefined' ? remainingTime : 0;

    // Determine lockout duration based on failed attempts\\
    function getLockoutDuration(attempts) {
        if (attempts >= maxAttempts) return lockoutDurations[3];  // Max 60 seconds after 9th failed attempt
        if (attempts >= 6) return lockoutDurations[2];  // 30 seconds after 6th failed attempt
        if (attempts >= 3) return lockoutDurations[1];  // 15 seconds after 3rd failed attempt
        return 0;  // No lockout for less than 3 attempts
    }

    function lockoutUser(duration, display) {
        startCountdown(duration, display);
        disableForm(true);  // Disable form during lockout
    }

    // Countdown function
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

    function disableForm(disable) {
        const loginButton = document.querySelector('button[type="submit"]');
        const signupLink = document.querySelector('.signup-link');
        if (loginButton) loginButton.disabled = disable;
        if (signupLink) signupLink.style.pointerEvents = disable ? 'none' : 'auto';
    }

    // Lockout logic
    if (remainingTime > 0) {
        lockoutUser(remainingTime, document.getElementById('countdown'));
    }

    // Form submission event
    document.getElementById('login-form').addEventListener('submit', function(event) {
        const loginInput = document.getElementById('username_id').value.trim();
        const passwordInput = document.getElementById('password').value.trim();

        // Client-side validation for empty fields
        if (loginInput === "" || passwordInput === "") {
            event.preventDefault();  // Prevent form submission if validation fails
            alert("Both fields are required.");
            return;
        }

        // Check if in lockout
        if (remainingTime > 0) {
            event.preventDefault();
            alert("You are currently in a lockout period. Please wait.");
            return;
        }

        // Simulate failed attempts
        failedAttempts++;  // Increase the failed attempt count
        if (failedAttempts === 3 || failedAttempts === 6 || failedAttempts === 9) {
            const lockoutDuration = getLockoutDuration(failedAttempts);
            remainingTime = lockoutDuration;  // Set remaining time for lockout
            lockoutUser(lockoutDuration, document.getElementById('countdown'));

            // Save failed attempts and lockout time in session/local storage if needed
            event.preventDefault();  // Prevent form submission if locked out
        }

        // Final lockout and reset after 9th attempt
        if (failedAttempts >= maxAttempts) {
            event.preventDefault();  // Prevent form submission
            const resetMessage = document.createElement('p');
            resetMessage.innerHTML = 'Too many failed attempts. <a href="forgot_password.php">Reset Password</a> or <a href="signup.php">Sign Up</a>';
            resetMessage.style.color = 'red';
            resetMessage.style.textAlign = 'center';
            document.querySelector('.form-content').prepend(resetMessage);

            disableForm(true);  // Disable form completely after max attempts
        }
    });
});
