// js/login-text-animation.js
const textElement = document.querySelector(".sec-text");

const loadText = () => {
    setTimeout(() => {
        textElement.textContent = "Login";
    }, 0);
    setTimeout(() => {
        textElement.textContent = "Welcome";
    }, 4000);
    setTimeout(() => {
        textElement.textContent = "Sign In";
    }, 8000);
}

loadText();
setInterval(loadText, 12000); // Repeats the text change every 12 seconds