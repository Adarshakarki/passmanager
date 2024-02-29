<?php
    $server ='localhost';
    $username ='root';
    $password ='';
    $dbname ='sign';

    // Create connection
    $conn = new mysqli($server, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and bind the statement
    $stmt = $conn->prepare("INSERT INTO `vault`(`title`, `website`, `email`, `passwd`, `category`) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $title, $website, $email, $passwd, $category);

    // Set parameters and execute
    $title = $_POST["title"];
    $website = $_POST["website"];
    $email = $_POST["email"];
    $passwd = password_hash($_POST["passwd"], PASSWORD_DEFAULT); // Hash the password
    $category = $_POST["category"];

    // Check if all required fields are filled
    if ($title && $website && $email && $passwd && $category) {
        if ($stmt->execute()) {
            echo "Information saved successfully";
        } else {
            echo "Error: " . $stmt->error;
        }
    } else {
        echo "Please fill out all fields";
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
?>
