document.addEventListener('DOMContentLoaded', (event) => {
    // Function to set a cookie
    function setCookie(name, value, days) {
        const d = new Date();
        d.setTime(d.getTime() + (days * 24 * 60 * 60 * 1000));
        const expires = "expires=" + d.toUTCString();
        document.cookie = name + "=" + value + ";" + expires + ";path=/";
    }

    // Function to get a cookie
    function getCookie(name) {
        const cname = name + "=";
        const decodedCookie = decodeURIComponent(document.cookie);
        const ca = decodedCookie.split(';');
        for (let i = 0; i < ca.length; i++) {
            let c = ca[i];
            while (c.charAt(0) == ' ') {
                c = c.substring(1);
            }
            if (c.indexOf(cname) == 0) {
                return c.substring(cname.length, c.length);
            }
        }
        return "";
    }

    // Check if cookies exist and fill the form
    const rememberedUsername = getCookie("username_id");
    const rememberedPassword = getCookie("password");
    if (rememberedUsername && rememberedPassword) {
        document.getElementById('username_id').value = rememberedUsername;
        document.getElementById('password').value = rememberedPassword;
        document.getElementById('logCheck').checked = true;
    }

    // Form submission event
    document.getElementById('login-form').addEventListener('submit', function(event) {
        // Client-side validation for empty fields
        const loginInput = document.getElementById('username_id').value.trim();
        const passwordInput = document.getElementById('password').value.trim();
        if (loginInput === "" || passwordInput === "") {
            event.preventDefault();  // Prevent form submission if validation fails
            alert("Both fields are required.");
            return;
        }

        // Remember Me functionality
        if (document.getElementById('logCheck').checked) {
            setCookie('username_id', document.getElementById('username_id').value, 30);
            setCookie('password', document.getElementById('password').value, 30);
        } else {
            setCookie('username_id', '', 0);
            setCookie('password', '', 0);
        }
    });

    // Countdown timer if lockout is in effect
    if (typeof remainingTime !== 'undefined') {
        var countdownElement = document.getElementById('countdown');

        function startCountdown(duration, display) {
            var timer = duration, minutes, seconds;
            var countdownInterval = setInterval(function () {
                minutes = parseInt(timer / 60, 10);
                seconds = parseInt(timer % 60, 10);

                minutes = minutes < 10 ? "0" + minutes : minutes;
                seconds = seconds < 10 ? "0" + seconds : seconds;

                display.textContent = "Please wait " + minutes + ":" + seconds + " to try again.";

                if (--timer < 0) {
                    clearInterval(countdownInterval);
                    location.reload();  // Reload the page once the timer reaches 0
                }
            }, 1000);
        }

        startCountdown(remainingTime, countdownElement);

        // Disable form elements during lockout
        document.getElementById('login-form').querySelectorAll('input, button').forEach(function(element) {
            element.disabled = true;
        });
    }
});
