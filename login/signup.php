<?php
$server = 'localhost';
$username = 'root';
$password = '';
$database = 'suman';

// Establish database connection
$con = mysqli_connect($server, $username, $password, $database);

// Check connection
if (!$con) {
    die("Error connecting to the database: " . mysqli_connect_error());
} else {
    // Get form data
    $userId = $_POST['userId'];
    $email = $_POST['signupEmail'];
    $password = $_POST['signupPassword'];

    // Validate inputs
    if (empty($userId) || empty($email) || empty($password)) {
        echo "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email address.";
    } else {
        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Use prepared statement to prevent SQL injection
        $sqli = "INSERT INTO fill (userid, email, password) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($con, $sqli);

        if ($stmt) {
            // Bind parameters
            mysqli_stmt_bind_param($stmt, 'sss', $userId, $email, $hashedPassword);

            // Execute the statement
            $result = mysqli_stmt_execute($stmt);

            if ($result) {
                echo "Form submitted successfully";
            } else {
                echo "Error inserting data: " . mysqli_stmt_error($stmt);
            }

            // Close the statement
            mysqli_stmt_close($stmt);
        } else {
            echo "Error preparing statement: " . mysqli_error($con);
        }
    }

    // Close the connection
    mysqli_close($con);
}
?>
