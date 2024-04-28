<?php
session_start(); // Start the session
include 'connection.php';

// Create connection
$con = mysqli_connect($server, $username, $password, $dbname);

// Check connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

$email = $_POST['email'];
$passwd = $_POST['passwd'];

// Check if the email is already taken
$email_check_query = "SELECT * FROM `userdata` WHERE `email`='$email' LIMIT 1";
$email_check_result = mysqli_query($con, $email_check_query);

if (mysqli_num_rows($email_check_result) > 0) {
    // Email is already taken
    echo "Email already taken. Please choose another email.";
} else {
    // Email is not taken, proceed with registration

    // Use prepared statement to prevent SQL injection
    $sql = "INSERT INTO `userdata`(`passwd`, `email`) VALUES (?, ?)";
    $stmt = mysqli_prepare($con, $sql);

    // Hash the password
  //  $hashed_password = password_hash($passwd, PASSWORD_DEFAULT);

    // Bind parameters (use the hashed password)
    mysqli_stmt_bind_param($stmt, "ss", $passwd, $email);
    $result = mysqli_stmt_execute($stmt);

    // Check the result
    if ($result) {
        // Registration successful, set session variables
        $_SESSION['email'] = $email;

        echo "Form submitted successfully.<br>";
        header("Location:home.php");
    } else {
        echo "Error: " . mysqli_error($con);
    }
    mysqli_stmt_close($stmt);
}

// Close the connection
mysqli_close($con);
?>
