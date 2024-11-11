<?php
session_start();
include 'config.php'; // Ensure this file is included

// Enable error reporting for debugging
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

// Handle file upload
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['image'])) {
        // Check for file upload error
        if ($_FILES['image']['error'] !== UPLOAD_ERR_OK) {
            echo "<h3>Error uploading file. Code: " . $_FILES['image']['error'] . "</h3>";
            exit; // Stop further processing if there's an error
        }

        // File and database configuration
        $uploadDir = 'temp_images/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true); // Create directory if it doesn't exist
        }

        // Generate a unique file name to prevent overwriting
        $fileName = uniqid('img_', true) . '.' . pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $uploadFile = $uploadDir . basename($fileName);

        // Move the uploaded file
        if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
            echo "<h4>File uploaded successfully!</h4>";

            // Prepare and bind SQL statement
            $stmt = $conn->prepare("INSERT INTO images (file_name, file_path) VALUES (?, ?)");
            $stmt->bind_param("ss", $fileName, $uploadFile);

            // Execute the statement and check for errors
            if ($stmt->execute()) {
                echo "<h4>Image details saved to database successfully.</h4>";
            } else {
                echo "<h4>Error saving image details to database: " . $stmt->error . "</h4>";
            }

            // Close the statement
            $stmt->close();
        } else {
            echo "<h3>Error moving uploaded file.</h3>";
        }
    } else {
        echo "<h3>No file uploaded.</h3>";
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Upload</title>
</head>
<body>

    <h1>Upload an Image</h1>
    <form action="upload_template.php" method="POST" enctype="multipart/form-data">
        <input type="file" name="image" accept="image/*" required>
        <button type="submit">Upload</button>
    </form>

</body>
</html>
