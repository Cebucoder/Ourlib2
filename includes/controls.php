<?php
// session_start();

if (isset($_SESSION['admin'])) {
    // User is logged in, show "Logout" and link to logout.php
    $loginStatus = "Logout";
    $loginLink = "logout.php";
    $login_icon = '<ion-icon name="log-out-outline"></ion-icon>';
} else {
    // User is not logged in, show "Login" and link to admin.php
    $loginStatus = "Login";
    $loginLink = "admin.php";
    $login_icon = '<ion-icon name="person-outline"></ion-icon>';
}
?>

<div class="user_con">
    <div class="user_icon">
        <!-- Display Login or Logout based on user session status -->
        <a href="<?php echo $loginLink; ?>" id="auth-link">
            <span><?php echo $login_icon; ?></span> 
            <span id="user_stat"><?php echo $loginStatus; ?></span> 
        </a>
    </div>
    <div class="user_control">
        <?php if (isset($_SESSION['admin'])): ?>
            <ul>
                <li><a href="index.php"><span><ion-icon name="home-outline"></ion-icon></span> <small>Home</small> </a></li>
                <li><a href="admin_dashboard.php"><span><ion-icon name="speedometer-outline"></ion-icon></span> <small>Dashboard</small> </a></li>
                <li><a href="upload_template.php"><span><ion-icon name="add-outline"></ion-icon></span> <small>Add Template</small></a></li>
                <li><a href="temp_gallery.php"><span><ion-icon name="cloud-upload-outline"></ion-icon></span> <small>Upload Images</small></a></li>
            </ul>
        <?php endif; ?>
    </div>
</div>

<script>
    // JavaScript to handle redirecting to login page if not logged in
    document.getElementById("auth-link").addEventListener("click", function(event) {
        <?php if (!isset($_SESSION['admin'])): ?>
            // Prevent default link action and redirect to login page
            event.preventDefault();
            window.location.href = "admin.php";
        <?php endif; ?>
    });
</script>
