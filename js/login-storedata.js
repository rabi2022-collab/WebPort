// js/login-storedata.js
window.onload = function() {
    const errorMessageContainer = document.querySelector('.error-message');
    
    if (errorMessageContainer) {
        const errorText = errorMessageContainer.getAttribute('data-error');
        
        if (errorText) {
            // If there's a lockout countdown
            const remainingTime = parseInt(errorMessageContainer.getAttribute('data-remaining-time') || '0');
            
            if (remainingTime > 0) {
                const loginForm = document.getElementById('login-form');
                const submitButton = loginForm.querySelector('button[type="submit"]');
                const signupLink = document.getElementById('signup-link');
                
                submitButton.disabled = true;
                signupLink.style.pointerEvents = 'none';
                
                // Start countdown timer
                const countdownElement = document.createElement('div');
                countdownElement.id = 'countdown';
                countdownElement.style.textAlign = 'center';
                countdownElement.style.color = 'red';
                countdownElement.style.marginBottom = '10px';
                countdownElement.style.marginTop = '5px';
                
                errorMessageContainer.parentNode.insertBefore(countdownElement, errorMessageContainer.nextSibling);
                
                let timeLeft = remainingTime;
                const countdownInterval = setInterval(() => {
                    if (timeLeft > 0) {
                        countdownElement.textContent = `Please wait ${timeLeft} seconds`;
                        timeLeft--;
                    } else {
                        clearInterval(countdownInterval);
                        submitButton.disabled = false;
                        signupLink.style.pointerEvents = 'auto';
                        countdownElement.remove();
                    }
                }, 1000);
            }
        }
    }
};