<?php include 'config.php' ?>
<?php
// Set secure session cookie parameters before starting the session
$cookieParams = session_get_cookie_params(); // Get current session cookie parameters

// Configure session cookie settings for security
session_set_cookie_params([
    'lifetime' => $cookieParams['lifetime'],  // Retain the current lifetime
    'path' => $cookieParams['path'],          // Retain the current path
    'domain' => $cookieParams['domain'],      // Retain the current domain
    'secure' => true,                         // Only send cookie over HTTPS
    'httponly' => true,                       // Prevent access to the cookie via JavaScript
    'samesite' => 'Strict'                    // Strict SameSite policy to prevent CSRF
]);
?>
<?php @session_start(); ?>


<?php include 'includes/header.php'?>
<?php include 'includes/nav.php'?>
<?php include 'includes/controls.php'?>


    <div class="main_con">
        <div class="wrapper">
            <div class="main_content">

                <?php include 'library/navbar.php' ?>
                <?php include 'library/banner.php' ?>
                <?php include 'library/boxes.php' ?>
                <?php include 'library/buttons.php' ?>
                <?php include 'library/text.php' ?>
                <?php include 'library/images.php' ?>
                <?php include 'library/footer.php' ?>
                <?php include 'library/gsap.php' ?>

            </div>
        </div>
    </div>

<!-- <?php //get_includes('footer.php'); ?> -->
<?php include 'includes/footer.php'?>
