<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- UNICONS -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
    <!-- CSS -->
    <link rel="stylesheet" href="style.css">
    <!-- Add favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.png" type="image/x-icon">
    <title>Portfolio Website</title>
</head>
<body>
    <div class="container">
        <!-- --------------- HEADER --------------- -->
        <nav id="header">
            <div class="nav-logo">
                <p class="nav-name">RS</p>
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
                        <a href="#projects" class="nav-link">Projects</a>
                        <div class="circle"></div>
                    </li>
                    <li class="nav_list">
                        <a href="#contact" class="nav-link">Contact Me</a>
                        <div class="circle"></div>
                    </li>
                </ul>
            </div>
            <!-- <div class="nav-button">
                <button class="btn" onclick="window.location.href='../login.php'">Login <i class="uil uil-signin"></i></button>
                <button class="btn" onclick="window.location.href='../reg.php'">Register <i class="uil uil-user"></i></button>
            </div> -->
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
                        <span>Randel Silao</span>
                    </div>
                    <div class="featured-name">
                        <p>I'm <span class="typedText"></span></p>
                    </div>
                    <div class="featured-text-info">
                        <p>
                            I am a beginner frontend developer who loves designing websites that look great and are easy to use.
                        </p>
                    </div>
                    <div class="featured-text-btn">
                    </div>
                    <div class="social_icons">
                    </div>
                </div>
                <div class="featured-image">
                    <div class="image">
                        <img src="../img/rs_prof3.png" style="" alt="avatar">
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
                            <h3>My introduction</h3>
                            <p>
                                Hi! I’m just starting my journey in web development. I have basic knowledge of 
                                HTML, CSS, and JavaScript, which I use to create simple and interactive websites. 
                                I’m also learning how to use tools like WordPress to build and manage websites.
                            </p>
                            <div class="about-btn">
                            </div>
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
                                <span>JAVA</span>
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
                    <h1>My Journey</h1>
                </div>
                <div class="project-container">
                    <div class="project-box">
                        <i class="uil uil-briefcase-alt"></i>
                        <h3>Getting Started</h3>
                        <label>Currently learning the basics of programming.</label>
                    </div>
                    <div class="project-box">
                        <i class="uil uil-lightbulb-alt"></i>
                        <h3>Future Goals</h3>
                        <label>Aiming to build cool projects and grow my skills.</label>
                    </div>
                    <div class="project-box">
                        <i class="uil uil-brain"></i>
                        <h3>Open to Ideas</h3>
                        <label>Excited to explore new challenges and collaborate.</label>
                    </div>
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
                            <p><i class="uil uil-envelope"></i> Email: randelsilao@gmail.com</p>
                            <p><i class="uil uil-phone"></i> +63 970 058 3717</p>
                        </div>
                    </div>
                <form action="http://localhost:3000/send" method="POST"  style=" margin-top:-3.5%; ">
                    <div class="col" style=" width:100%;">
                        <div class="form-control">
                            <h2 style="text-align:center; margin-bottom:0px; ">Message Me Here</h2>
                            <div class="form-inputs">
                                <input type="text" name="name" class="input-field" placeholder="Name" required>
                                <input type="email" name="email" class="input-field" placeholder="Email" required>
                            </div>
                            <div class="text-area">
                                <textarea name="message" placeholder="Message" required></textarea>
                            </div>
                            <div class="form-button">
                                <button type="submit" class="btn">Send <i class="uil uil-message"></i></button>
                            </div>
                        </div>
                    </div>
                </form>
                </div>
            </section>
        </main>
        <!-- --------------- FOOTER --------------- -->
        <footer>
            <div class="top-footer">
                <p>Randel Silao .</p>
            </div>
            <div class="middle-footer">
                <ul class="footer-menu">
                    <li class="footer_menu_list">
                        <a href="#home">Home</a>
                    </li>
                    <li class="footer_menu_list">
                        <a href="#about">About</a>
                    </li>
                    <li class="footer_menu_list">
                        <a href="#projects">Projects</a>
                    </li>
                    <li class="footer_menu_list">
                        <a href="#contact">Contact</a>
                    </li>
                </ul>
            </div>
            <div class="footer-social-icons">
                <div class="icon"><i class="uil uil-instagram"></i></div>
                <div class="icon"><i class="uil uil-linkedin-alt"></i></div>
                <div class="icon"><i class="uil uil-twitter"></i></div>
                <div class="icon"><i class="uil uil-github-alt"></i></div>
            </div>
            <div class="bottom-footer">
                <p>Copyright © <a href="#home" style="text-decoration: none;">RS</a> - All rights reserved
                </p>
            </div>
        </footer>
    </div>
    <!-- ----- TYPING JS Link ----- -->
    <script src="https://unpkg.com/typed.js@2.0.16/dist/typed.umd.js"></script>
    <!-- ----- SCROLL REVEAL JS Link----- -->
    <script src="https://unpkg.com/scrollreveal"></script>
    <!-- ----- MAIN JS ----- -->
    <script src="script.js"></script>
</body>

</html>