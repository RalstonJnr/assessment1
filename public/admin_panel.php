<?php
session_start();

// Check if the admin is logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php'); // Redirect to login if not logged in
    exit;
}

// Connect to the SQLite3 database
$db = new SQLite3('C:/xampp/htdocs/mywebsite/database.db');

// Check if the database connection was successful
if (!$db) {
    die("Database connection failed: " . $db->lastErrorMsg());
}

// Query to fetch all responses from the database
$query = "SELECT * FROM responses ORDER BY created_at DESC";
$results = $db->query($query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - View Responses</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        h2 {
            text-align: center;
            color: #007bff;
            margin-bottom: 20px;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }
        .card {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 30px;
        }
        .csv-btn-container {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 20px;
        }
        .csv-btn-container form {
            margin: 0;
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
        .logout-btn {
            background-color: #dc3545;
            margin-left: 20px;
        }
        .logout-btn:hover {
            background-color: #c82333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .case-study-column {
            white-space: pre-wrap; /* Ensure multiline text is preserved */
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            table {
                font-size: 14px;
            }
            .btn {
                width: 100%;
                margin-bottom: 10px;
            }
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Admin Panel - View Responses</h2>

        <div class="card">
            <div class="csv-btn-container">
                <form method="post">
                    <button type="submit" name="download_csv" class="btn">
                        <i class="fas fa-download"></i> Download CSV Report
                    </button>
                </form>
                <a href="logout.php" class="btn logout-btn">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>

            <table>
                <thead>
                    <tr>
                        <th></th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Number</th>
                        <th>Submission Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $results->fetchArray()) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['id']); ?></td>
                            <td>
                                <!-- Create a clickable link for the name -->
                                <a href="view_responses.php?user_id=<?php echo $row['id']; ?>" class="user-link">
                                    <?php echo htmlspecialchars($row['name']); ?>
                                </a>
                            </td>
                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                            <td><?php echo htmlspecialchars($row['number']); ?></td>
                            <td><?php echo $row['created_at']; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>


<?php
// Close the database connection after finishing the data fetch
$db->close();
?>
