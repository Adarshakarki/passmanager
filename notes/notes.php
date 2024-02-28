<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if not logged in
    header("Location: login.html");
    exit();
}

// Database connection
$servername = "sql213.infinityfree.com";
$username = "if0_35636795";
$password = "uJLWwhDrZt2";
$dbname = "if0_35636795_passmanagerlogin";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle add note request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $userId = $_SESSION['user_id'];

    $sql = "INSERT INTO notes (user_id, title, content) VALUES ('$userId', '$title', '$content')";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(array("success" => true));
    } else {
        echo json_encode(array("success" => false, "error" => $conn->error));
    }
    exit();
}

// Handle get notes request
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $userId = $_SESSION['user_id'];

    $sql = "SELECT * FROM notes WHERE user_id='$userId'";
    $result = $conn->query($sql);

    $notes = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $notes[] = $row;
        }
    }
    echo json_encode($notes);
    exit();
}

// Close connection
$conn->close();
?>
