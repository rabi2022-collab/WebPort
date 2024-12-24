// js/storedata.js
window.onload = function() {
    const successMessage = document.getElementById('successMessage');
    const errorMessage = document.getElementById('errorMessage');

    // PHP will inject these values dynamically
    const successText = successMessage.getAttribute('data-success');
    const errorText = errorMessage.getAttribute('data-error');

    if (successText) {
        successMessage.innerText = successText;
        successMessage.classList.add('show');
        
        // Show success message for 5 seconds, then redirect to loading screen
        setTimeout(() => {
            window.location.href = 'loading_screen.php';
        }, 5000);
    }

    if (errorText) {
        errorMessage.innerText = errorText;
        errorMessage.classList.add('show');
        setTimeout(() => { 
            errorMessage.classList.remove('show'); 
        }, 5000);
    }
};