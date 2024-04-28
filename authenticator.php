<?php
include 'connection.php';

session_start(); // Start the session

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $passwd = $_POST['passwd'];
    

    $query = "SELECT * FROM userdata WHERE email = '$email' AND passwd = '$passwd'";
    $data = mysqli_query($conn, $query);
    
    $total = mysqli_num_rows($data);

    if ($total === 1) {
        // Valid credentials
        $_SESSION["email"] = $email;
        

        header("Location: home.php");
        exit();
    } else {
        echo "Incorrect email address or password";
    }
} else {
    echo "failed";    
}