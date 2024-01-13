<?php
$server = 'localhost';
$username = 'root';
$password = '';
$database = 'suman';

$con = mysqli_connect($server, $username, $password, $database);

if (!$con) {
    die("Error connecting to the database: " . mysqli_connect_error());
} else {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Validate and sanitize user input
        $email = mysqli_real_escape_string($con, $_POST['email']);
        $password = mysqli_real_escape_string($con, $_POST['password']);

        // Use prepared statement to prevent SQL injection
        $query = "SELECT * FROM fill WHERE email=?";
        $stmt = mysqli_prepare($con, $query);

        if ($stmt) {
            // Bind parameters
            mysqli_stmt_bind_param($stmt, 's', $email);

            // Execute the statement
            mysqli_stmt_execute($stmt);

            // Get result
            $result = mysqli_stmt_get_result($stmt);

            if ($row = mysqli_fetch_assoc($result)) {
                // Verify the password
                if (password_verify($password, $row['password'])) {
                    // Password is correct, redirect to a secure page
                    header("Location: https://www.youtube.com/watch?v=dQw4w9WgXcQ");
                    exit();
                } else {
                    // Incorrect password
                    echo "Login failed. Please check your credentials.";
                }
            } else {
                // User does not exist
                echo "Login failed. Please check your credentials.";
            }

            // Close the statement
            mysqli_stmt_close($stmt);
        } else {
            echo "Error preparing statement: " . mysqli_error($con);
        }
    } else {
        echo "Invalid request method.";
    }

    // Close the connection
    mysqli_close($con);
}
?>
