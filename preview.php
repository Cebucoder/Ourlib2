<?php
// Include database configuration
include 'config.php'; // Ensure this file contains your DB connection

// Get the snippet ID from the query string
if (isset($_GET['id'])) {
    $snippetId = $_GET['id'];

    // Prepare and execute the query to fetch the snippet by ID
    $stmt = $conn->prepare("SELECT html_code, css_code, js_code FROM snippet_code WHERE id = ?");
    $stmt->bind_param("i", $snippetId);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if snippet is found
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $htmlCode = $row['html_code'];
        $cssCode = $row['css_code'];
        $jsCode = $row['js_code'];
    } else {
        echo "<h3>No snippet found.</h3>";
        exit;
    }

    // Close the statement
    $stmt->close();
} else {
    echo "<h3>Invalid snippet ID.</h3>";
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Snippet Preview</title>
    <style><?php echo $cssCode; ?></style>
</head>
<body>
    
    <?php echo $htmlCode; ?>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script>
        <?php echo $jsCode; ?>
    </script>

</body>
</html>
