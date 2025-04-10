<?php
session_start();

// Assuming you have an email for the admin (in a real scenario, store emails in a DB)
$admin_email = "admin@example.com";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];

    // Check if the entered email matches the admin's email
    if ($email === $admin_email) {
        // Generate a unique reset token (this could be a random string)
        $reset_token = bin2hex(random_bytes(16));

        // Store the token in the session (or database in production)
        $_SESSION['reset_token'] = $reset_token;

        // Construct a reset link (in a real application, you would send an email)
        $reset_link = "http://yourdomain.com/reset_password.php?token=$reset_token";

        // Simulating an email being sent
        echo "A password reset link has been sent to your email address: <a href='$reset_link'>$reset_link</a>";

        // In a real application, here you would send an email with the reset link
        // mail($email, "Password Reset", "Click here to reset your password: $reset_link");
    } else {
        $error_message = "This email is not associated with any account.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <style>
        /* Add some basic styles */
    </style>
</head>
<body>
    <div class="reset-container">
        <h2>Forgot Your Password?</h2>
        <form method="post" action="">
            <label for="email">Enter your email address:</label>
            <input type="email" name="email" id="email" required>

            <input type="submit" value="Send Reset Link">
        </form>

        <?php if (isset($error_message)) { ?>
            <div class="error-message">
                <p><?php echo $error_message; ?></p>
            </div>
        <?php } ?>
    </div>
</body>
</html>
