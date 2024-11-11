<?php
session_start();
include 'config.php';

// Redirect to unauthorized.php if the user is not an admin
if (!isset($_SESSION['admin'])) {
    header("Location: unauthorized.php");
    exit();
}

// Set the content type to JSON
header('Content-Type: application/json');

// Enable error reporting for debugging (remove in production)
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Read the incoming JSON request
$data = json_decode(file_get_contents("php://input"), true);
$imageId = isset($data['id']) ? intval($data['id']) : 0;

$response = ['success' => false];

// Check if $imageId is valid, then delete the image
if ($imageId > 0) {
    $stmt = $conn->prepare("DELETE FROM gallery WHERE id = ?");
    $stmt->bind_param("i", $imageId);
    
    if ($stmt->execute()) {
        $response['success'] = true;
    } else {
        $response['message'] = 'Failed to delete image';
    }
    $stmt->close();
} else {
    $response['message'] = 'Invalid image ID';
}

// Close the connection
$conn->close();

// Echo the JSON response
echo json_encode($response);
?>
