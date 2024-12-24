<?php
session_start();

// Check if the session is active before attempting to unset and destroy it
if (session_status() === PHP_SESSION_ACTIVE) {
    session_unset(); // Clear session data
    session_destroy(); // Destroy the session
}

// Redirect the user to the login page
header("Location: login.php");
exit();
?>