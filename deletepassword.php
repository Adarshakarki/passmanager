<?php
session_start();
include 'connection.php';

// Check if user is not logged in, redirect to login page
if (!isset($_SESSION['email'])) {
    header('Location: login.php');
    exit();
}

// Check if ID parameter is provided via GET request
if (isset($_GET['id'])) {
    // Retrieve user's email from session
    $email = $_SESSION['email'];
    
    // Retrieve ID parameter from GET request
    $id = $_GET['id'];

    // Delete password record from database
    $sql = "DELETE FROM userpassword WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        // Bind parameters to the statement
        mysqli_stmt_bind_param($stmt, "i", $id);

        // Execute the statement
        if (mysqli_stmt_execute($stmt)) {
            echo "Record deleted successfully";
            header('Location: viewpassword.php');

        } else {
            echo "Error deleting record: " . mysqli_error($conn);
        }

        // Close statement
        mysqli_stmt_close($stmt);
    } else {
        echo "Error in preparing delete statement.";
    }
} else {
    echo "Invalid request. Record ID not provided.";
}

// Close connection
mysqli_close($conn);
?>
