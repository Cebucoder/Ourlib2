<?php
session_start();
session_unset();
session_destroy();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logging Out</title>
    <style>
        .logout-popup {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            padding: 20px;
            background-color: #333;
            color: #fff;
            border-radius: 8px;
            text-align: center;
            font-family: Arial, sans-serif;
        }
    </style>
    <script>
        // Redirect after 3 seconds
        setTimeout(function() {
            window.location.href = "index.php"; // Change this to your home page
        }, 2000);
    </script>
</head>
<body>
    <div class="logout-popup">
        <p>You have been logged out successfully.</p>
        <p>Redirecting to home page...</p>
    </div>
</body>
</html>
