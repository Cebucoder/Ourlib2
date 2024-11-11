<?php
session_start();
include 'config.php';
include 'includes/header.php';
include 'includes/nav.php';

// Redirect to login if not logged in
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

// Fetch the template to be edited
$templateId = isset($_GET['id']) ? (int)$_GET['id'] : null;
$template = null;

// echo "Template ID: $templateId<br>";
if ($templateId !== null) {
    $stmt = $conn->prepare("SELECT * FROM snippet_code WHERE id = ?");
    if ($stmt) {
        $stmt->bind_param("i", $templateId);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                // echo "Template found!<br>";
                $template = $result->fetch_assoc();
            } else {
                echo "No template found for ID $templateId.<br>";
            }
        } else {
            echo "Query execution failed: " . $stmt->error . "<br>";
        }
        $stmt->close(); // Always close the statement
    } else {
        echo "Failed to prepare the SQL statement.<br>";
    }
} else {
    echo "No template ID provided.<br>";
}

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
    <style>
        .template-preview{
            max-width: 200px;
            display: block;}
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
        }
    </style>
</head>
<body>

    <?php include 'includes/controls.php'?>
</nav>
<!-- Nav -->

<div class="main_con">
        <div class="wrapper">
            <div class="main_content">
            <div class="heading_con">
                    <h2 class="heading_def">
                        Template ID: <span><?php echo $templateId; ?></span> 
                        <!-- <span id=""><?php echo $template['category'];?></span> -->
                    </h2>
                </div>
                <div class="upload_container">
                <?php if ($template): ?>
                <form action="update_template.php" method="POST" enctype="multipart/form-data" onsubmit="setEditorContent()">
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
                                    <option value="navbar" <?= $template['category'] === 'navbar' ? 'selected' : '' ?>>Navbar</option>
                                    <option value="banner" <?= $template['category'] === 'banner' ? 'selected' : '' ?>>Banner</option>
                                    <option value="boxes" <?= $template['category'] === 'boxes' ? 'selected' : '' ?>>Boxes</option>
                                    <option value="buttons" <?= $template['category'] === 'buttons' ? 'selected' : '' ?>>Buttons</option>
                                    <option value="text" <?= $template['category'] === 'text' ? 'selected' : '' ?>>Text</option>
                                    <option value="footer" <?= $template['category'] === 'footer' ? 'selected' : '' ?>>Footer</option>
                                    <option value="gsap" <?= $template['category'] === 'gsap' ? 'selected' : '' ?>>GSAP</option>
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
                            <input type="hidden" name="html_code" id="html_code" value="<?= htmlspecialchars($template['html_code']) ?>" required>
                            <input type="hidden" name="css_code" id="css_code" value="<?= htmlspecialchars($template['css_code']) ?>" required>
                            <input type="hidden" name="js_code" id="js_code" value="<?= htmlspecialchars($template['js_code']) ?>" required>
                            <input type="hidden" name="template_id" value="<?= $templateId ?>">
                        </div>
                    <!-- Thumbnail Display and Upload -->
                    <div class="upld_thumb_con">
                        <span class="thumb_note">Current Template Preview Image</span>
                        <?php if (!empty($template['file_path'])): ?>
                            <img src="<?php echo htmlspecialchars($template['file_path']); ?>" alt="Template Preview Image" class="template-preview">
                        <?php else: ?>
                            <p>No preview image available.</p>
                        <?php endif; ?>
                        
                        <span class="thumb_note">Select an image to update the thumbnail</span>
                        <div class="file_upld">
                            <label for="upld_thumb">Browse</label>
                            <input id="upld_thumb" type="file" name="image" accept="image/*">
                            <span class="file-name" id="file_name">No file chosen</span>
                        </div>
                    </div>
                        <button type="submit">Update Template</button>
                    </form>
                    <?php else: ?>
                <p>Template not found.</p>
            <?php endif; ?>

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
<!-- <script src="js/monaco.js"></script> -->


<script>
    const fileInput = document.getElementById('upld_thumb');
    const fileNameDisplay = document.getElementById('file_name');

    fileInput.addEventListener('change', function() {
        const fileName = fileInput.files[0] ? fileInput.files[0].name : 'No file chosen';
        fileNameDisplay.textContent = fileName;
    });
</script>

<script>
    $(document).ready(function () {
    $(".front_end_lang .upld_btn").on("click", function () {
        // Get the target class from data-target
        var target = $(this).data("target");

        // Hide all code containers and show only the selected one
        $(".upld_code_con").hide();
        $("." + target).show();

        // Remove 'active' class from all buttons and add it to the clicked button
        $(".upld_btn").removeClass("active");
        $(this).addClass("active");
    });


    require.config({ paths: { vs: 'https://cdnjs.cloudflare.com/ajax/libs/monaco-editor/0.31.1/min/vs' } });

    require(['vs/editor/editor.main'], function () {
        const editorOptions = {
            theme: 'vs-dark',
            // fontFamily: '"Inconsolata", monospace',
            fontFamily: 'monospace',
            fontSize: 14,
            letterSpacing: 0, // default is 0
            lineHeight: 0,
            automaticLayout: true
        };


        // Initialize HTML, CSS, and JS editors with font settings
        const htmlEditor = monaco.editor.create(document.getElementById('html_code_editor'), {
            value: document.getElementById('html_code').value,
            language: 'html',
            ...editorOptions
        });

        const cssEditor = monaco.editor.create(document.getElementById('css_code_editor'), {
            value: document.getElementById('css_code').value,
            language: 'css',
            ...editorOptions
        });

        const jsEditor = monaco.editor.create(document.getElementById('js_code_editor'), {
            value: document.getElementById('js_code').value,
            language: 'javascript',
            ...editorOptions
        });

        // Set editor container heights to 600px
        document.getElementById('html_code_editor').style.height = "600px";
        document.getElementById('css_code_editor').style.height = "600px";
        document.getElementById('js_code_editor').style.height = "600px";

        // Set editor content in hidden fields before form submission
        window.setEditorContent = function () {
            document.getElementById('html_code').value = htmlEditor.getValue();
            document.getElementById('css_code').value = cssEditor.getValue();
            document.getElementById('js_code').value = jsEditor.getValue();
        };
    });
});
</script>

</body>
</html>
