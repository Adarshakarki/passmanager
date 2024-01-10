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
    if (isset($_POST['email']) && isset($_POST['password'])) {
        $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
        $password = $_POST['password'];
        if (!$email) {
            echo '<script>alert("Invalid email format. Please enter a valid email address."); window.location.href = "login.html";</script>';
            exit;
        }
        $action = $_POST['action'];
        $checkEmailQuery = "SELECT * FROM users WHERE email = ?";
        $stmt = $conn->prepare($checkEmailQuery);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $checkResult = $stmt->get_result(); 
        if ($checkResult->num_rows > 0 && $action === 'login') {
            $user = $checkResult->fetch_assoc();
            $hashedPassword = $user['password'];
            if (password_verify($password, $hashedPassword)) {
                echo json_encode(array("status" => "success", "message" => "Login successful!"));
                header("Location: https://youtu.be/dQw4w9WgXcQ");
                exit;
            } else {
                echo json_encode(array("status" => "error", "message" => "Incorrect password. Please try again."));
            }
        } elseif ($checkResult->num_rows === 0 && $action === 'signup') {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $insertUserQuery = "INSERT INTO users (email, password) VALUES (?, ?)";
            $stmt = $conn->prepare($insertUserQuery);
            $stmt->bind_param("ss", $email, $hashedPassword);
            if ($stmt->execute()) {
                echo '<script>alert("Account created successfully!"); window.location.href = "login.html";</script>';
            } else {
                echo '<script>alert("Error creating account. Please try again later."); window.location.href = "register.html";</script>';
            }
        } else {
            echo '<script>alert("Invalid action."); window.location.href = "index.html";</script>';
        }
    }
}
?>