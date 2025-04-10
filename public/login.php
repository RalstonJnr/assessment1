<?php
session_start();

// Define admin username and password (use environment variables or a secure method in production)
$admin_username = "Ashwin Smith";
$admin_password = "Easishoppe77481"; // Hard coded for simplicity 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate input
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);

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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f7f9fc;
            margin: 0;
            padding: 0;
        }

        .login-container {
            max-width: 400px;
            margin: 100px auto;
            background-color: #ffffff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h2 {
            color: #333;
            margin-bottom: 30px;
            font-weight: 700;
        }

        label {
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
            display: block;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 16px;
        }

        input[type="submit"] {
            width: 100%;
            padding: 12px;
            background-color: #007bff;
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .error-message {
            color: #dc3545;
            margin-top: 15px;
        }

        .footer {
            margin-top: 20px;
            font-size: 14px;
            color: #777;
        }

        .footer a {
            color: #007bff;
            text-decoration: none;
        }

        .footer a:hover {
            text-decoration: underline;
        }

        /* Mobile Responsive */
        @media (max-width: 600px) {
            .login-container {
                padding: 30px;
            }

            h2 {
                font-size: 24px;
            }

            input[type="text"],
            input[type="password"] {
                font-size: 14px;
            }

            input[type="submit"] {
                font-size: 14px;
            }
        }
    </style>
</head>

<body>

    <div class="login-container">
        <h2>Login</h2>
        <form method="POST" action="">
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" required placeholder="Enter your username">

            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required placeholder="Enter your password">

            <input type="submit" value="Login">
        </form>

        <?php if (isset($error_message)) { ?>
            <div class="error-message">
                <p><?php echo $error_message; ?></p>
            </div>
        <?php } ?>
<!--
       // <div class="footer">
    //    <p>Forgot your password? <a href="forgot_password.php">Reset it here</a></p>
     //   </div>
-->
    </div>

</body>

</html>
