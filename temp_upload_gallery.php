<?php
session_start();
include('config.php');

// Directory where images will be uploaded
$targetDir = "uploads/"; // Make sure this directory exists

if (!is_dir($targetDir)) {
    mkdir($targetDir, 0777, true);
}

if (isset($_FILES['images'])) {
    $files = $_FILES['images'];

    for ($i = 0; $i < count($files['name']); $i++) {
        // Get the original file name and its extension
        $originalFileName = basename($files['name'][$i]);
        $imageFileType = strtolower(pathinfo($originalFileName, PATHINFO_EXTENSION));

        // Generate a unique name using a combination of a unique ID and the original file extension
        $uniqueFileName = uniqid('img_', true) . '.' . $imageFileType;
        $targetFile = $targetDir . $uniqueFileName; // Complete path to save the image

        // Check if the file is an actual image
        $check = getimagesize($files['tmp_name'][$i]);
        if ($check !== false) {
            // Attempt to move the uploaded file to the target directory
            if (move_uploaded_file($files['tmp_name'][$i], $targetFile)) {
                // Insert the image info into the database
                $stmt = $conn->prepare("INSERT INTO gallery (filename, filepath) VALUES (?, ?)");
                $stmt->bind_param("ss", $uniqueFileName, $targetFile); // Store unique name and path
                $stmt->execute();
            } else {
                // Handle error in moving the uploaded file
                echo "Error uploading file: " . $files['name'][$i];
            }
        } else {
            // Handle case where file is not an image
            echo "File is not an image: " . $files['name'][$i];
        }
    }

    $stmt->close(); // Close the statement
    $conn->close(); // Close the database connection

    // Redirect back to the gallery page with feedback
    if ($uploadSuccess) {
        $_SESSION['message'] = "Successfully uploaded: " . implode(", ", $uploadedFiles);
    } else {
        $_SESSION['message'] = "Error uploading files.";
    }

    header("Location: temp_gallery.php");
    exit();
}
?>
