<?php
session_start();
include 'config.php'; // Include database configuration

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

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
            $htmlCode = $_POST['html_code'];
            $cssCode = $_POST['css_code'];
            $jsCode = $_POST['js_code'];
            $category = $_POST['category'];
            
            // Prepare SQL statement
            $stmt = $conn->prepare("INSERT INTO snippet_code (file_name, file_path, html_code, css_code, js_code, category) VALUES (?, ?, ?, ?, ?, ?)");
            if ($stmt === false) {
                echo "Error preparing statement: " . $conn->error;
                exit; // Stop further processing if there's an error
            }

            $stmt->bind_param("ssssss", $fileName, $uploadFile, $htmlCode, $cssCode, $jsCode, $category);

            // Execute the statement and check for errors
            if ($stmt->execute()) {
                echo "<h4>Image details and code snippets saved to database successfully.</h4>";

                // Display the uploaded image
                echo '<h5>Uploaded Image:</h5>';
                echo '<img src="' . htmlspecialchars($uploadFile) . '" alt="Uploaded Image" style="max-width: 300px; height: auto;">';

                // Generate dynamic HTML based on category
                if ($category == "navbar") {
                    echo '<!-- Banner -->
                    <div class="prev_con banner">
                        <div class="heading_con">
                            <h2 class="heading_def">Banner</h2>
                        </div>
                        <div class="prev_con_container">
                            <div class="output_viewer">
                                <div class="code_viewer_header">
                                    <div class="temp_counter">#0000</div>
                                    <div class="head_source_con">
                                        <span><a href="https://cebucoder.github.io/Ourlib/temp_lib/navbar/Template1/" target="_blank"><ion-icon title="Preview" class="open-outline" name="expand-outline"></ion-icon></a></span>
                                        <span><a href="https://cebucoder.github.io/Ourlib/temp_lib/navbar/Template1/Template.txt" target="_blank"><ion-icon title="Source Code" class="code-download-outline" name="code-download-outline"></ion-icon></a></span>
                                    </div>
                                </div>
                                <div class="preview_con">
                                        <figure><img src="temp_lib/images/default.png" alt="Ourlib default template"></figure>
                                </div>
                            </div>                       
                        </div>
                    </div>
                    <!-- Banner -->';
                }
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
    <title>Image Upload with Code Snippets</title>
    <link rel="stylesheet" href="styles.css"> <!-- Include your CSS file -->
</head>
<body>

<h1>Upload an Image</h1>
<form action="upload_template.php" method="POST" enctype="multipart/form-data">
    <input type="file" name="image" accept="image/*" required>
    
    <label for="category">Choose a category:</label>
    <select name="category" id="category" required>
        <option value="navbar">Navbar</option>
        <option value="boxes">Boxes</option>
        <option value="image">Image</option>
    </select>
    
    <textarea name="html_code" placeholder="Enter HTML code here" required></textarea>
    <textarea name="css_code" placeholder="Enter CSS code here" required></textarea>
    <textarea name="js_code" placeholder="Enter JavaScript code here" required></textarea>
    
    <button type="submit">Upload</button>
</form>

</body>
</html>
