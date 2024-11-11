<?php
session_start();
include 'config.php';

if (!isset($_SESSION['admin'])) {
    header("Location: unauthorized.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get and validate POST variables
    $templateId = $_POST['template_id'] ?? null; // Updated to match form input name
    $title = $_POST['category'] ?? '';
    $html_code = $_POST['html_code'] ?? '';
    $css_code = $_POST['css_code'] ?? '';
    $js_code = $_POST['js_code'] ?? '';

    // // Debugging: Confirm POST variables
    // var_dump($templateId, $title, $html_code, $css_code, $js_code);

    // Validate inputs
    if (!$templateId || !$title || !$html_code || !$css_code || !$js_code) {
        die("Invalid input data.");
    }

    $stmt = $conn->prepare("UPDATE snippet_code SET category = ?, html_code = ?, css_code = ?, js_code = ? WHERE id = ?");
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("ssssi", $title, $html_code, $css_code, $js_code, $templateId);
    if ($stmt->execute()) {
        $success_message = "Template updated successfully!";
    } else {
        die("Execute failed: " . $stmt->error);
    }

    $stmt->close();

    header("Location: admin_dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Template</title>
    <link rel="stylesheet" href="styles.css"> <!-- Your CSS file -->
    <style>
        /* Basic styles for the notification popup */
        .notification {
            display: none; /* Hidden by default */
            position: fixed;
            top: 20px;
            right: 20px;
            background-color: #4CAF50; /* Green background */ 
            color: white; /* White text */
            padding: 15px;
            border-radius: 5px;
            z-index: 1000; /* Ensure it appears above other content */
        }`
        .wrapper{max-width:;}
    </style>
</head>
<body>

<!-- Your form and other content here -->

<div class="notification" id="successNotification">
    <?php if ($success_message): ?>
        <?php echo $success_message; ?>
    <?php endif; ?>
</div>

<script>
    // Show notification if there is a success message
    window.onload = function() {
        var successMessage = document.getElementById('successNotification');
        if (successMessage.innerHTML.trim() !== '') {
            successMessage.style.display = 'block'; // Show the notification
            setTimeout(function() {
                successMessage.style.display = 'none'; // Hide after 3 seconds
            }, 3000);
        }
    };
</script>

</body>
</html>