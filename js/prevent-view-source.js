// prevent-view-source.js

// Disable Right-Click
document.addEventListener('contextmenu', function (e) {
    e.preventDefault();
    alert("Right-click is disabled!");
});

// Disable Keyboard Shortcuts (Ctrl+U, Ctrl+Shift+I, F12)
document.addEventListener('keydown', function (e) {
    // Prevent "View Source" (Ctrl+U or Cmd+U)
    if (e.ctrlKey && (e.key === 'u' || e.key === 'U')) {
        e.preventDefault();
        alert("View Source is disabled!");
    }
    // Prevent "Inspect Element" (Ctrl+Shift+I or Cmd+Shift+I)
    if (e.ctrlKey && e.shiftKey && (e.key === 'i' || e.key === 'I')) {
        e.preventDefault();
        alert("Inspect Element is disabled!");
    }
    // Prevent F12 (Developer Tools Shortcut)
    if (e.key === 'F12') {
        e.preventDefault();
        alert("Developer Tools are disabled!");
    }
    // Prevent Ctrl+Shift+J (Console) or Ctrl+Shift+C (Inspect)
    if (e.ctrlKey && e.shiftKey && (e.key === 'j' || e.key === 'J' || e.key === 'c' || e.key === 'C')) {
        e.preventDefault();
        alert("Developer Tools are disabled!");
    }
});

// Detect and Block Developer Tools Opening
(function () {
    // Monitor for changes in window size (common when DevTools is opened)
    setInterval(function () {
        if (window.outerHeight - window.innerHeight > 100 || window.outerWidth - window.innerWidth > 100) {
            createErrorPage();
        }
    }, 500);

    // Detect debugger usage
    const detectDebugger = function () {
        const check = new Function("debugger; return 1;");
        const result = check();
        if (result === undefined) {
            createErrorPage();
        }
    };
    detectDebugger();

    // Function to create the stylized error page
    function createErrorPage() {
        // Create error page HTML
        const errorHTML = `
        <style>
        @import url("https://fonts.googleapis.com/css?family=Bungee");
        body {
            background: #1b1b1b;
            color: white;
            font-family: "Bungee", cursive;
            margin-top: 50px;
            text-align: center;
        }
        a {
            color: #2aa7cc;
            text-decoration: none;
        }
        a:hover {
            color: white;
        }
        svg {
            width: 50vw;
        }
        .lightblue {
            fill: #444;
        }
        .eye {
            transition: cx 0.2s, cy 0.2s;
        }
        #eye-wrap {
            overflow: hidden;
        }
        .error-text {
            font-size: 120px;
        }
        .alarm {
            animation: alarmOn 0.5s infinite;
        }
        @keyframes alarmOn {
            to {
                fill: darkred;
            }
        }
        </style>
        <svg xmlns="http://www.w3.org/2000/svg" id="robot-error" viewBox="0 0 260 118.9" role="img">
            <title xml:lang="en">403 Error</title>
            <defs>
                <clipPath id="white-clip"><circle id="white-eye" fill="#cacaca" cx="130" cy="65" r="20" /></clipPath>
                <text id="text-s" class="error-text" y="106">403</text>
            </defs>
            <path class="alarm" fill="#e62326" d="M120.9 19.6V9.1c0-5 4.1-9.1 9.1-9.1h0c5 0 9.1 4.1 9.1 9.1v10.6" />
            <use xlink:href="#text-s" x="-0.5px" y="-1px" fill="black"></use>
            <use xlink:href="#text-s" fill="#2b2b2b"></use>
            <g id="robot">
                <g id="eye-wrap">
                    <use xlink:href="#white-eye"></use>
                    <circle id="eyef" class="eye" clip-path="url(#white-clip)" fill="#000" stroke="#2aa7cc" stroke-width="2" stroke-miterlimit="10" cx="130" cy="65" r="11" />
                    <ellipse id="white-eye" fill="#2b2b2b" cx="130" cy="40" rx="18" ry="12" />
                </g>
                <circle class="lightblue" cx="105" cy="32" r="2.5" id="tornillo" />
                <use xlink:href="#tornillo" x="50"></use>
                <use xlink:href="#tornillo" x="50" y="60"></use>
                <use xlink:href="#tornillo" y="60"></use>
            </g>
        </svg>
        <h1>You are not allowed to enter here</h1>
        <h2>Go <a target="_blank" href="index.php">Home!</a></h2>
        <script>
        var root = document.documentElement;
        var eyef = document.getElementById('eyef');
        var cx = document.getElementById("eyef").getAttribute("cx");
        var cy = document.getElementById("eyef").getAttribute("cy");
        document.addEventListener("mousemove", evt => {
            let x = evt.clientX / innerWidth;
            let y = evt.clientY / innerHeight;
            root.style.setProperty("--mouse-x", x);
            root.style.setProperty("--mouse-y", y);
            
            cx = 115 + 30 * x;
            cy = 50 + 30 * y;
            eyef.setAttribute("cx", cx);
            eyef.setAttribute("cy", cy);
        });
        document.addEventListener("touchmove", touchHandler => {
            let x = touchHandler.touches[0].clientX / innerWidth;
            let y = touchHandler.touches[0].clientY / innerHeight;
            root.style.setProperty("--mouse-x", x);
            root.style.setProperty("--mouse-y", y);
        });
        </script>
        `;

        // Replace entire document content
        document.open();
        document.write(errorHTML);
        document.close();
    }
})();

// Disrupt Debugging with Infinite Debugger Statements
(function preventDebugging() {
    setInterval(() => {
        debugger; // Triggers every time DevTools is open
    }, 100);
})();

// Disable Dragging of Content
document.addEventListener('dragstart', function (e) {
    e.preventDefault();
});

// Warn Users in the Console
if (typeof console !== "undefined") {
    console.log(
        "%cSTOP!",
        "color: red; font-size: 40px; font-weight: bold; text-shadow: 2px 2px black;"
    );
    console.log(
        "%cDo not paste code here. It can steal your information or harm the site.",
        "color: orange; font-size: 20px;"
    );
}