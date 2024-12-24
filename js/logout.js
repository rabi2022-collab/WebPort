function logoutUser() {
    // Dynamically add the stylesheet
    const head = document.head;
    const link = document.createElement('link');
    link.rel = 'stylesheet';
    link.href = '../css/logout.css'; // Path to your CSS file
    head.appendChild(link);

    // Show the loading screen
    document.body.innerHTML = `
    <div class="hexagon" aria-label="Animated hexagonal ripples">
        <div class="hexagon__group">
            <div class="hexagon__sector"></div>
            <div class="hexagon__sector"></div>
            <div class="hexagon__sector"></div>
            <div class="hexagon__sector"></div>
            <div class="hexagon__sector"></div>
            <div class="hexagon__sector"></div>
        </div>
        <div class="hexagon__group">
            <div class="hexagon__sector"></div>
            <div class="hexagon__sector"></div>
            <div class="hexagon__sector"></div>
            <div class="hexagon__sector"></div>
            <div class="hexagon__sector"></div>
            <div class="hexagon__sector"></div>
        </div>
        <div class="hexagon__group">
            <div class="hexagon__sector"></div>
            <div class="hexagon__sector"></div>
            <div class="hexagon__sector"></div>
            <div class="hexagon__sector"></div>
            <div class="hexagon__sector"></div>
            <div class="hexagon__sector"></div>
        </div>
        <div class="hexagon__group">
            <div class="hexagon__sector"></div>
            <div class="hexagon__sector"></div>
            <div class="hexagon__sector"></div>
            <div class="hexagon__sector"></div>
            <div class="hexagon__sector"></div>
            <div class="hexagon__sector"></div>
        </div>
        <div class="hexagon__group">
            <div class="hexagon__sector"></div>
            <div class="hexagon__sector"></div>
            <div class="hexagon__sector"></div>
            <div class="hexagon__sector"></div>
            <div class="hexagon__sector"></div>
            <div class="hexagon__sector"></div>
        </div>
        <div class="hexagon__group">
            <div class="hexagon__sector"></div>
            <div class="hexagon__sector"></div>
            <div class="hexagon__sector"></div>
            <div class="hexagon__sector"></div>
            <div class="hexagon__sector"></div>
            <div class="hexagon__sector"></div>
        </div>
    </div>
    <p aria-label="Loading">Logging out...</p>
    `;

    // Submit the form after a delay
    setTimeout(() => {
        document.getElementById('logoutForm').submit();
    }, 10000); // 2-second delay
}