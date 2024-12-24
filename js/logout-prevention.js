let isLoggingOut = false;

// Disable the unload warning when the user logs out
function logoutUser() {
    isLoggingOut = true;
    window.location.href = "../logout.php"; // Redirect to your logout page
}

window.onbeforeunload = function (e) {
    if (!isLoggingOut) {
        const confirmationMessage = "Are you sure you want to leave? Please press the Logout button to exit properly.";
        e.preventDefault();
        e.returnValue = confirmationMessage;
        return confirmationMessage;
    }
};