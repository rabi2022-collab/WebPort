<?php
include('components/connect.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Sanitize and validate the input
    $credential = trim($_POST['credential']); // Accept username, email, or school ID

    if (empty($credential)) {
        $error = "Please enter a username, email, or school ID!";
    } else {
        try {
            // Prepare the SQL query to check for the credential
            $query = "SELECT * FROM project_g WHERE 
                      username = :credential OR 
                      email = :credential OR 
                      school_id = :credential";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':credential', $credential, PDO::PARAM_STR);
            $stmt->execute();

            // Check if a matching record exists
            if ($stmt->rowCount() === 0) {
                $error = "No account found with that username, email, or school ID.";
            } else {
                // If account exists, fetch the user details
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
                
                // Store user information in session for next step
                $_SESSION['reset_user_id'] = $user['id'];
                
                // Redirect to a security question page
                header("Location: security-question.php");
                exit();
            }
        } catch (PDOException $e) {
            $error = "An error occurred. Please try again later.";
            error_log("Password reset error: " . $e->getMessage());
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="css/forgot-password.css">
</head>
<body>
    <div class="container">
        <div class="forms">
            <div class="form forgot">
                <div class="form-content">
                    <header>Forgot Password</header>
                    
                    <!-- Error Message -->
                    <?php if (isset($error)): ?>
                        <div class="error-message">
                            <?php echo htmlspecialchars($error); ?>
                        </div>
                    <?php endif; ?>

                    <form action="" method="POST">
                        <div class="field input-field">
                            <input type="text" name="credential" placeholder="Enter Username, Email, or School ID" class="input" required>
                        </div>

                        <div class="field button-field">
                            <button type="submit">Verify Account</button>
                        </div>

                        <div class="form-link">
                            <span>Remember your password? <a href="login.php" class="link login-link">Login</a></span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="js/prevent-view-source.js" defer></script>
</body>
</html>