<?php
    $server = 'localhost';
    $username = 'root';
    $password = '';
    $dbname = 'sign';

    // Create connection
    $conn = new mysqli($server, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Function to encrypt password
    function encryptPassword($password, $key) {
        return openssl_encrypt($password, 'AES-256-CBC', $key, 0, substr($key, 0, 16));
    }

    // Function to decrypt password
    function decryptPassword($encryptedPassword, $key) {
        return openssl_decrypt($encryptedPassword, 'AES-256-CBC', $key, 0, substr($key, 0, 16));
    }

    // Encryption and decryption key
    $encryptionKey = "YourEncryptionKey"; // Change this to your own encryption key

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Insert data into database
        $stmt = $conn->prepare("INSERT INTO vault (title, website, email, passwd, category) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $title, $website, $email, $encryptedPasswd, $category);

        // Set parameters
        $title = $_POST["title"];
        $website = $_POST["website"];
        $email = $_POST["email"];
        $passwd = $_POST["passwd"]; // Plain text password

        // Encrypt the password before storing it
        $encryptedPasswd = encryptPassword($passwd, $encryptionKey);

        $category = $_POST["category"];

        // Execute the statement
        if ($stmt->execute()) {
            echo "Information saved successfully.<br>";
        } else {
            echo "Error: " . $stmt->error . "<br>";
        }

        $stmt->close();
    }

    // Display data from database
    $sql = "SELECT title, website, email, passwd FROM vault";
    $result = $conn->query($sql);

    // Check if any rows were returned
    if ($result->num_rows > 0) {
        // Output data of each row
        echo "<h2>Data from the Database:</h2>";
        echo "<table border='1'>";
        echo "<tr><th>Title</th><th>Website</th><th>Email</th><th>Password</th></tr>";
        while ($row = $result->fetch_assoc()) {
            $decryptedPasswd = decryptPassword($row["passwd"], $encryptionKey);
            echo "<tr><td>" . $row["title"] . "</td><td>" . $row["website"] . "</td><td>" . $row["email"] . "</td><td>" . $decryptedPasswd . "</td></tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No data found.</p>";
    }

    $conn->close();
?>
