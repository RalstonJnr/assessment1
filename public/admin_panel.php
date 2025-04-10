<?php
session_start();

// Enable error reporting (for debugging only – remove in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Define admin password
$admin_password = "Easishoppe77481"; // Same as in login.php

// Redirect if not logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}

$error_message = "";

// Handle CSV Download
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['download_csv'])) {
    $db = new SQLite3('/mnt/data/database.db');
    $query = "SELECT * FROM responses ORDER BY created_at DESC";
    $results = $db->query($query);

    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="responses.csv"');

    $output = fopen('php://output', 'w');
    fputcsv($output, [
        'ID', 'Name', 'Email', 'Number',
        'Question1', 'Question2', 'Question3', 'Question4', 'Question5',
        'Question6', 'Question7', 'Question8', 'Question9', 'Question10',
        'Question11', 'Question12', 'Question13', 'Question14', 'Question15',
        'Case Study', 'Submitted At'
    ]);

    while ($row = $results->fetchArray(SQLITE3_ASSOC)) {
        fputcsv($output, [
            $row['id'], $row['name'], $row['email'], $row['number'],
            $row['question1'], $row['question2'], $row['question3'], $row['question4'], $row['question5'],
            $row['question6'], $row['question7'], $row['question8'], $row['question9'], $row['question10'],
            $row['question11'], $row['question12'], $row['question13'], $row['question14'], $row['question15'],
            $row['case_study'], $row['created_at']
        ]);
    }

    fclose($output);
    exit;
}

// Handle Delete Request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_delete'])) {
    if ($_POST['admin_password'] === $admin_password) {
        $delete_id = intval($_POST['delete_id']);
        $db = new SQLite3('/mnt/data/database.db');
        $stmt = $db->prepare("DELETE FROM responses WHERE id = ?");
        $stmt->bindValue(1, $delete_id, SQLITE3_INTEGER);
        $result = $stmt->execute();
        if ($result) {
            header("Location: admin_panel.php?deleted=1");
            exit;
        } else {
            $error_message = "Deletion failed: " . $db->lastErrorMsg();
        }
    } else {
        $error_message = "Incorrect admin password. Deletion failed.";
    }
}

// Fetch responses
$db = new SQLite3('/mnt/data/database.db');
$query = "SELECT * FROM responses ORDER BY created_at DESC";
$results = $db->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel - View Responses</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f5f5f5;
            padding: 20px;
            color: #333;
        }
        h2 {
            text-align: center;
            color: #007bff;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }
        .card {
            background: #fff;
            padding: 20px;
            margin-top: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            color: white;
            background: #007bff;
            cursor: pointer;
            font-size: 14px;
        }
        .btn:hover {
            background: #0056b3;
        }
        .logout-btn {
            background-color: #dc3545;
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
            padding: 14px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }
        th {
            background: #007bff;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .delete-btn {
            background-color: #dc3545;
            padding: 6px 10px;
        }
        .delete-btn:hover {
            background-color: #c82333;
        }
        .csv-btn-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        /* Modal Styles */
        #deleteModal {
            display: none;
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0,0,0,0.6);
            z-index: 999;
        }
        .modal-content {
            background: #fff;
            max-width: 400px;
            margin: 100px auto;
            padding: 20px;
            border-radius: 8px;
        }
        .error-message {
            color: red;
            text-align: center;
            margin-top: 10px;
        }
        .success-message {
            color: green;
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Admin Panel - View Responses</h2>

    <?php if (isset($_GET['deleted'])): ?>
        <p class="success-message">Candidate deleted successfully.</p>
    <?php endif; ?>

    <?php if (!empty($error_message)): ?>
        <p class="error-message"><?php echo htmlspecialchars($error_message); ?></p>
    <?php endif; ?>

    <div class="card">
        <div class="csv-btn-container">
            <form method="post">
                <button type="submit" name="download_csv" class="btn">
                    <i class="fas fa-download"></i> Download CSV
                </button>
            </form>
            <a href="logout.php" class="btn logout-btn">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </div>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Number</th>
                    <th>Submitted</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $results->fetchArray(SQLITE3_ASSOC)): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['id']); ?></td>
                    <td><a href="view_responses.php?user_id=<?php echo $row['id']; ?>"><?php echo htmlspecialchars($row['name']); ?></a></td>
                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                    <td><?php echo htmlspecialchars($row['number']); ?></td>
                    <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                    <td>
                        <button class="btn delete-btn" onclick="promptDelete(<?php echo $row['id']; ?>)">Delete</button>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Delete Modal -->
<div id="deleteModal">
    <div class="modal-content">
        <h3>Confirm Deletion</h3>
        <form method="post">
            <input type="hidden" name="delete_id" id="delete_id_input">
            <label for="admin_password">Enter Admin Password:</label>
            <input type="password" name="admin_password" required style="width:100%; margin-top:10px; padding:10px;">
            <div style="margin-top:15px; text-align:right;">
                <button type="submit" name="confirm_delete" class="btn delete-btn">Confirm Delete</button>
                <button type="button" onclick="closeModal()" class="btn" style="margin-left:10px;">Cancel</button>
            </div>
        </form>
    </div>
</div>

<script>
function promptDelete(id) {
    document.getElementById('delete_id_input').value = id;
    document.getElementById('deleteModal').style.display = 'block';
}
function closeModal() {
    document.getElementById('deleteModal').style.display = 'none';
}
</script>

</body>
</html>
