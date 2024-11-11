<?php
// config.php

// Database configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'ourlib_db');

// Application settings
define('APP_ENV', 'development'); // or 'production'
define('DEBUG_MODE', true);

// Create a connection
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check connection
if ($conn->connect_error) {
    if (DEBUG_MODE) {
        die("Connection failed: " . $conn->connect_error);
    } else {
        die("Connection failed. Please try again later.");
    }
}
?>
