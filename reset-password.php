<?php 
include 'components/connect.php';
session_start();

// Ensure user has passed security verification
if (!isset($_SESSION['security_verified']) || !$_SESSION['security_verified']) {
    header("Location: forgot-password.php");
    exit();
}

// Ensure we know which user is resetting password
if (!isset($_SESSION['reset_user_id'])) {
    header("Location: forgot-password.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if ($new_password !== $confirm_password) {
        $error = "Passwords do not match!";
    } elseif (!preg_match('/^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*\W).{8,}$/', $new_password)) {
        $error = "Password must meet the strength requirements!";
    } else {
        $new_password_hashed = password_hash($new_password, PASSWORD_BCRYPT);

        try {
            // Update password for the specific user
            $stmt = $conn->prepare(
                "UPDATE project_g 
                SET password = :password 
                WHERE id = :user_id"
            );
            $stmt->bindParam(':password', $new_password_hashed);
            $stmt->bindParam(':user_id', $_SESSION['reset_user_id'], PDO::PARAM_INT);
            $stmt->execute();

            // Clear session variables
            unset($_SESSION['reset_user_id']);
            unset($_SESSION['security_verified']);

            $_SESSION['success'] = "Password reset successfully. You can now login.";
            header("Location: login.php");
            exit();
        } catch (PDOException $e) {
            $error = "Failed to update password. Please try again.";
            error_log("Error updating password: " . $e->getMessage());
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/reset-password.css">
</head>
<body>
    <div class="container">
        <div class="forms">
            <div class="form reset">
                <div class="form-content">
                    <header>Reset Password</header>
                    
                    <!-- Error Message -->
                    <?php if (isset($error)): ?>
                        <div class="error-message">
                            <?php echo htmlspecialchars($error); ?>
                        </div>
                    <?php endif; ?>

                    <form action="" method="POST">
                        <div class="field input-field">
                            <input type="password" name="new_password" id="new-password" placeholder="New Password" class="password" required>
                            <i class="bx bx-hide eye-icon" id="togglePassword"></i>
                            <div id="password-requirements" class="requirement-popup">
                                <ul class="requirement-list">
                                    <li class="req-length"><i class="fa-solid fa-circle"></i> Minimum of 8 characters</li>
                                    <li class="req-number"><i class="fa-solid fa-circle"></i> At least one number</li>
                                    <li class="req-lowercase"><i class="fa-solid fa-circle"></i> At least one lowercase letter</li>
                                    <li class="req-special"><i class="fa-solid fa-circle"></i> At least one special character</li>
                                    <li class="req-uppercase"><i class="fa-solid fa-circle"></i> At least one uppercase letter</li>
                                </ul>
                            </div>
                        </div>

                        <div class="field input-field">
                            <input type="password" name="confirm_password" id="confirm-password" placeholder="Confirm New Password" class="password" required>
                            <i class="bx bx-hide eye-icon" id="toggleConfirmPassword"></i>
                        </div>

                        <div class="field button-field">
                            <button type="submit">Reset Password</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="js/reset-password.js"></script>
    <script src="js/prevent-view-source.js" defer></script>

</body>
</html>