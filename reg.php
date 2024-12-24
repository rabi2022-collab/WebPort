<?php 
include 'components/connect.php';

session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Sanitize and validate input
    $first_name = filter_var($_POST["first_name"], FILTER_SANITIZE_STRING);
    $middle_name = filter_var($_POST["middle_name"], FILTER_SANITIZE_STRING);
    $last_name = filter_var($_POST["last_name"], FILTER_SANITIZE_STRING);
    $suffix = !empty($_POST['suffix']) ? filter_var($_POST['suffix'], FILTER_SANITIZE_STRING) : NULL;
    $bdate = $_POST["bdate"];
    $age = filter_var($_POST["age"], FILTER_VALIDATE_INT);
    $zip_code = filter_var($_POST["zip_code"], FILTER_SANITIZE_STRING);
    $country = filter_var($_POST["country"], FILTER_SANITIZE_STRING);
    $province = filter_var($_POST["province"], FILTER_SANITIZE_STRING);
    $city = filter_var($_POST["city"], FILTER_SANITIZE_STRING);
    $barangay = filter_var($_POST["barangay"], FILTER_SANITIZE_STRING);
    $purok = filter_var($_POST["purok"], FILTER_SANITIZE_STRING);
    $username = trim(strtolower(filter_var($_POST["username"], FILTER_SANITIZE_STRING)));
    $email = trim(strtolower(filter_var($_POST["email"], FILTER_SANITIZE_EMAIL)));
    $phone = filter_var($_POST["phone"], FILTER_SANITIZE_STRING);
    $sex = filter_var($_POST["sex"], FILTER_SANITIZE_STRING);
    $occupation = !empty($_POST["occupation"]) ? filter_var($_POST["occupation"], FILTER_SANITIZE_STRING) : NULL;
    $school_id = filter_var($_POST["school_id"], FILTER_SANITIZE_STRING);

    $pass = $_POST['password'];
    $cpass = $_POST['confirm_password'];

    // Security question and answer
    $security_question = $_POST['security_question'] === 'custom' 
        ? filter_var($_POST['custom_security_question'], FILTER_SANITIZE_STRING) 
        : $_POST['security_question'];
    $security_answer = trim(strtolower(filter_var($_POST['security_answer'], FILTER_SANITIZE_STRING)));

    // Validate passwords match
    if ($pass !== $cpass) {
        $_SESSION['error'] = "Passwords do not match!";
        header("Location: reg.php");
        exit();
    }

    // Check uniqueness of username, email, and school_id
    $checks = [
        "username" => $username,
        "email" => $email,
        "school_id" => $school_id
    ];

    foreach ($checks as $field => $value) {
        $stmt = $conn->prepare("SELECT $field FROM project_g WHERE $field = ?");
        $stmt->execute([$value]);
        if ($stmt->rowCount() > 0) {
            $_SESSION['error'] = ucfirst($field) . " is already taken. Please choose another.";
            header("Location: reg.php");
            exit();
        }
    }

    // Hash the password
    $pass_hashed = password_hash($pass, PASSWORD_BCRYPT);

    try {
        // Prepare the SQL statement
        $stmt = $conn->prepare("INSERT INTO project_g (
            first_name, middle_name, last_name, suffix, bdate, age, zip_code, address, country, 
            province, city, barangay, purok, username, email, phone, password, sex, 
            occupation, school_id, security_question, security_answer
        ) VALUES (
            ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
        )");

        // Execute the statement
        $stmt->execute([
            $first_name, $middle_name, $last_name, $suffix, $bdate, $age, $zip_code, $address,
            $country, $province, $city, $barangay, $purok, $username, $email, $phone,
            $pass_hashed, $sex, $occupation, $school_id, $security_question, $security_answer
        ]);

        $_SESSION['success'] = "Registration successful!";
        header("Location: login.php");
        exit();
    } catch (PDOException $e) {
        error_log("Registration Error: " . $e->getMessage());
        $_SESSION['error'] = "An unexpected error occurred. Please try again.";
        header("Location: reg.php");
        exit();
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- CSS Styles -->
     <link rel="stylesheet" href="css/reg.css">

    <!-- Iconscout CSS for Icons -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>

    <title>Responsive Registration Form</title>
</head>
<body>
    <nav class="navbar">
        <div class="nav-container">
            <a href="landing_page/index.php" class="nav-logo">High Tech</a>
            <div class="nav-buttons">
                <a href="landing_page/index.php" class="nav-button">Home</a>
                <a href="login.php" class="nav-button">Login</a>
            </div>
        </div>
    </nav>
    <div id="stars"></div>
    <div id="stars2"></div>
    <div id="stars3"></div>
    
    <div class="container"> 
        <header>
            <i class="uil uil-user icon" style="margin-right: 8px;"></i>Registration
        </header>

        <!-- Success and Error Messages -->
        <div class="success-message" id="successMessage">
            Registration successful!
            <button type="button" onclick="window.location.href='login.php'">Login</button>
        </div>

        <div class="error-message" id="errorMessage">
            <!-- Dynamic error message -->
        </div>

        <form action="" method="POST">
            <div class="form first">
                <!-- Personal Details -->
                <div class="details personal">
                    <span class="title">Personal Details</span>
                    <div class="fields">

                        <div class="input-field">
                            <label>First Name</label>
                            <input type="text" placeholder="Enter your first name" id="first-name" name="first_name" 
                                required minlength="2" maxlength="30" 
                                pattern="^[A-Z][a-z]+(?: [A-Z][a-z]+)?$" 
                                title="First name should start with a capital letter followed by lowercase letters">
                            <span class="error-message" id="first-name-details"></span>
                        </div>

                        <div class="input-field">
                            <label>Middle Name</label>
                            <input type="text" placeholder="Enter your middle name (optional)" id="middle-name" name="middle_name"
                                pattern="^[A-Z][a-z]*$" 
                                title="Middle name must follow capitalization rules">
                            <span class="error-message" id="middle-name-details"></span>
                        </div>

                        <div class="input-field">
                            <label>Last Name</label>
                            <input type="text" placeholder="Enter your last name" id="last-name" name="last_name"
                                required minlength="2" maxlength="30" 
                                pattern="^[A-Z][a-z]+(?: [A-Z][a-z]+)?$" 
                                title="Last name should start with a capital letter followed by lowercase letters">
                            <span class="error-message" id="last-name-details"></span>
                        </div>

                        <div class="input-field">
                            <label>Suffix</label>
                            <select name="suffix" id="suffix">
                                <option value="" disabled selected>Select a suffix (Optional)</option>
                                <option value="jr">Jr</option>
                                <option value="sr">Sr</option>
                                <option value="I">I</option>
                                <option value="II">II</option>
                                <option value="III">III</option>
                                <option value="IV">IV</option>
                                <option value="V">V</option>
                                <option value="IX">IX</option>
                                <option value="X">X</option>
                            </select>
                            <input type="text" id="custom-suffix" name="custom-suffix" placeholder="Enter custom suffix" style="display:none;" pattern="^[A-Za-z0-9]+$" title="Only letters and numbers are allowed">
                        </div>

                        <div class="input-field">
                            <label>Gender</label>
                            <select name="sex" id="sex" required>
                                <option value="" disabled selected>Select gender</option>
                                <option>Male</option>
                                <option>Female</option>
                            </select>
                        </div>

                        <div class="input-field">
                            <label>Occupation</label>
                            <input type="text" id="occupation" name="occupation" placeholder="Enter your occupation (Optional)"
                                minlength="2" maxlength="50" 
                                pattern="^[A-Za-z\s-]+$" 
                                title="Occupation should only contain letters, spaces, and dashes.">
                        </div>

                    </div>
                </div>

                <!-- Identity Details -->
                <div class="details ID">
                    <span class="title">Identity Details</span>
                    <div class="fields">

                        <div class="input-field">
                            <label>School ID</label>
                            <input type="text" name="school_id" id="s_id" placeholder="Enter your School ID" required
                                pattern="\d{4}-\d{1,6}" title="School ID must be in the format YYYY-NNNNN or YYYY-NNNNNN, where YYYY is a 4-digit year and NNNNN/NNNNNN is a 5 or 6-digit number.">
                            <div class="error-message" id="school-id-error"></div>
                        </div>

                        <div class="input-field">
                            <label>Date of Birth</label>
                            <input type="date" id="bdate" name="bdate" required>
                            <div class="error-message" id="birthdate-error"></div>
                        </div>

                        <div class="input-field">
                            <label>Age</label>
                            <input type="number" id="age" name="age" placeholder="Age" required>
                            <div class="error-message" id="age-error"><i class="bx bx-error-circle error-icon"></i></div>
                        </div>

                        <div class="input-field">
                            <label>Email</label>
                            <input type="email" name="email" id="email" placeholder="Enter your email" required>
                            <div class="error-message" id="email-error"></div>
                        </div>

                        <div class="input-field" style="margin-right:34.5%">
                            <label>Mobile Number</label>
                            <input type="tel" name="phone" id="phone" placeholder="Valid No. Ex:09123456789" pattern="[0-9]{11}" required oninput="validatePhoneNumber(this)">
                            <div class="error-message" id="phone-number-error"></div>
                        </div>



                    </div>

                    <!-- Address Details -->
                    <div class="details address">
                        <span class="title">Address Details</span>
                        <div class="fields">

                            <div class="input-field">
                                <label>Country</label>
                                <input type="text" id="country" name="country" placeholder="Enter your country" required>
                            </div>

                            <div class="input-field">
                                <label>Province</label>
                                <input type="text" id="province" name="province" placeholder="Enter your province" required>
                            </div>

                            <div class="input-field">
                                <label>City/Municipality</label>
                                <input type="text" id="city" name="city" placeholder="Enter your city/municipality" required>
                            </div>

                            <div class="input-field">
                                <label>Barangay</label>
                                <input type="text" id="barangay" name="barangay" placeholder="Enter your barangay" required>
                            </div>

                            <div class="input-field">
                                <label>Purok</label>
                                <input type="text" id="purok" name="purok" placeholder="Enter your purok" required>
                            </div>

                            <div class="input-field">
                                <label>Zip Code</label>
                                <input type="number" id="zip-code" name="zip_code" placeholder="12345" pattern="{1,6}" required>
                                <div class="error-message" id="zip-code-error"></div>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- Account Details -->
                <div class="details account">
                    <span class="title">Security Info</span>
                    <div class="fields">
                        <div class="input-field">
                            <label>Security Question</label>
                            <select name="security_question" id="security_question" required>
                                <option value="" disabled selected>Select a security question</option>
                                <option value="What was the name of your first pet?">What was the name of your first pet?</option>
                                <option value="In what city were you born?">In what city were you born?</option>
                                <option value="What is your mother's maiden name?">What is your mother's maiden name?</option>
                                <option value="What was your favorite teacher's name?">What was your favorite teacher's name?</option>
                                <option value="What is your favorite childhood movie?">What is your favorite childhood movie?</option>
                                <option value="custom">Custom Question</option>
                            </select>
                            <input type="text" id="custom_security_question" name="custom_security_question" 
                                placeholder="Enter your custom security question" 
                                style="display:none; margin-top: 10px;" 
                                minlength="10" maxlength="100"
                                title="Enter a unique security question">
                        </div>

                        <div class="input-field">
                            <label>Security Answer</label>
                            <input type="text" id="security_answer" name="security_answer" 
                                placeholder="Enter your security answer" 
                                required minlength="3" maxlength="50"
                                title="Enter a memorable answer to your security question">
                        </div>

                        <div class="input-field" >
                            <label></label>
                            <input type="hidden">
                        </div>
                    </div> 

                <!-- Account Details -->
                <div class="details account">
                    <span class="title">Account Details</span>
                    <div class="fields">

                        <div class="input-field">
                            <label>Username</label>
                            <input type="text" id="username" name="username" placeholder="Enter your username" required>
                        </div>

                        <div class="input-field">
                            <label>Password</label>
                            <input type="password" id="pass" name="password" placeholder="Enter your password" min="5" max="15" required>
                            <i class="bx bx-hide eye-icon" id="togglePassword"></i>
                            <div id="password-requirements" class="requirement-popup">
                                <ul class="requirement-list">
                                    <li><i class="fa-solid fa-circle"></i> Minimum of 8 characters</li>
                                    <li><i class="fa-solid fa-circle"></i> At least one number</li>
                                    <li><i class="fa-solid fa-circle"></i> At least one lowercase letter</li>
                                    <li><i class="fa-solid fa-circle"></i> At least one special character</li>
                                    <li><i class="fa-solid fa-circle"></i> At least one uppercase letter</li>
                                </ul>
                            </div>
                        </div>

                        <div class="input-field">
                            <label>Confirm Password</label>
                            <input type="password" id="cpass" name="confirm_password" placeholder="Confirm your password" required>
                            <i class="bx bx-hide eye-icon" id="toggleCPassword"></i>
                            <!-- Error message for password mismatch -->
                            <div id="password-error" class="error-message"></div>
                        </div>

                        <button type="button" onclick="window.location.href='login.php'">
                            <span class="btnText">Login</span>
                            <i class="uil uil-signin"></i>
                        </button>

                        <button class="submit" type="submit" name="submit">
                            <span class="btnText">Submit</span>
                            <i class="uil uil-navigator"></i>
                        </button>

                    </div> 
                </div>
            </div>
        </form>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
    <script src="js/password.js"></script>
    <script src="./js/profiles.js"></script>
    <script src="js/storedata.js"></script>
    <script src="js/password-validation.js"></script>
    <script src="js/load_screen.js"></script>
    <script src="js/toggle-password.js"></script>
    <script src="js/prevent-view-source.js" defer></script>

    <script>
    // Expose success and error messages via data attributes
    <?php if (isset($_SESSION['success'])): ?>
        document.getElementById('successMessage').setAttribute('data-success', "<?= $_SESSION['success'] ?>");
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        document.getElementById('errorMessage').setAttribute('data-error', "<?= $_SESSION['error'] ?>");
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>
    </script>
<script>
    
</script>
</body>
</html>