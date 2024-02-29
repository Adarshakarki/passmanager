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
    
    // Fetch record by ID
    $sql = "SELECT * FROM vault WHERE id=$id";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $title = $row['title'];
        $website=$row['website'];
        $email = $row['email'];
        $passwd = $row['passwd'];
        $category=$row['category'];
    } else {
        echo "Record not found";
        exit();
    }
} elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $website=$_POST['website'];
    $email = $_POST['email'];
    $passwd = $_POST['passwd'];
    $category=$_POST['category'];
    
    // Update record
    $sql = "UPDATE vault SET title='$title',website='$website', email='$email', passwd='$passwd',category='$category' WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        echo "Record updated successfully";
        header("Location: display.php");
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Edit Record</title>
</head>

<body>
    <h2>Edit Record</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <label>Title:</label><br>
        <input type="text" name="title" value="<?php echo $title; ?>"><br>
        <label>Website:</label><br>
        <input type="website" name="website" value="<?php echo $website; ?>"><br>
        <label>Email:</label><br>
        <input type="email" name="email" value="<?php echo $email; ?>"><br>
        <label>Password:</label><br>
        <input type="password" name="passwd" value="<?php echo $passwd; ?>"><br>
        <label>Category:</label><br>
        <input type="category" name="category" value="<?php echo $category; ?>"><br>
        <label>Password:</label><br>
        <input type="submit" value="Submit">
    </form>
</body>

</html>
