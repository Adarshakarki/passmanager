<?php
session_start();
include 'connection.php';

// Check if user is not logged in, redirect to login page
if (!isset($_SESSION['email'])) {
    header('Location: login.php');
    exit();
}

// Check if form is submitted for updating record
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    // Retrieve form data
    $id = $_POST['id'];
    $title = $_POST['title'];
    $website = $_POST['website'];
    $webemail = $_POST['webemail'];
    $passwd = $_POST['passwd'];

    // Encrypt the password
    $encryptionKey = "qwertyuiop123456";
    $encryptedPasswd = openssl_encrypt($passwd, "aes-256-cbc", $encryptionKey, 0, $encryptionKey);

    // Update record in the database
    $sql = "UPDATE userpassword SET title=?,website=?, webemail=?, passwd=? WHERE id=?";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        // Bind parameters to the statement
        mysqli_stmt_bind_param($stmt, "ssssi", $title,$website, $webemail, $encryptedPasswd, $id);

        // Execute the statement
        $result = mysqli_stmt_execute($stmt);

        if ($result) {
            echo "Password record updated successfully.";
            header("Location: viewpassword.php"); // Redirect to password vault page
            exit();
        } else {
            echo "Error updating password record: " . mysqli_error($conn);
        }

        // Close statement
        mysqli_stmt_close($stmt);
    } else {
        echo "Error in preparing update statement.";
    }
}

// Retrieve record ID from URL parameter
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch password record details by ID

    
    $sql = "SELECT * FROM userpassword WHERE id=?";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        // Bind parameter to the statement
        mysqli_stmt_bind_param($stmt, "i", $id);

        // Execute the statement
        mysqli_stmt_execute($stmt);

        // Get result
        $result = mysqli_stmt_get_result($stmt);

        // Check if record exists
        if (mysqli_num_rows($result) > 0) {
            // Fetch record data
            $row = mysqli_fetch_assoc($result);
            $title = $row['title'];
            $website = $row['website'];
            $webemail = $row['webemail'];
            // Decrypt the password
            $encryptionKey = "qwertyuiop123456";
            $passwd = openssl_decrypt($row['passwd'], "aes-256-cbc", $encryptionKey, 0, $encryptionKey);

            // Display edit form
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
        <title>Edit Password Record</title>
        <link rel="stylesheet" href="editpassword.css">
</head>
<body>
    
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <h1>Edit Passwords</h1>
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <label>Title:</label><br>
        <input type="text" name="title" value="<?php echo $title; ?>" required><br>
        <label>Website:</label><br>
        <input type="text" name="website" value="<?php echo $website; ?>" required><br>
        <label>Web Email:</label><br>
        <input type="text" name="webemail" value="<?php echo $webemail; ?>" required><br>
        <label>Password:</label><br>
        <input type="text" name="passwd" value="<?php echo $passwd; ?>" required><br><br>
        <input type="submit" value="Update">
    </form>
</body>
</html>
<?php
        } else {
            echo "Password record not found.";
        }

        // Close statement
        mysqli_stmt_close($stmt);
    } else {
        echo "Error in preparing select statement.";
    }
} else {
    echo "Invalid request. Record ID not provided.";
}

// Close connection
mysqli_close($conn);
?>
