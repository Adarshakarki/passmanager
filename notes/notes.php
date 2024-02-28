<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['userId'])) {
    // If not logged in, return an error response
    echo json_encode(['success' => false, 'error' => 'User not logged in']);
    exit();
}

// Database connection
$pdo = new PDO('mysql:host=localhost;dbname=your_database', 'username', 'password');

// Check if request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve user ID from session
    $userId = $_SESSION['userId'];

    // Retrieve note title and content from POST data
    $title = $_POST['title'] ?? '';
    $content = $_POST['content'] ?? '';

    // Insert note into database
    $stmt = $pdo->prepare("INSERT INTO notes (user_id, title, content) VALUES (?, ?, ?)");
    $success = $stmt->execute([$userId, $title, $content]);

    // Check if insertion was successful
    if ($success) {
        // Return success response
        echo json_encode(['success' => true]);
    } else {
        // Return error response
        echo json_encode(['success' => false, 'error' => 'Failed to save note']);
    }
}
?>
