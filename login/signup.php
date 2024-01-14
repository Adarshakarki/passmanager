<?php

include 'db.php';

class User {
    private $userId;
    private $email;
    private $password;

    public function __construct($userId, $email, $password) {
        $this->userId = $userId;
        $this->email = $email;
        $this->password = $password;
    }

    public function getUserId() {
        return $this->userId;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getPassword() {
        return $this->password;
    }
}

class SignUp {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function registerUser($user) {
        try {
            // Hash password
            $hashedPassword = password_hash($user->getPassword(), PASSWORD_DEFAULT);

            // Insert new user into the database
            $sql = "INSERT INTO users (user_id, email, password) VALUES (?, ?, ?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("sss", $user->getUserId(), $user->getEmail(), $hashedPassword);

            if ($stmt->execute()) {
                // Display a browser alert for successful registration and redirect to index.html
                echo '<script>alert("New user registered successfully!"); window.location.href = "index.html";</script>';
            } else {
                // Display a browser alert for registration failure
                echo '<script>alert("Error: User registration failed.");</script>';
                // Log detailed error or handle accordingly
            }

            $stmt->close();
        } catch (Exception $e) {
            // Display a browser alert for any other errors
            echo '<script>alert("Error: ' . $e->getMessage() . '"); window.location.href = "index.html";</script>';
        }
    }
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Get data from the form
        $userId = $_POST["signupUserId"];
        $email = $_POST["signupEmail"];
        $password = $_POST["signupPassword"];

        // Create an instance of the User class
        $user = new User($userId, $email, $password);

        // Create an instance of the SignUp class and register the user
        $signUp = new SignUp($conn);
        $signUp->registerUser($user);

        $conn->close();
    } catch (Exception $e) {
        // Display a browser alert for any other errors and redirect to index.html
        echo '<script>alert("Error: ' . $e->getMessage() . '"); window.location.href = "index.html";</script>';
    }
}

?>
