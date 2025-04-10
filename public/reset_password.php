<?php
session_start();

// Check if the reset token is set in the session and the URL
if (!isset($_SESSION['reset_token']) || !isset($_GET['token']) || $_SESSION['reset_token'] !== $_GET['token']) {
    header('Location: login.php'); // Redirect if token is invalid
    exit;
}

// Process the new password
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_password = $_POST['new_password'];

    // Update the password (in a real scenario, you should hash the password)
    if ($new_password) {
        // For example, update password in the database
        // In this case, we'll assume it's successful
        $_SESSION['admin_logged_in'] = true;
        unset($_SESSION['reset_token']); // Remove the reset token

        echo "Your password has been successfully reset. <a href='login.php'>Login</a>";
        exit;
    } else {
        $error_message = "Password cannot be empty.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <style>
        /* Add some basic styles */
    </style>
</head>
<body>
    <div class="reset-container">
        <h2>Reset Your Password</h2>
        <form method="post" action="">
            <label for="new_password">Enter your new password:</label>
            <input type="password" name="new_password" id="new_password" required>

            <input type="submit" value="Reset Password">
        </form>

        <?php if (isset($error_message)) { ?>
            <div class="error-message">
                <p><?php echo $error_message; ?></p>
            </div>
        <?php } ?>
    </div>
</body>
</html>
