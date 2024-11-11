<?php
session_start();
include 'config.php'; // Include database configuration

// Redirect to login if not logged in
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

// Fetch existing templates
$result = $conn->query("SELECT * FROM snippet_code");
?>

<?php include 'includes/header.php'?>
<?php include 'includes/nav.php'?>
<?php include 'includes/controls.php'?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="style.css"> <!-- Link to your CSS file -->
    <link rel="stylesheet" href="style.css">
    <!-- <style>
        .nav_link_con{display:none;}
    </style> -->
</head>
<body>

<div class="main_con">
        <div class="wrapper">
            <div class="main_content">

            <h2>Welcome, <?php echo htmlspecialchars($_SESSION['admin']); ?></h2>

            <div class="prev_con boxes">
                <div class="heading_con">
                    <h2 class="heading_def">Templates</h2>
                </div> 
                <div class="prev_con_container">
                    <?php if ($result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <div class="output_viewer">
                                <div class="code_viewer_header">
                                    <div class="temp_counter"><?php echo htmlspecialchars($row['id']); ?></div>
                                    <div class="head_source_con">
                                        <span>
                                            <a href="preview.php?id=<?php echo $row['id']; ?>" target="_blank" title="Preview">
                                                <ion-icon class="open-outline" name="expand-outline"></ion-icon>
                                            </a>
                                        </span>
                                        <span>
                                        <a href="view_source.php?id=<?php echo $row['id']; ?>" target="_blank" title="Source Code">
                                                <ion-icon class="code-download-outline" name="code-download-outline"></ion-icon>
                                            </a>
                                        </span>
                                        <span>
                                            <a href="edit_template.php?id=<?php echo $row['id']; ?>" title="Edit">
                                                <ion-icon name="create-outline"></ion-icon>
                                            </a>
                                        </span>
                                        <span>
                                            <form action="admin_dashboard.php" method="POST" style="display:inline;">
                                                <input type="hidden" name="template_id" value="<?php echo $row['id']; ?>">
                                                <button type="submit" name="delete_template" title="Delete">
                                                   <ion-icon name="trash-outline"></ion-icon>
                                                </button>
                                            </form>
                                        </span>
                                    </div>
                                </div>
                                <div class="preview_con">
                                    <figure>
                                        <img src="<?php echo htmlspecialchars($row['file_path']); ?>" alt="Uploaded Template Image" style="width:100%;">
                                    </figure>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <div class="output_viewer">
                            <div class="code_viewer_header">
                                <div class="temp_counter">No templates available</div>
                                <div class="head_source_con">
                                    <span><a href="javascript:;" target="_blank"><ion-icon title="Preview" class="open-outline" name="expand-outline"></ion-icon></a></span>
                                    <span><a href="javascript:;" target="_blank"><ion-icon title="Source Code" class="code-download-outline" name="code-download-outline"></ion-icon></a></span>
                                </div>
                            </div>
                            <div class="preview_con">
                                <figure><img src="default.png" alt="Default Template" style="width:100%;"></figure>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>


        </div>
    </div>
</div> 

<?php
// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Delete Template
    if (isset($_POST['delete_template'])) {
        $template_id = $_POST['template_id'];

        $stmt = $conn->prepare("DELETE FROM snippet_code WHERE id = ?");
        $stmt->bind_param("i", $template_id);
        $stmt->execute();
        $stmt->close();
        header("Location: admin_dashboard.php"); // Redirect to avoid form resubmission
        exit();
    }
}
?>

<?php include 'includes/footer.php'?>

</body>
</html>
