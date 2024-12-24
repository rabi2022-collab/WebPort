<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loading...</title>
    <style>
        /* Simple loading animation */
        .loading {
            width: 50px;
            height: 50px;
            border: 5px solid #f3f3f3;
            border-radius: 50%;
            border-top: 5px solid #3498db;
            animation: spin 1s linear infinite;
            margin: 100px auto;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <div class="loading"></div>
    <p style="text-align: center;">Redirecting to login...</p>

    <script>
        setTimeout(() => {
            window.location.href = 'login.php';
        }, 1500); // Redirect after 1.5 seconds
    </script>

    <script src="js/prevent-view-source.js" defer></script>
</body>
</html>
