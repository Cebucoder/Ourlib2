<?php
session_start();
include 'config.php'; // Include database configuration


if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

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
            
            $stmt = $conn->prepare("INSERT INTO snippet_code (file_name, file_path, html_code, css_code, js_code, category) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssss", $fileName, $uploadFile, $htmlCode, $cssCode, $jsCode, $category);

            // Execute the statement and check for errors
            if ($stmt->execute()) {
                echo "<h4>Image details and code snippets saved to database successfully.</h4>";
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
    <link rel="stylesheet" href="css/upload_template.css"> <!-- Include your CSS file -->
    <link rel="stylesheet" href="style.css"> <!-- Include your CSS file -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/monaco-editor/0.31.1/min/vs/editor/editor.main.css">
    
</head>
<body>

<!-- Nav -->
<nav>
    <div class="nav">
        <div class="wrapper">
            <div class="nav_con">
                <div class="logo_con">
                    <!-- <figure><img src="" alt=""></figure> -->
                    <h1>Our<span>lib.</span></h1>
                </div> 
            </div>
        </div>
    </div>

    <?php include 'includes/controls.php'?>
</nav>
<!-- Nav -->

<div class="main_con">
        <div class="wrapper">
            <div class="main_content">
                <div class="upload_container">
                <form action="upload_template.php" method="POST" enctype="multipart/form-data" onsubmit="setEditorContent()">
                    <div class="upld_header">
                        <div class="front_end_lang">
                            <div class="html_btn upld_btn active" data-target="html_code_con">HTML</div>
                            <div class="css_btn upld_btn" data-target="css_code_con">CSS</div>
                            <div class="js_btn upld_btn" data-target="js_code_con">JS</div>
                        </div>
                        <div class="categ_and_upld_btn">
                            <div class="upld_category_con">
                                <label for="category">Choose a category:</label>
                                <select name="category" id="category" required>
                                    <option value="navbar">Navbar</option>
                                    <option value="banner">Banner</option>
                                    <option value="boxes">Boxes</option>
                                    <option value="Buttons">Buttons</option>
                                    <option value="text">Text</option>
                                    <option value="footer">Footer</option>
                                    <option value="gsap">Gsap</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- <form action="upload_template.php" method="POST" enctype="multipart/form-data" onsubmit="setEditorContent()"> -->
                        <div class="upld_code_area">
                            <!-- HTML Editor -->
                            <div id="html_code_editor" class="html_code_con upld_code_con" style="display:block;"></div>
                            <!-- CSS Editor -->
                            <div id="css_code_editor" class="css_code_con upld_code_con" style="display:none;"></div>
                            <!-- JS Editor -->
                            <div id="js_code_editor" class="js_code_con upld_code_con" style="display:none;"></div>

                            <!-- Hidden Fields to Store Monaco Editor Content -->
                            <input type="hidden" name="html_code" id="html_code" required>
                            <input type="hidden" name="css_code" id="css_code" required>
                            <input type="hidden" name="js_code" id="js_code" required>
                        </div>
                        <div class="upld_thumb_con">
                            <span class="thumb_note">Select an image to use for the thumbnail</span>
                            <div class="file_upld">
                            <label for="upld_thumb">Browse</label>
                            <input id="upld_thumb" type="file" name="image" accept="image/*" required>
                            <span class="file-name" id="file_name">No file chosen</span>
                            </div>
                        </div>
                        <button type="submit">Upload</button>
                    </form>

                </div>
            </div>                
        </div>                
</div> 


<footer>
    <div class="footer">
        <div class="wrapper">
            <div class="footer_con">
                <p>&copy; Copyright 2024 Created by <a id="getOrigin" href="" target="_blank">CebuCoder</a></p>
            </div>
        </div>
    </div>
</footer>
    
</body>


<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/monaco-editor/0.31.1/min/vs/loader.js"></script>
<script src="js/monaco.js"></script>
<script>
    const fileInput = document.getElementById('upld_thumb');
    const fileNameDisplay = document.getElementById('file_name');

    fileInput.addEventListener('change', function() {
        const fileName = fileInput.files[0] ? fileInput.files[0].name : 'No file chosen';
        fileNameDisplay.textContent = fileName;
    });
</script>
</body>
</html>





<!-- <h1>Upload an Image</h1>
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
</form> -->
