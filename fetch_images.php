<?php
include('config.php');

header('Content-Type: application/json');

// Initialize response array
$response = ['images' => []];

// Fetch images from the database
$result = $conn->query("SELECT * FROM gallery");

if ($result) {
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $response['images'][] = [
                'url' => $row['filepath'],
                'id' => $row['id'],
                // 'uploader' => $row['username'],
                // 'upload_time' => $row['uploaded_at'],
            ];
        }
    } else {
        // No images found
        $response['message'] = "No images found.";
    }
} else {
    // Query error
    $response['error'] = "Database query failed: " . $conn->error;
}

$conn->close();

// Return JSON response
echo json_encode($response);
?>
