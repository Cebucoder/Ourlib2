<?php

// Query to get navbar snippets
$query = "SELECT * FROM snippet_code WHERE category = 'buttons'";
$result = $conn->query($query);

// Check for errors in the query
if (!$result) {
    echo "Error: " . $conn->error;
}

// Start the HTML output
?>

<!-- Buttons -->
<div class="prev_con buttons">
    <div class="heading_con">
        <h2 class="heading_def">Buttons</h2>
    </div>
    <div class="prev_con_container">
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="output_viewer">
                    <div class="code_viewer_header">
                        <div class="temp_counter">#0000</div>
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
                        </div>
                    </div>
                    <div class="preview_con">
                        <figure>
                            <img src="<?php echo htmlspecialchars($row['file_path']); ?>" alt="Uploaded buttons Image">
                        </figure>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
                       
            <div class="output_viewer">
                <div class="code_viewer_header">
                    <div class="temp_counter">#0000</div>
                    <div class="head_source_con">
                        <span><a href="javascript:;" target="_blank"><ion-icon title="Preview" class="open-outline" name="expand-outline"></ion-icon></ion-icon></a></span>
                    <span><a href="javascript:;" target="_blank"><ion-icon title="Source Code" class="code-download-outline" name="code-download-outline"></ion-icon></a></span>
                    </div>
                </div>
                <div class="preview_con">
                        <figure><img src="default.png" alt="Ourlib default template"></figure>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
<!-- Buttons -->

<?php
// Close the database connection
// $conn->close();
?>