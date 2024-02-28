<?php
session_start(); // Start session

include 'db.php';

class Login {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function authenticateUser($email, $password) {
        try {
            $sql = "SELECT user_id, email, password FROM users WHERE email = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->bind_result($userId, $dbEmail, $dbPassword);

            if ($stmt->fetch()) {
                if (password_verify($password, $dbPassword)) {
                    $_SESSION['user_id'] = $userId;
                    header("Location: homepage.html");
                    exit();
                } else {
                    echo '<script>alert("Incorrect password"); window.location.href = "index.html";</script>';
                }
            } else {
                echo '<script>alert("User not found"); window.location.href = "index.html";</script>';
            }

            $stmt->close();
        } catch (Exception $e) {
            echo '<script>alert("Error: ' . $e->getMessage() . '"); window.location.href = "index.html";</script>';
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $email = $_POST["email"];
        $password = $_POST["password"];

        $login = new Login($conn);
        $login->authenticateUser($email, $password);

        $conn->close();
    } catch (Exception $e) {
        echo '<script>alert("Error: ' . $e->getMessage() . '"); window.location.href = "index.html";</script>';
    }
}
?>
