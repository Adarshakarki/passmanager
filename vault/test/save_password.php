<?php
// Connect to your database
$servername = "localhost";
$username = "username";
$password = "password";
$dbname = "password_manager";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get values from the form
$site = $_POST['site'];
$username = $_POST['username'];
$password = $_POST['password'];

// Insert into database
$sql = "INSERT INTO passwords (site, username, password) VALUES ('$site', '$username', '$password')";

if ($conn->query($sql) === TRUE) {
    echo "Password saved successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
