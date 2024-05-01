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
    $content = $_POST['content'];
   

    $sql = "UPDATE notes SET title=?,content=? WHERE id=?";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        // Bind parameters to the statement
        mysqli_stmt_bind_param($stmt, "ssi", $title,$content,$id);

        // Execute the statement
        $result = mysqli_stmt_execute($stmt);

        if ($result) {
            echo " record updated successfully.";
             header("Location: viewnote.php"); // Redirect to notes
            exit();
        } else {
            echo "Error updating record: " . mysqli_error($conn);
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
    $sql = "SELECT * FROM notes WHERE id=?";
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
            $content = $row['content'];
        
            // Display edit form
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
        <title>Edit Notes Record</title>
        <link rel="stylesheet" href="editnote.css">
</head>
<body>
    
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <h1>Edit Notes</h1>
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <label>Title:</label><br>
        <input type="text" name="title" value="<?php echo $title; ?>" required><br>
        <label>Content:</label><br>
        <input type="text" name="content" value="<?php echo $content; ?>" required><br>
        
        <input type="submit" value="Update">
    </form>
</body>
</html>
<?php
        } else {
            echo "Notes record not found.";
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
