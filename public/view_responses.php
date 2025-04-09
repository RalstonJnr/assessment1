<?php
session_start();

// Check if the admin is logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php'); // Redirect to login if not logged in
    exit;
}

// Connect to the SQLite3 database
$db = new SQLite3('C:/xampp/htdocs/mywebsite/database.db');

// Check if the user ID is passed as a URL parameter
if (!isset($_GET['user_id'])) {
    die("User ID is missing!");
}

$user_id = intval($_GET['user_id']); // Ensure the user ID is an integer for security

// Fetch the user's data from the database
$query = "SELECT * FROM responses WHERE id = :user_id LIMIT 1";
$stmt = $db->prepare($query);
$stmt->bindValue(':user_id', $user_id, SQLITE3_INTEGER);
$result = $stmt->execute();

// Check if the user exists
if ($row = $result->fetchArray()) {
    // Store user data for later use
    $user_data = $row;
} else {
    die("User not found!");
}

// Close the database connection
$db->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View User Responses</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
        }
        h2 {
            text-align: center;
            color: #007bff;
            margin-bottom: 20px;
        }
        .card {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 30px;
        }
        .user-details {
            margin-bottom: 20px;
        }
        .user-details dt {
            font-weight: bold;
            margin-top: 10px;
        }
        .user-details dd {
            margin-left: 20px;
            margin-bottom: 10px;
        }
        .csv-btn-container {
            text-align: center;
            margin-bottom: 20px;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }
        .btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>User Response Details</h2>

        <div class="card">
            <div class="user-details">
                <dl>
                    <dt>Name:</dt>
                    <dd><?php echo htmlspecialchars($user_data['name']); ?></dd>

                    <dt>Email:</dt>
                    <dd><?php echo htmlspecialchars($user_data['email']); ?></dd>

                    <dt>Number:</dt>
                    <dd><?php echo htmlspecialchars($user_data['number']); ?></dd>

                    <dt>Question 1:</dt>
                    <dd><?php echo nl2br(htmlspecialchars($user_data['question1'])); ?></dd>

                    <dt>Question 2:</dt>
                    <dd><?php echo nl2br(htmlspecialchars($user_data['question2'])); ?></dd>

                    <dt>Question 3:</dt>
                    <dd><?php echo nl2br(htmlspecialchars($user_data['question3'])); ?></dd>

                    <dt>Question 4:</dt>
                    <dd><?php echo nl2br(htmlspecialchars($user_data['question4'])); ?></dd>
					                    <dt>Question 5:</dt>
                    <dd><?php echo nl2br(htmlspecialchars($user_data['question5'])); ?></dd>
					                    <dt>Question 6:</dt>
                    <dd><?php echo nl2br(htmlspecialchars($user_data['question6'])); ?></dd>
					                    <dt>Question 7:</dt>
                    <dd><?php echo nl2br(htmlspecialchars($user_data['question7'])); ?></dd>
					                    <dt>Question 8:</dt>
                    <dd><?php echo nl2br(htmlspecialchars($user_data['question8'])); ?></dd>
					                    <dt>Question 9:</dt>
                    <dd><?php echo nl2br(htmlspecialchars($user_data['question9'])); ?></dd>
					                    <dt>Question 10:</dt>
                    <dd><?php echo nl2br(htmlspecialchars($user_data['question10'])); ?></dd>
					                    <dt>Question 11:</dt>
                    <dd><?php echo nl2br(htmlspecialchars($user_data['question11'])); ?></dd>
					                    <dt>Question 12:</dt>
                    <dd><?php echo nl2br(htmlspecialchars($user_data['question12'])); ?></dd>
					                    <dt>Question 13:</dt>
                    <dd><?php echo nl2br(htmlspecialchars($user_data['question13'])); ?></dd>
					                    <dt>Question 14:</dt>
                    <dd><?php echo nl2br(htmlspecialchars($user_data['question14'])); ?></dd>
					                    <dt>Question 15:</dt>
                    <dd><?php echo nl2br(htmlspecialchars($user_data['question15'])); ?></dd>

                    <dt>Case Study Response:</dt>
                    <dd><?php echo nl2br(htmlspecialchars($user_data['case_study'])); ?></dd>

                    <dt>Submission Date:</dt>
                    <dd><?php echo $user_data['created_at']; ?></dd>
                </dl>
            </div>
        </div>

        <!-- Back to Admin Panel Button -->
        <div class="csv-btn-container">
            <a href="admin_panel.php" class="btn">Back to Admin Panel</a>
        </div>
    </div>

</body>
</html>
