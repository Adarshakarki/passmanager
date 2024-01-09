<?php
session_start();

$servername = "sql213.infinityfree.com";
$username = "if0_35636795";
$password = "AAPxK5bKHdJ36k";
$dbname = "if0_35636795_Passmanager";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to sanitize input data
function sanitize_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

// Sign up
if (isset($_POST['signup'])) {
    $email = sanitize_input($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (email, password) VALUES ('$email', '$password')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Sign up successful!'); window.location.href='login.html';</script>";
    } else {
        echo "<script>alert('Error: " . $sql . "<br>" . $conn->error . "'); window.location.href='login.html';</script>";
    }
}

// Login
if (isset($_POST['login'])) {
    $email = sanitize_input($_POST['email']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            echo "<script>alert('Login successful!'); console.log('Redirecting to YouTube...'); window.location.href='https://www.youtube.com';</script>";
            exit; // Make sure to exit to prevent further script execution
        } else {
            echo "<script>alert('Incorrect password'); console.log('Incorrect password'); window.location.href='login.html';</script>";
        }
    } else {
        echo "<script>alert('User not found'); console.log('User not found'); window.location.href='login.html';</script>";
    }
}

// Close connection
$conn->close();
?>