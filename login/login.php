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

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == "login") {
    // Get user input
    $email = $_POST['email'];
    $password = $_POST['password'];

    // SQL query to retrieve user data from the database
    $sql = "SELECT user_id, email, password FROM users WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // User found, verify the password
        $row = $result->fetch_assoc();
        $hashedPassword = $row['password'];

        if (password_verify($password, $hashedPassword)) {
            // Password is correct, you can set up a session or redirect as needed
            echo "Login successful! Welcome " . $row['user_id'];
        } else {
            echo "Incorrect password!";
        }
    } else {
        echo "User not found!";
    }
}

$conn->close();
?>
