<?php
session_start();
include 'config.php'; // Include database configuration

// Redirect to login if not logged in
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

// Fetch existing templates
$result = $conn->query("SELECT * FROM templates");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
</head>
<body>

<h2>Welcome, <?php echo htmlspecialchars($_SESSION['admin']); ?></h2>
<a href="logout.php">Logout</a>

<h3>Templates</h3>

<!-- Display Existing Templates -->
<table>
    <thead>
        <tr>
            <th>Title</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['title']); ?></td>
                <td>
                    <a href="edit_template.php?id=<?php echo $row['id']; ?>">Edit</a>
                    <form action="admin_dashboard.php" method="POST" style="display:inline;">
                        <input type="hidden" name="template_id" value="<?php echo $row['id']; ?>">
                        <button type="submit" name="delete_template">Delete</button>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<?php
// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Delete Template
    if (isset($_POST['delete_template'])) {
        $template_id = $_POST['template_id'];

        $stmt = $conn->prepare("DELETE FROM templates WHERE id = ?");
        $stmt->bind_param("i", $template_id);
        $stmt->execute();
        $stmt->close();
        header("Location: admin_dashboard.php"); // Redirect to avoid form resubmission
        exit();
    }
}
?>

</body>
</html>
