<?php

include 'db.php';

class Login {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function authenticateUser($email, $password) {
        try {
            // Fetch user information from the database based on the provided email
            $sql = "SELECT user_id, email, password FROM users WHERE email = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->bind_result($userId, $dbEmail, $dbPassword);

            if ($stmt->fetch()) {
                if (password_verify($password, $dbPassword)) {
                    // Redirect to the homepage
                    header("Location: homepage.html");
                    exit(); // Make sure to exit after sending the header to ensure proper redirection
                }                
                } else {
                    // Display an alert for incorrect password and redirect to index.html
                    echo '<script>alert("Incorrect password"); window.location.href = "index.html";</script>';
                }
            } else {
                // Display an alert for user not found and redirect to index.html
                echo '<script>alert("User not found"); window.location.href = "index.html";</script>';
            }

            $stmt->close();
        } catch (Exception $e) {
            // Display an alert for any other errors and redirect to index.html
            echo '<script>alert("Error: ' . $e->getMessage() . '"); window.location.href = "index.html";</script>';
        }
    }
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Get data from the form
        $email = $_POST["email"];
        $password = $_POST["password"];

        // Create an instance of the Login class and authenticate the user
        $login = new Login($conn);
        $login->authenticateUser($email, $password);

        $conn->close();
    } catch (Exception $e) {
        // Display an alert for any other errors and redirect to index.html
        echo '<script>alert("Error: ' . $e->getMessage() . '"); window.location.href = "index.html";</script>';
    }
}

?>
