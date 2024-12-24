<?php
include('components/connect.php');
session_start();

// Check if user is coming from forgot password page
if (!isset($_SESSION['reset_user_id'])) {
    header("Location: forgot-password.php");
    exit();
}

// Fetch user's security question
try {
    $stmt = $conn->prepare("SELECT security_question, id FROM project_g WHERE id = :user_id");
    $stmt->bindParam(':user_id', $_SESSION['reset_user_id'], PDO::PARAM_INT);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $error = "An error occurred. Please try again.";
    error_log("Security question fetch error: " . $e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $security_answer = trim($_POST['security_answer']);

    try {
        // Verify security answer
        $stmt = $conn->prepare("SELECT * FROM project_g 
                                WHERE id = :user_id 
                                AND LOWER(security_answer) = LOWER(:security_answer)");
        $stmt->bindParam(':user_id', $_SESSION['reset_user_id'], PDO::PARAM_INT);
        $stmt->bindParam(':security_answer', $security_answer, PDO::PARAM_STR);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            // Security answer correct, allow password reset
            $_SESSION['security_verified'] = true;
            header("Location: reset-password.php");
            exit();
        } else {
            $error = "Incorrect security answer. Please try again.";
        }
    } catch (PDOException $e) {
        $error = "An error occurred. Please try again.";
        error_log("Security answer verification error: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Security Question</title>
    <link rel="stylesheet" href="css/security-question.css">
</head>
<body>
    <div class="container">
        <div class="forms">
            <div class="form security-question">
                <div class="form-content">
                    <header>Security Question</header>
                    
                    <!-- Error Message -->
                    <?php if (isset($error)): ?>
                        <div class="error-message">
                            <?php echo htmlspecialchars($error); ?>
                        </div>
                    <?php endif; ?>

                    <form action="" method="POST">
                        <div class="field">
                            <label for="security-question">Security Question:</label>
                            <p class="security-question-text">
                                <?php echo htmlspecialchars($user['security_question'] ?? ''); ?>
                            </p>
                        </div>

                        <div class="field input-field">
                            <input type="text" name="security_answer" placeholder="Enter Your Security Answer" class="input" required>
                        </div>

                        <div class="field button-field">
                            <button type="submit">Verify Answer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="js/prevent-view-source.js" defer></script>
</body>
</html>