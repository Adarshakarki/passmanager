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
            echo "Invalid email format. Please enter a valid email address.";
            exit;
        }

        $action = $_POST['action'];
        $checkEmailQuery = "SELECT * FROM users WHERE email = ?";
        $stmt = $conn->prepare($checkEmailQuery);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $checkResult = $stmt->get_result();
        
        if ($checkResult->num_rows > 0 && $action === 'login') {
            // Email exists, proceed with login logic
            $user = $checkResult->fetch_assoc();
            $hashedPassword = $user['password'];

            if (password_verify($password, $hashedPassword)) {
                // Login successful
                echo json_encode(array("status" => "success", "message" => "Login successful!"));

                // Redirect to a YouTube link
                header("Location: https://youtu.be/dQw4w9WgXcQ");
                exit;
            } else {
    // Incorrect password
    echo '<script>alert("Incorrect password. Please try again.");</script>';
            }
        } elseif ($checkResult->num_rows === 0 && $action === 'signup') {
            // Email doesn't exist, proceed with signup logic
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $insertUserQuery = "INSERT INTO users (email, password) VALUES (?, ?)";
            $stmt = $conn->prepare($insertUserQuery);
            $stmt->bind_param("ss", $email, $hashedPassword);

            if ($stmt->execute()) {
                // Account created successfully
                echo json_encode(array("status" => "success", "message" => "Account created successfully!"));
            } else {
                // Error creating account
                echo json_encode(array("status" => "error", "message" => "Error creating account. Please try again later."));
            }
        } else {
            // Invalid action
            echo json_encode(array("status" => "error", "message" => "Invalid action."));
        }
    }
}
?>
