<?php
// Process form data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $title = $_POST['title'];
    $website = $_POST['website'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validate and sanitize data (not shown here)

    // Connect to the database
    $conn = mysqli_connect("localhost", "username", "password", "database_name");
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Insert data into the database
    $sql = "INSERT INTO passwords (title, website, email, password) VALUES ('$title', '$website', '$email', '$password')";
    if (mysqli_query($conn, $sql)) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>
