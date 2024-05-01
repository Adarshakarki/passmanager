<?php
session_start();
include 'connection.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notes Table</title>
    <link rel="stylesheet" href="viewnote.css">
    
</head>
<body>
     <?php
// Check if user is logged in (assuming email is stored in session)
if (!isset($_SESSION['email'])) {
    header('Location: login.php'); // Redirect to login page if not logged in
    exit();
}

// Query to fetch notes for the logged-in user
$email = $_SESSION['email'];

$sql = "SELECT * FROM notes WHERE email = ?";
$stmt = mysqli_prepare($conn, $sql);


if ($stmt) {
    // Bind parameters to the statement
    mysqli_stmt_bind_param($stmt, "s", $email);

    // Execute the statement
    mysqli_stmt_execute($stmt);

    // Get result
    $result = mysqli_stmt_get_result($stmt);


// Display notes in a simple HTML table
if (mysqli_num_rows($result) > 0) {
   
    echo '<table border="1" cellpadding="5" cellspacing="0">';
    echo '<tr><th>Title</th><th>Content</th><th class="edit-delete">Edit</th><th class="edit-delete">Delete</th></tr>';

    // Loop through each row in the result set
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<tr>';
        echo '<td>' .$row['title']. '</td>';
        echo '<td>' .$row['content']. '</td>';
        echo "<td class='edit-delete'><a href='editnote.php?id=" . $row["id"] . "'>Edit</a></td>";
        echo "<td class='edit-delete'><a href='deletenote.php?id=" . $row["id"] . "'>Delete</a></td>";
        echo '</tr>';
    }

    echo '</table>';
} else {
    echo "No notes found.";
}

// Close database connection
    mysqli_close($conn);}
?>
</body>
</html>

