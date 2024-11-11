<?php session_start();
include 'config.php'; // Include database configuration

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
?>
<?php include 'includes/header.php'?>
<?php include 'includes/nav.php'?>
<?php include 'includes/controls.php'?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Gallery Upload</title>
    <link rel="stylesheet" href="style.css">
    <style>
.nav_link_con{display:none;}
#gallery {
display: grid;
grid-template-columns: 1fr 1fr 1fr 1fr 1fr;
gap: 40px 15px;
}

.gall_con figure img {
width: 100%;
height: 100%;
object-fit: cover;
border-radius: 10px;
}
.gall_con figure {
width: 100%;
height: 200px;
overflow: hidden;
}
.gall_con {
display: flex;
flex-direction: column;
gap: 15px;
max-width: 250px;
width: 100%;
min-height: 200px;
}
.inp_btn {
width: 100%;
display: flex;
gap: 10px;
justify-content: space-between;
}
.inp_btn input {
width: 100%;
height: 40px;
padding: 0 10px;
font-size: 15px;
border-radius:5px;
border:none;
}
.inp_btn {
gap: 10px;
}
.inp_btn button {
width: 40px;
height: 40px;
background: #e1306c;
color: #fff;
border: none;
padding: 5px;
font-size:20px;
cursor: pointer;
border-radius:5px;
}

#loading {
  width: 100%;
  text-align: center;
  height: 600px;
  display: flex;
  align-items: center;
  justify-content: center;
}

/* HTML: <div class="loader"></div> */
.loader {
  width: 20px;
  aspect-ratio: 1;
  border-radius: 50%;
  background: #e1306c;
  box-shadow: 0 0 0 0 #faf9f6;
  animation: l1 1s infinite;
}
@keyframes l1 {
    100% {box-shadow: 0 0 0 30px #0000}
}


.gallery-upload {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    margin: 20px 0;
    padding: 30px;
    background: #1f1f1f;
    border-radius: 10px;
}
.gallery-display {
    margin-top: 100px;
}


.gallery-upload h1 {
    margin-bottom: 90px;
}



.dropzone {
    width: 100%;
    background: #f9f9f91c;
    height: 200px;
    border: 2px dashed #ccc;
    border-radius: 5px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-wrap: wrap;
    gap: 10px;
    padding: 20px;
    position: relative;
    cursor: pointer;
    color: #777;
}

.dropzone.dragover {
    background-color: #e0e0e0;
}

.dropzone input[type="file"] {
    display: none;
}



#uploadForm {
    width: 100%;
}

#uploadForm button {
    display: center;
    padding: 20px 30px;
    background: #e1306c;
    color: #fff;
    border-radius: 5px;
    border: none;
    font-size: 14px;
    display: flex;
    margin:25px auto;
    cursor: pointer;
}






.thumbnail {
    position: relative;
    width: 70px;
    height: 70px;
    border-radius: 5px;
    border: 1px solid #ddd;
    background-color: #fff;
}

.thumbnail img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

#thumbnail-container {
    display: flex;
    justify-content: center;
    width: 309px;
    margin-top: 25px;
    margin: 25px auto;
    position: relative;
    gap: 5px;
}

.thumbnail.plus_img {
    background: #1f1f1f;
    display: flex;
    align-items: center;
    justify-content: end;
}


.thumbnail img {
    border-radius: 5px;
    width: 100%;
    height: 100%;
    object-fit:cover;
}

.thumbnail .remove-btn {
    top: 2px;
    right: 2px;
    width: 25px  !important;
    height: 25px !important;
    display: flex;
    align-items: center;
    justify-content: center;
    position: absolute;
    z-index: 22;
    padding:5px !important;
    margin:0 !important;
    cursor: pointer;
}

div.thumbnail:nth-child(4) {
background: #0f0f0f;
display: flex;
align-items: center;
justify-content: center;
}



.admin-info {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-top: 10px;
}

.uploader-name {
    font-size: 12px;
    color: #ccc;
}

.info-icon {
    font-size: 16px;
    color: #e1306c;
    position: relative;
    cursor: pointer;
}

.tooltip {
    display: none;
    position: absolute;
    top: -30px;
    left: 0;
    background-color: #333;
    color: #fff;
    padding: 5px;
    font-size: 12px;
    border-radius: 5px;
    white-space: nowrap;
}


    </style>
</head>
<body>

<div class="main_con">
        <div class="wrapper">
            <div class="main_content">
                <div class="heading_con">
                    <h2 class="heading_def">Upload Images to Gallery</h2>
                </div> 
                <div class="gallery-upload">
                <form id="uploadForm" action="temp_upload_gallery.php" method="POST" enctype="multipart/form-data">
                    <div id="dropzone" class="dropzone" onclick="document.getElementById('fileInput').click()">
                        <span>Click or drag images here to upload</span>
                        <input type="file" id="fileInput" name="images[]" multiple>
                    </div>
                    <button type="submit">Upload Images</button>
                    <div id="thumbnail-container" class="thumbnail-container"></div>
                </form>
                </div>
                
                <div class="gallery-display">
                <div class="heading_con">
                    <h2 class="heading_def">Uploaded Images</h2>
                </div>
                    <div id="gallery">

                    </div>
                    <div id="loading" style="display: none;"><div class="loader"></div></div> <!-- Loading indicator -->
                </div>

        </div>
    </div>
</div>    

    <?php include 'includes/footer.php'?>

<script>
    const dropzone = document.getElementById('dropzone');
    const fileInput = document.getElementById('fileInput');
    const uploadForm = document.getElementById('uploadForm');
    const gallery = document.getElementById('gallery');
    const thumbnailContainer = document.getElementById('thumbnail-container');
    let selectedFiles = [];

    // Drag and Drop events
    dropzone.addEventListener('dragover', (e) => {
        e.preventDefault();
        dropzone.classList.add('dragover');
    });

    dropzone.addEventListener('dragleave', () => {
        dropzone.classList.remove('dragover');
    });

    dropzone.addEventListener('drop', (e) => {
        e.preventDefault();
        dropzone.classList.remove('dragover');
        handleFiles(e.dataTransfer.files);
    });

    fileInput.addEventListener('change', (e) => {
        handleFiles(e.target.files);
    });

    function handleFiles(files) {
    Array.from(files).forEach(file => {
        if (!file.type.startsWith('image/')) return;
        selectedFiles.push(file);
        displayThumbnail(file);
    });
    updateFileInput(); // Update the actual file input element
}

    function updateFileInput() {
        const dataTransfer = new DataTransfer();
        selectedFiles.forEach(file => dataTransfer.items.add(file));
        fileInput.files = dataTransfer.files;
    }


    function displayThumbnail(file) {
        thumbnailContainer.innerHTML = ''; // Clear previous thumbnails if the limit exceeds 4

        const displayFiles = selectedFiles.slice(0, 3); // Show first 3 images
        displayFiles.forEach(file => {
            const thumbnailDiv = document.createElement('div');
            thumbnailDiv.className = 'thumbnail';

            const img = document.createElement('img');
            img.src = URL.createObjectURL(file);

            const removeBtn = document.createElement('button');
            removeBtn.className = 'remove-btn';
            removeBtn.innerHTML = '<ion-icon name="close-outline"></ion-icon>';
            removeBtn.onclick = () => {
                thumbnailDiv.remove();
                selectedFiles = selectedFiles.filter(f => f !== file);
                displayThumbnail();
            };

            thumbnailDiv.appendChild(img);
            thumbnailDiv.appendChild(removeBtn);
            thumbnailContainer.appendChild(thumbnailDiv);
        });

        // Show the count of remaining files (if any)
        if (selectedFiles.length > 3) {
            const remainingCount = selectedFiles.length - 3;
            const remainingDiv = document.createElement('div');
            remainingDiv.className = 'thumbnail';
            remainingDiv.innerText = `+${remainingCount} more`;
            thumbnailContainer.appendChild(remainingDiv);
        }
    }

    // Form validation: Check if files are selected before submitting
    uploadForm.addEventListener('submit', (e) => {
        if (selectedFiles.length === 0) {
            e.preventDefault();
            dropzone.classList.add('error'); // Turn dropzone red if no files are selected
        } else {
            dropzone.classList.remove('error'); // Remove red state if files are selected
        }
    });

    // Reset dropzone after successful upload
    function resetDropzone() {
        selectedFiles = []; // Clear selected files
        thumbnailContainer.innerHTML = ''; // Clear thumbnails
        dropzone.classList.remove('error'); // Remove red state
    }

    // Load existing images in the gallery (as defined in your initial script)
    function loadImages() {
        document.getElementById('loading').style.display = 'flex';
        fetch('fetch_images.php')
            .then(response => response.json())
            .then(data => {
                gallery.innerHTML = '';
                data.images.forEach(image => {
                    const gallCon = document.createElement('div');
                    gallCon.className = 'gall_con';

                    const figure = document.createElement('figure');
                    const imgElement = document.createElement('img');
                    imgElement.src = image.url;
                    imgElement.alt = "Uploaded Image";
                    figure.appendChild(imgElement);
                    gallCon.appendChild(figure);


                    // Admin Info Section
                    const adminInfo = document.createElement('div');
                    adminInfo.className = 'admin-info';

                    // Username text
                    const usernameText = document.createElement('span');
                    usernameText.className = 'uploader-name';
                    usernameText.textContent = image.uploader;

                    // Tooltip icon
                    const infoIcon = document.createElement('ion-icon');
                    infoIcon.name = 'information-circle-outline';
                    infoIcon.className = 'info-icon';

                    // Tooltip for additional details
                    const tooltip = document.createElement('div');
                    tooltip.className = 'tooltip';
                    tooltip.textContent = `Uploaded by: ${image.uploader} on ${image.upload_time}`;
                    
                    // Append elements
                    infoIcon.appendChild(tooltip);
                    adminInfo.appendChild(usernameText);
                    adminInfo.appendChild(infoIcon);

                    // CSS for hover effect
                    infoIcon.onmouseover = () => tooltip.style.display = 'block';
                    infoIcon.onmouseout = () => tooltip.style.display = 'none';

                    // Create div for input and button
                    const inpBtnDiv = document.createElement('div');
                    inpBtnDiv.className = 'inp_btn';

                    // Create input for image URL
                    const linkElement = document.createElement('input');
                    linkElement.type = "text";
                    linkElement.value = image.url; // Display the URL of the image
                    linkElement.readOnly = true;

                    // Create copy button
                    const copyButton = document.createElement('button');

                    // Set the icon using innerHTML
                    copyButton.innerHTML = '<ion-icon name="clipboard-outline"></ion-icon>';

                    // OnClick event for copying text
                    copyButton.onclick = () => {
                        linkElement.select();
                        document.execCommand("copy");

                        // Change the button text to 'Copied!'
                        copyButton.innerHTML = '<ion-icon name="checkmark-outline"></ion-icon>';

                        // After 2 seconds, revert the button back to the original state
                        setTimeout(() => {
                            copyButton.innerHTML = '<ion-icon name="clipboard-outline"></ion-icon>';
                        }, 2000);
                    };

                    // Create delete button
                    const deleteButton = document.createElement('button');
                    deleteButton.innerHTML = '<ion-icon name="trash-outline"></ion-icon>';
                    deleteButton.onclick = () => showDeleteConfirmation(image.id, gallCon);

                    // Append input and button to inp_btn div
                    inpBtnDiv.appendChild(linkElement);
                    inpBtnDiv.appendChild(copyButton);
                    inpBtnDiv.appendChild(deleteButton);

                    // Append inp_btn div to gallCon
                    gallCon.appendChild(inpBtnDiv);
                    gallery.appendChild(gallCon);
                });
            })

            .catch(error => console.error('Error fetching images:', error))
            .finally(() => {
                document.getElementById('loading').style.display = 'none';
            });
    }


    // Function to show the delete confirmation popup
        function showDeleteConfirmation(imageId, gallCon) {
            if (confirm("Are you sure you want to delete this image?")) {
                deleteImage(imageId, gallCon);
            }
        }

        // Function to delete image from database
        function deleteImage(imageId, gallCon) {
            fetch('delete_image.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id: imageId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    gallCon.remove(); // Remove the image element from the DOM
                } else {
                    alert("Failed to delete the image.");
                }
            })
            .catch(error => console.error('Error deleting image:', error));
        }

    window.onload = loadImages;
</script>
</body>
</html>
