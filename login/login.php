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
    if (isset($_POST['login_email']) && isset($_POST['login_password'])) {
        // Login Form Submitted
        $email = $_POST['login_email'];
        $password = $_POST['login_password'];

        $checkEmailQuery = "SELECT * FROM users WHERE email = '$email'";
        $checkResult = $conn->query($checkEmailQuery);

        if ($checkResult->num_rows > 0) {
            $user = $checkResult->fetch_assoc();
            $hashedPassword = $user['password'];

            if (password_verify($password, $hashedPassword)) {
                echo "Login successful!";
            } else {
                echo "Incorrect password. Please try again.";
            }
        } else {
            echo "No account found for the given email.";
        }
    } elseif (isset($_POST['signup_email']) && isset($_POST['signup_password'])) {
        // Signup Form Submitted
        $signup_email = $_POST['signup_email'];
        $signup_password = $_POST['signup_password'];

        $checkEmailQuery = "SELECT * FROM users WHERE email = '$signup_email'";
        $checkResult = $conn->query($checkEmailQuery);

        if ($checkResult->num_rows > 0) {
            echo "This email is already registered. Please use a different email.";
        } else {
            $hashedPassword = password_hash($signup_password, PASSWORD_DEFAULT);
            $insertUserQuery = "INSERT INTO users (email, password) VALUES ('$signup_email', '$hashedPassword')";

            if ($conn->query($insertUserQuery) === TRUE) {
                echo "Account created successfully!";
            } else {
                echo "Error: " . $insertUserQuery . "<br>" . $conn->error;
            }
        }
    }
}
?>
