<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sign";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Delete record
    $sql = "DELETE FROM vault WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        echo "Record deleted successfully";
        header("Location: display.php");
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}
$conn->close();
?>
