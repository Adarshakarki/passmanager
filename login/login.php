<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Check if the email exists in the database
    $checkEmailQuery = "SELECT * FROM users WHERE email = '$email'";
    $checkResult = $conn->query($checkEmailQuery);

    if ($checkResult->num_rows > 0) {
        // Email found, now verify the password
        $user = $checkResult->fetch_assoc();
        $hashedPassword = $user['password'];

        if (password_verify($password, $hashedPassword)) {
            // Password is correct, redirect to a YouTube link
            header("Location: https://youtu.be/dQw4w9WgXcQ");
            exit();
        } else {
            // Password is incorrect
            echo "Incorrect password. Please try again.";
        }
    } else {
        // Email not found
        echo "No account found for the given email.";
    }
}
?>
