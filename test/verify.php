<?php
include 'connection.php';
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit;
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve email and password from form
    $email = $_SESSION['email']; // Email from session
    $passwd = $_POST['passwd']; // Password from form

    $query = "SELECT * FROM userdata WHERE email = '$email' AND passwd = '$passwd'";
    $data = mysqli_query($conn, $query);
    
    $total = mysqli_num_rows($data);

    if ($total === 1) {
        // Valid credentials
        $_SESSION["email"] = $email;
        

        header("Location: viewpassword.php");
        exit();
    } else {
        echo "Incorrect email address or password";
    }
}
?>
