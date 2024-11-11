<?php
session_start();
include 'config.php'; // Include database configuration
include 'includes/header.php';
include 'includes/nav.php';

$username_error = ''; // Variable to hold username error message
$password_error = ''; // Variable to hold password error message

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM admins WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $admin = $result->fetch_assoc();

        if (password_verify($password, $admin['password'])) {
            $_SESSION['admin'] = $admin['username'];
            header("Location: admin_dashboard.php");
            exit();
        } else {
            $password_error = "Invalid password."; // Set password error message
        }
    } else {
        $username_error = "Invalid username."; // Set username error message
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
                        <label class="username_label <?php echo !empty($username_error) ? 'error' : ''; ?>">
                            <?php echo !empty($username_error) ? $username_error : "Username *"; ?>
                        </label>
                    </div>
                    <div class="input_box">
                        <input type="password" name="password" autocomplete="off" required>
                        <label class="password_label <?php echo !empty($password_error) ? 'error' : ''; ?>">
                            <?php echo !empty($password_error) ? $password_error : "Password *"; ?>
                        </label>
                    </div>
                        <button type="submit" id="loginBtn">Login</button>
                        <div class="devider_con">
                            <small><a href="">Don't have an account?</a></small>
                        </div>
                        <div class="login-choice">
                            <div class="register_account">
                               <a href="register.php">Register</a>
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
    <!-- <h2>Admin Login</h2>
    <form method="POST" action="">
        <input type="text" name="username" placeholder="Username" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <button type="submit">Login</button>
        <a href="register.php">Register</a>
    </form> -->

    <?php include 'includes/footer.php'?>
    
</body>
</html>