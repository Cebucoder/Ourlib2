<?php
// register_admin.php
session_start();
include 'config.php'; // Include database configuration
include 'includes/header.php';
include 'includes/nav.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO admins (username, password, email) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $password, $email);

    if ($stmt->execute()) {
        echo "Admin registered successfully!";
        header("Location: admin_dashboard.php");
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <style>
        .nav_link_con{display:none;}
    </style>
    <style>


    </style>
</head>
<body>

    <div class="main_con">
        <div class="wrapper">
            <div class="main_content">

                <form method="POST" action="">
                    <div class="login_form">
                        <h1>Hi</h1>
                        <div class="input_box">
                        <input type="text" id="email" name="username" autocomplete="off" required>
                        <label class="username_label <?php echo !empty($username_error) ? 'error' : ''; ?>">Username *</label>
                    </div>
                    <div class="input_box">
                        <input type="email" name="email" autocomplete="off" required>
                        <label class="email_label <?php echo !empty($email_error) ? 'error' : ''; ?>"> Email *</label>
                    </div>
                    <div class="input_box">
                        <input type="password" name="password" autocomplete="off" required>
                        <label class="password_label <?php echo !empty($password_error) ? 'error' : ''; ?>"> Password *</label>
                    </div>
                        <button type="submit" id="loginBtn">Register</button>
                        <div class="devider_con">
                            <small><a href="">Already have an account?</a></small>
                        </div>
                        <div class="login-choice">
                            <div class="register_account">
                               <a href="login.php">Login</a>
                            </div>
                        </div>
                        
                    </div>
                </form>

            </div>
        </div>
    </div>

    <div class="overlay"></div>
    <div class="stars" aria-hidden="true"></div>
    <div class="starts2" aria-hidden="true"></div>
    <div class="stars3" aria-hidden="true"></div>

    <?php include 'includes/footer.php'?>
    
</body>
</html>



<!-- <form method="POST" action="">
                    <input type="text" name="username" placeholder="Username" required><br>
                    <input type="email" name="email" placeholder="Email" required><br>
                    <input type="password" name="password" placeholder="Password" required><br>
                    <button type="submit">Register Admin</button>
                </form> -->