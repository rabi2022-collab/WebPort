<?php
include '../components/connect.php'; // Ensure this path is correct based on your file structure
session_start();

// Check if the user is logged in
if (isset($_SESSION['id'])) {
    $id = $_SESSION['id'];
} else {
    // Redirect to the error page
    header("Location: ../error.php");
    exit();
}

// Fetch user data
$query = $conn->prepare("SELECT `first_name`, `middle_name`, `last_name`, `suffix`, `bdate`, `age`, `zip_code`, `address`, `country`, `province`, `city`, `barangay`, `purok`, `username`, `email`, `phone`, `password`, `sex`, `school_id`, `occupation` FROM `project_g` WHERE `id` = ?");
$query->execute([$id]);
$user = $query->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    die("User not found in the database.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- UNICONS -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
    <!-- CSS -->
    <link rel="stylesheet" href="styles.css">
    <!-- Add favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.png" type="image/x-icon">
    <title>Portfolio Website</title>
</head>
<body>
    <div id="stars"></div>
    <div id="stars2"></div>
    <div id="stars3"></div>
    <div class="container">
        <!-- --------------- HEADER --------------- -->
        <nav id="header">
            <div class="nav-logo">
                <p class="nav-name">Hi,
                    <?php echo htmlspecialchars($user['username']); ?>!
                </p>
                <span>.</span>
            </div>
            <div class="nav-menu" id="myNavMenu">
                <ul class="nav_menu_list">
                    <li class="nav_list">
                        <a href="#home" class="nav-link active-link">Home</a>
                        <div class="circle"></div>
                    </li>
                    <li class="nav_list">
                        <a href="#about" class="nav-link">About</a>
                        <div class="circle"></div>
                    </li>
                    <li class="nav_list">
                        <a href="#projects" class="nav-link">FYI</a>
                        <div class="circle"></div>
                    </li>
                    <li class="nav_list">
                        <a href="#contact" class="nav-link">Contact</a>
                        <div class="circle"></div>
                    </li>
                </ul>
            </div>
            <div class="nav-button">
                <button class="btn" id="logout" onclick="window.location.href='../load_logout.php'">Logout <i class="uil uil-signout"></i></button>
            </div>
            <div class="nav-menu-btn">
                <i class="uil uil-bars" onclick="myMenuFunction()"></i>
            </div>
        </nav>
        <!-- -------------- MAIN ---------------- -->
        <main class="wrapper">
            <!-- -------------- FEATURED BOX ---------------- -->
            <section class="featured-box" id="home">
                <div class="featured-text">
                    <div class="featured-text-card">
                        <span>Welcome, <?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?>!</span>
                    </div>
                    <div class="featured-name">
                        <p>I'm <span class="typedText"></span></p>
                    </div>
                    <div class="featured-text-info">
                        <p>
                            I am a beginner frontend developer who loves designing websites that look great and are easy to use.
                        </p>
                    </div>
                </div>
                <div class="featured-image">
                    <div class="image">
                        <img src="https://raw.githubusercontent.com/tilakjain123/Portfolio/main/01/profile.png" alt="avatar">
                    </div>
                </div>
                <div class="scroll-icon-box">
                    <a href="#about" class="scroll-btn">
                        <i class="uil uil-mouse-alt"></i>
                        <p>Scroll Down</p>
                    </a>
                </div>
            </section>
            <!-- -------------- ABOUT BOX ---------------- -->
            <section class="section" id="about">
                <div class="top-header">
                    <h1>About Me</h1>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="about-info">
                            <h3>My Introduction</h3>
                            <p>
                                Hi! I’m just starting my journey in web development. I have basic knowledge of 
                                HTML, CSS, and JavaScript, which I use to create simple and interactive websites. 
                                I’m also learning how to use tools like WordPress to build and manage websites.
                            </p>
                        </div>
                    </div>
                    <div class="col">
                        <div class="skills-box">
                            <div class="skills-header">
                                <h3>Frontend</h3>
                            </div>
                            <div class="skills-list">
                                <span>HTML</span>
                                <span>CSS</span>
                                <span>Bootstrap</span>
                                <span>JavaScript</span>
                            </div>
                        </div>
                        <div class="skills-box">
                            <div class="skills-header">
                                <h3>Backend</h3>
                            </div>
                            <div class="skills-list">
                                <span>PHP</span>
                                <span>Java</span>
                            </div>
                        </div>
                        <div class="skills-box">
                            <div class="skills-header">
                                <h3>Database</h3>
                            </div>
                            <div class="skills-list">
                                <span>MySQL</span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- -------------- PROJECT BOX ---------------- -->
            <section class="section" id="projects">
                <div class="top-header">
                    <h1>For Your Information</h1>
                </div>
                <div class="project-container">
                    <div class="project-box">
                        <i class="uil uil-briefcase-alt"></i>
                        <h3>Personal Details</h3>
                        <label>Name :
                            <td><?php echo htmlspecialchars($user['first_name'] . ' ' . $user['middle_name'] . ' ' . $user['last_name']  . ' ' . $user['suffix']); ?></td>
                        </label>
                        <label>Gender :
                            <td><?php echo htmlspecialchars($user['sex']); ?></td>
                        </label>
                        <label>Age :
                            <td><?php echo htmlspecialchars($user['age']); ?></td>
                        </label>
                        <label>Birth Day : 
                            <td><?php echo htmlspecialchars($user['bdate']); ?></td>
                        </label>
                        <label></label>
                    </div>
                <div class="project-box">
                    <i class="uil uil-users-alt"></i>
                    <h3>Identity Details</h3>
                    <label>School ID :
                        <td><?php echo htmlspecialchars($user['school_id']); ?></td>
                    </label>
                    <label>Username :
                        <td><?php echo htmlspecialchars($user['username']); ?></td>
                    </label>
                    <label>Email :
                        <td><?php echo htmlspecialchars($user['email']); ?></td>
                    </label>
                    <label>Phone Number : 
                        <td><?php echo htmlspecialchars($user['phone']); ?></td>
                    </label>
                    <label></label>
                </div>
                <div class="project-box"> 
                        <i class="uil uil-map"></i>
                        <h3>Address Details</h3>
                        <label>Country:
                            <td><?php echo htmlspecialchars($user['country']); ?></td>
                        </label>
                        <label>Province:
                            <td><?php echo htmlspecialchars($user['province']); ?></td>
                        </label>
                        <label>City:
                            <td><?php echo htmlspecialchars($user['city']); ?></td>
                        </label>
                        <label>Barangay:
                            <td><?php echo htmlspecialchars($user['barangay']); ?></td>
                        </label>
                </div>
            </section>
            <!-- -------------- CONTACT BOX ---------------- -->
            <section class="section" id="contact">
                <div class="top-header">
                    <h1>Get in touch</h1>
                    <span>Do you have a project in your mind, contact me here</span>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="contact-info">
                            <h2>Find Me <i class="uil uil-corner-right-down"></i></h2>
                            <p><i class="uil uil-envelope"></i> Email: john@doe.com</p>
                            <p><i class="uil uil-phone"></i> +91 23456 7890</p>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-control">
                            <div class="form-inputs">
                                <input type="text" class="input-field" placeholder="Name">
                                <input type="text" class="input-field" placeholder="Email">
                            </div>
                            <div class="text-area">
                                <textarea placeholder="Message"></textarea>
                            </div>
                            <div class="form-button">
                                <button class="btn">Send <i class="uil uil-message"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>
        <!-- --------------- FOOTER --------------- -->
        <!-- FOOTER -->
        <footer>
            <div class="bottom-footer">
                <p>&copy; <?php echo date('Y'); ?>. All rights reserved.</p>
            </div>
        </footer>
    </div>
    </div>
    <!-- ----- TYPING JS Link ----- -->
    <script src="https://unpkg.com/typed.js@2.0.16/dist/typed.umd.js"></script>
    <!-- ----- SCROLL REVEAL JS Link----- -->
    <script src="https://unpkg.com/scrollreveal"></script>
    <!-- ----- MAIN JS ----- -->
    <script src="script.js"></script>
    <script src="../js/logout-prevention.js"></script>
    <script src="../js/prevent-view-source.js" defer></script>

</body>
</html>