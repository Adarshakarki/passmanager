<?php
$servername = "sql213.infinityfree.com";
$username = "if0_35636795";
$password = "AAPxK5bKHdJ36k";
$dbname = "if0_35636795_Passmanager";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the login form is submitted
    if (isset($_POST['email']) && isset($_POST['password'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];

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
    // Check if the signup form is submitted
    elseif (isset($_POST['signup_email']) && isset($_POST['signup_password'])) {
        $signup_email = $_POST['signup_email'];
        $signup_password = $_POST['signup_password'];

        // Check if the email is not already registered
        $checkEmailQuery = "SELECT * FROM users WHERE email = '$signup_email'";
        $checkResult = $conn->query($checkEmailQuery);

        if ($checkResult->num_rows > 0) {
            echo "This email is already registered. Please use a different email.";
        } else {
            // Hash the password before storing it in the database
            $hashedPassword = password_hash($signup_password, PASSWORD_DEFAULT);

            // Insert the new user into the database
            $insertUserQuery = "INSERT INTO users (email, password) VALUES ('$signup_email', '$hashedPassword')";

            if ($conn->query($insertUserQuery) === TRUE) {
                echo "Account created successfully!";
            } else {
                echo "Error: " . $insertUserQuery . "<br>" . $conn->error;
            }
        }
    }
    // Handle other cases or show an error message
}
?>