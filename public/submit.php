<?php
try {
    // Open or create the SQLite3 database file
    $db = new SQLite3('/mnt/data/database.db');

    // Create table if it doesn't exist
    $createTableQuery = "
        CREATE TABLE IF NOT EXISTS responses (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name TEXT NOT NULL,
            email TEXT NOT NULL,
            number TEXT NOT NULL,
            question1 TEXT NOT NULL,
            question2 TEXT NOT NULL,
            question3 TEXT NOT NULL,
            question4 TEXT NOT NULL,
            question5 TEXT NOT NULL,
            question6 TEXT NOT NULL,
            question7 TEXT NOT NULL,
            question8 TEXT NOT NULL,
            question9 TEXT NOT NULL,
            question10 TEXT NOT NULL,
            question11 TEXT NOT NULL,
            question12 TEXT NOT NULL,
            question13 TEXT NOT NULL,
            question14 TEXT NOT NULL,
            question15 TEXT NOT NULL,
            case_study TEXT NOT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        );
    ";
    $db->exec($createTableQuery);

    // Helper function to safely get POST values
    function getPostValue($key) {
        return isset($_POST[$key]) ? trim($_POST[$key]) : '';
    }

    // Collect form data
    $name = getPostValue('name');
    $email = getPostValue('email');
    $number = getPostValue('number');

    $question1 = getPostValue('question1');
    $question2 = getPostValue('question2');
    $question3 = getPostValue('question3');
    $question4 = getPostValue('question4');
    $question5 = getPostValue('question5');
    $question6 = getPostValue('question6');
    $question7 = getPostValue('question7');
    $question8 = getPostValue('question8');
    $question9 = getPostValue('question9');
    $question10 = getPostValue('question10');
    $question11 = getPostValue('question11');
    $question12 = getPostValue('question12');
    $question13 = getPostValue('question13');
    $question14 = getPostValue('question14');
    $question15 = getPostValue('question15');
    $caseStudy = getPostValue('case_study');

    // Validate required fields
    if (empty($name) || empty($email) || empty($number)) {
        throw new Exception('Name, email, and number are required.');
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        throw new Exception('Invalid email format.');
    }

    // Insert into database
    $stmt = $db->prepare("INSERT INTO responses 
        (name, email, number, question1, question2, question3, question4, question5, question6, question7, question8, question9, question10, question11, question12, question13, question14, question15, case_study) 
        VALUES 
        (:name, :email, :number, :question1, :question2, :question3, :question4, :question5, :question6, :question7, :question8, :question9, :question10, :question11, :question12, :question13, :question14, :question15, :caseStudy)");

    // Bind values
    $stmt->bindValue(':name', $name, SQLITE3_TEXT);
    $stmt->bindValue(':email', $email, SQLITE3_TEXT);
    $stmt->bindValue(':number', $number, SQLITE3_TEXT);

    $stmt->bindValue(':question1', $question1 ?: 'N/A', SQLITE3_TEXT);
    $stmt->bindValue(':question2', $question2 ?: 'N/A', SQLITE3_TEXT);
    $stmt->bindValue(':question3', $question3 ?: 'N/A', SQLITE3_TEXT);
    $stmt->bindValue(':question4', $question4 ?: 'N/A', SQLITE3_TEXT);
    $stmt->bindValue(':question5', $question5 ?: 'N/A', SQLITE3_TEXT);
    $stmt->bindValue(':question6', $question6 ?: 'N/A', SQLITE3_TEXT);
    $stmt->bindValue(':question7', $question7 ?: 'N/A', SQLITE3_TEXT);
    $stmt->bindValue(':question8', $question8 ?: 'N/A', SQLITE3_TEXT);
    $stmt->bindValue(':question9', $question9 ?: 'N/A', SQLITE3_TEXT);
    $stmt->bindValue(':question10', $question10 ?: 'N/A', SQLITE3_TEXT);
    $stmt->bindValue(':question11', $question11 ?: 'N/A', SQLITE3_TEXT);
    $stmt->bindValue(':question12', $question12 ?: 'N/A', SQLITE3_TEXT);
    $stmt->bindValue(':question13', $question13 ?: 'N/A', SQLITE3_TEXT);
    $stmt->bindValue(':question14', $question14 ?: 'N/A', SQLITE3_TEXT);
    $stmt->bindValue(':question15', $question15 ?: 'N/A', SQLITE3_TEXT);
    $stmt->bindValue(':caseStudy', $caseStudy ?: 'N/A', SQLITE3_TEXT);

    // Execute
    $result = $stmt->execute();

    if ($result) {
        header("Location: thank_you.php");
        exit;
    } else {
        throw new Exception('Failed to save your submission. Please try again.');
    }

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
    
    // Optional: Log raw POST data for debugging
    file_put_contents('/mnt/data/debug_log.txt', date('Y-m-d H:i:s') . " - " . json_encode($_POST) . "\n", FILE_APPEND);
}
?>
