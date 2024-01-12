<?php
// Database connection (replace with your database credentials)
$servername = "localhost";
$username = "root";
$password = " ";
$dbname = "logintest";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == "signup") {
    // Get user input
    $userId = $_POST['userId'];
    $email = $_POST['signupEmail'];
    $password = $_POST['signupPassword'];

    // Hash the password before storing it (for security)
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // SQL query to insert user data into the database
    $sql = "INSERT INTO users (user_id, email, password) VALUES ('$userId', '$email', '$hashedPassword')";

    if ($conn->query($sql) === TRUE) {
        echo "Signup successful!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
