<?php 
// Start the session
session_start();

// Include the database connection file
include 'components/connect.php';

// Define maximum login attempts and lockout times
$max_attempts = 9;
$lockout_times = [15, 30, 60];  // Lockout times after 3, 6, 9 attempts

// Initialize session variables if not set
if (!isset($_SESSION['attempts'])) {
    $_SESSION['attempts'] = 0;
}

if (!isset($_SESSION['wrong_password_attempts'])) {
    $_SESSION['wrong_password_attempts'] = 0;
}

$lockout_time = 0;

// Handle form submission
if (isset($_POST['submit'])) {

    // Display "Forgot Password" message after 2 failed attempts
    if ($_SESSION['wrong_password_attempts'] >= 2 && $_SESSION['wrong_password_attempts'] < 9) {
        $_SESSION['error'] = "Forgot Password? <a href='forgot_password.php'>Reset Here</a>";
    }

    // Handle lockout mechanism and login validation
    if ($_SESSION['attempts'] < $max_attempts) {
        // Sanitize inputs
        $login_input = filter_var(trim($_POST["login_input"]), FILTER_SANITIZE_STRING);
        $password = trim($_POST["password"]);

        // Prepare query to check for username or school_id match
        $sql = "SELECT * FROM project_g WHERE (username = :credential OR password = :credential)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':credential', $login_input);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            // Successful login, reset session variables
            $_SESSION['id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['attempts'] = 0;  // Reset attempts
            $_SESSION['wrong_password_attempts'] = 0;  // Reset wrong attempts
            header("Location: profile/index.php");
            exit();
        } else {
            // Failed login
            $_SESSION['wrong_password_attempts']++;
            $_SESSION['attempts']++;
            $_SESSION['last_attempt_time'] = time();
            $_SESSION['error'] = "Invalid login credentials.";

            // Lockout logic
            $attempts_used = $_SESSION['attempts'];
            if ($attempts_used == 3) {
                $lockout_time = $lockout_times[0]; // 15 seconds after 3 attempts
                $_SESSION['error'] = "You have 6 attempts remaining. Please wait 15 seconds.";
            } elseif ($attempts_used == 6) {
                $lockout_time = $lockout_times[1]; // 30 seconds after 6 attempts
                $_SESSION['error'] = "You have 3 attempts remaining. Please wait 30 seconds.";
            } elseif ($attempts_used == 9) {
                $lockout_time = $lockout_times[2]; // 60 seconds after 9 attempts
                $_SESSION['error'] = "You are locked out for 60 seconds. Please wait and try again.";
            }
        }
    }

    // Lockout behavior: only lockout if the user has failed at 3, 6, or 9 attempts
    if ($_SESSION['attempts'] == 3 || $_SESSION['attempts'] == 6 || $_SESSION['attempts'] == 9) {
        $lockout_index = intdiv($_SESSION['attempts'], 3) - 1;
        if (isset($lockout_times[$lockout_index])) {
            $lockout_time = $lockout_times[$lockout_index];
        }

        // If the user is within a lockout period
        if ((time() - $_SESSION['last_attempt_time']) < $lockout_time) {
            $remaining_time = $lockout_time - (time() - $_SESSION['last_attempt_time']);
            $_SESSION['error'] = "You are locked out. Please wait " . ceil($remaining_time) . " seconds to try again.";
        }
    }

    // Reset after lockout
    if ($_SESSION['attempts'] >= 9 && (time() - $_SESSION['last_attempt_time']) >= 60) {
        $_SESSION['attempts'] = 0;
        $_SESSION['wrong_password_attempts'] = 0;
        $_SESSION['error'] = "You have 9 attempts remaining. If you forgot your password, <a href='forgot_password.php'>Reset Here</a> or <a href='signup.php'>Signup</a>.";
    }

    // Show remaining attempts only if the user hasn't hit the lockout thresholds
    if ($_SESSION['attempts'] < $max_attempts && ($_SESSION['attempts'] % 3 != 0)) {
        $_SESSION['error'] = "You have " . ($max_attempts - $_SESSION['attempts']) . " attempts remaining.";
    }

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/signin.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>
    <nav class="navbar">
        <div class="nav-container">
            <a href="landing_page/index.php" class="nav-logo">High-Tech</a>
            <div class="nav-buttons">
                <a href="landing_page/index.php" class="nav-button">Home</a>
                <a href="reg.php" class="nav-button">Register</a>
            </div>
        </div>
    </nav>
    <div id="stars"></div>
    <div id="stars2"></div>
    <div id="stars3"></div>
    <section class="container forms">
        <!-- Login Form -->
        <div class="form login">
            <div class="form-content">
                <h2 class="heading">
                    <span class="text first-text"><i class="uil uil-user icon">User</i></span>
                    <span class="text sec-text">Login</span>
                </h2>

                <!-- Display error message if there is one -->
                <?php if (isset($_SESSION['error'])): ?>
                    <div class="error-message" style="color: red; text-align: center; margin-bottom: 10px; margin-top: 5px;">
                    <i class="uil uil-sync-exclamation">  </i><?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
                    </div>
                <?php endif; ?>
                
                <form id="login-form" method="POST" action="login.php">
                    <!-- School ID / Username field -->
                    <div class="field input-field">
                        <input type="text" name="login_input" id="username_id" placeholder="School ID / Username" class="input" required>
                    </div>

                    <!-- Password field with show/hide functionality -->
                    <div class="field input-field">
                        <input type="password" name="password" id="password" placeholder="Password" class="password" required>
                        <i class='bx bx-hide eye-icon' id="togglePassword"></i>
                    </div>

                    <!-- Lockout Countdown Timer -->
                    <?php if ($_SESSION['attempts'] >= 3): ?>
                        <div id="countdown" style="text-align: center; color: red; margin-bottom: 10px; margin-top: 5px;">
                            <script>
                                var remainingTime = <?php echo $remaining_time; ?>;
                                if (remainingTime > 0) {
                                    document.getElementById('login-form').querySelector('button').disabled = true;
                                    document.getElementById('signup-link').style.pointerEvents = 'none';
                                }
                            </script>
                        </div>
                    <?php endif; ?>

                    <!-- Remember Me Checkbox -->
                    <div class="form-link" style="text-align: left; margin-bottom: 5px; margin-top: 5px;">
                        <input type="checkbox" id="logCheck"> Remember me
                    </div>

                    <!-- Login Button -->
                    <div class="field button-field">
                        <button type="submit" name="submit">Login</button>
                    </div>

                    <!-- Forgot Password -->
                    <div class="form-link">
                        <a href="forgot_password.php" class="forgot-pass">Forgot password?</a>
                    </div>
                </form>

                <div class="form-link">
                    <span>Don't have an account? 
                        <a href="reg.php" class="link signup-link" id="signup-link">Signup</a>
                    </span>
                </div>
            </div>
        </div>
    </section>

    <!-- JavaScript FILE LINK -->
    <script src="js/login.js"></script>
    <script src="js/script.js"></script>
    <script src="js/login-script.js"></script>
    <script src="js/login-storedata.js"></script>
    <script src="js/login-text-animation.js"></script>
    <script src="js/login-history.js"></script>
    <script src="js/prevent-view-source.js" defer></script>
                                
</body>

</html>