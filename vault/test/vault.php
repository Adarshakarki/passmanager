<?php
session_start(); // Start session

$server = 'sql213.infinityfree.com';
$username = 'if0_35636795';
$password = 'uJLWwhDrZt2';
$dbname = 'if0_35636795_passmanagerlogin';

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

// Check if the request is POST (for inserting data)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if user is logged in
    if (!isset($_SESSION['user_id'])) {
        die("User not logged in.");
    }

    // Insert data into database
    $stmt = $conn->prepare("INSERT INTO vault (user_id, title, website, email, passwd, category) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssss", $_SESSION['user_id'], $title, $website, $email, $encryptedPasswd, $category);

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

// Retrieve data from the database associated with the current session's user ID
if (isset($_SESSION['user_id'])) {
    $sql = "SELECT title, website, email, passwd FROM vault WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $_SESSION['user_id']);
    $stmt->execute();
    $stmt->bind_result($title, $website, $email, $encryptedPasswd);

    echo "<h2>Data from the Database:</h2>";
    echo "<table border='1'>";
    echo "<tr><th>Title</th><th>Website</th><th>Email</th><th>Password</th></tr>";
    while ($stmt->fetch()) {
        // Decrypt password
        $decryptedPasswd = decryptPassword($encryptedPasswd, $encryptionKey);
        // Output decrypted password in the table
        echo "<tr><td>" . $title . "</td><td>" . $website . "</td><td>" . $email . "</td><td>" . $decryptedPasswd . "</td></tr>";
    }
    echo "</table>";

    $stmt->close();
} else {
    echo "<p>User not logged in.</p>";
}

$conn->close();
?>
