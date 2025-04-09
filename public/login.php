<?php
session_start();

// Define admin username and password
$admin_username = "admin";
$admin_password = "password"; // Change this to a secure password

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if the credentials match
    if ($username === $admin_username && $password === $admin_password) {
        $_SESSION['admin_logged_in'] = true;
        header('Location: admin_panel.php'); // Redirect to admin panel
        exit;
    } else {
        $error_message = "Invalid login credentials. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
</head>
<body>
    <h2>Admin Login</h2>
    <form method="post" action="">
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" required>
        <br>
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required>
        <br>
        <input type="submit" value="Login">
    </form>

    <?php if (isset($error_message)) { echo "<p style='color:red;'>$error_message</p>"; } ?>
</body>
</html>
