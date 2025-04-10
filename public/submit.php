<?php
try {
    // Open (or create) the SQLite3 database file
    $db = new SQLite3('/mnt/data/database.db');
 // Ensure this path is correct

    // Create table for storing form responses if it doesn't exist
    $createTableQuery = "
        CREATE TABLE IF NOT EXISTS responses (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name TEXT NOT NULL,
            email TEXT NOT NULL,
            number INTEGER NOT NULL,  -- Added 'number' field for phone or identifier
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
    $db->exec($createTableQuery);  // Execute the query to create the table if it doesn't exist

    // Get form data and sanitize it
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $number = trim($_POST['number']);  // New field for 'number'
    $question1 = trim($_POST['question1']);
    $question2 = trim($_POST['question2']);
    $question3 = trim($_POST['question3']);
    $question4 = trim($_POST['question4']);
    $question5 = trim($_POST['question5']);
    $question6 = trim($_POST['question6']);
    $question7 = trim($_POST['question7']);
    $question8 = trim($_POST['question8']);
    $question9 = trim($_POST['question9']);
    $question10 = trim($_POST['question10']);
    $question11 = trim($_POST['question11']);
    $question12 = trim($_POST['question12']);
    $question13 = trim($_POST['question13']);
    $question14 = trim($_POST['question14']);
    $question15 = trim($_POST['question15']);
    $caseStudy = trim($_POST['case_study']); // Add caseStudy field

    // Simple validation: Ensure no field is empty
    if (empty($name) || empty($email) || empty($number) || empty($question1) || empty($question2) || empty($question3) || empty($question4) || empty($question5) || empty($question6) || empty($question7) || empty($question8) || empty($question9) || empty($question10) || empty($question11) || empty($question12) || empty($question13) || empty($question14) || empty($question15) || empty($caseStudy)) {
        throw new Exception('All fields are required. Please fill in all fields.');
    }

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        throw new Exception('Invalid email format. Please provide a valid email address.');
    }

    // Prepare the SQL statement to insert data into the responses table
    $stmt = $db->prepare("INSERT INTO responses 
        (name, email, number, question1, question2, question3, question4, question5, question6, question7, question8, question9, question10, question11, question12, question13, question14, question15, case_study) 
        VALUES 
        (:name, :email, :number, :question1, :question2, :question3, :question4, :question5, :question6, :question7, :question8, :question9, :question10, :question11, :question12, :question13, :question14, :question15, :caseStudy)");

    // Bind values to the SQL query
    $stmt->bindValue(':name', $name, SQLITE3_TEXT);
    $stmt->bindValue(':email', $email, SQLITE3_TEXT);
    $stmt->bindValue(':number', $number, SQLITE3_INTEGER);  // Bind the number field as INTEGER
    $stmt->bindValue(':question1', $question1, SQLITE3_TEXT);
    $stmt->bindValue(':question2', $question2, SQLITE3_TEXT);
    $stmt->bindValue(':question3', $question3, SQLITE3_TEXT);
    $stmt->bindValue(':question4', $question4, SQLITE3_TEXT);
    $stmt->bindValue(':question5', $question5, SQLITE3_TEXT);
    $stmt->bindValue(':question6', $question6, SQLITE3_TEXT);
    $stmt->bindValue(':question7', $question7, SQLITE3_TEXT);
    $stmt->bindValue(':question8', $question8, SQLITE3_TEXT);
    $stmt->bindValue(':question9', $question9, SQLITE3_TEXT);
    $stmt->bindValue(':question10', $question10, SQLITE3_TEXT);
    $stmt->bindValue(':question11', $question11, SQLITE3_TEXT);
    $stmt->bindValue(':question12', $question12, SQLITE3_TEXT);
    $stmt->bindValue(':question13', $question13, SQLITE3_TEXT);
    $stmt->bindValue(':question14', $question14, SQLITE3_TEXT);
    $stmt->bindValue(':question15', $question15, SQLITE3_TEXT);
    $stmt->bindValue(':caseStudy', $caseStudy, SQLITE3_TEXT); // Bind caseStudy

    // Execute the query
    $result = $stmt->execute();

    if ($result) {
        // Redirect to the thank you page after successful submission
        header("Location: thank_you.php");
        exit;  // Always call exit after header redirection to stop further code execution
    } else {
        throw new Exception('There was an issue saving your response. Please try again.');
    }

} catch (Exception $e) {
    // Display error message if something goes wrong
    echo "Error: " . $e->getMessage();
}
?>
