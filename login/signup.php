<?php
include 'db.php';
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['signup'])) {
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Check if the email is not already registered
    $checkEmailQuery = "SELECT * FROM users WHERE email = '$email'";
    $checkResult = $conn->query($checkEmailQuery);

    if ($checkResult->num_rows > 0) {
        echo "This email is already registered. Please use a different email.";
    } else {
        // Hash the password before storing it in the database
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Insert the new user into the database
        $insertUserQuery = "INSERT INTO users (email, password) VALUES ('$email', '$hashedPassword')";

        if ($conn->query($insertUserQuery) === TRUE) {
            echo "Account created successfully!";
        } else {
            echo "Error: " . $insertUserQuery . "<br>" . $conn->error;
        }
    }
}
?>