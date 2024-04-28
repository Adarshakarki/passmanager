

<?php
session_start();
include 'connection.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Table</title>
    <link rel="stylesheet" href="viewpassword.css">
    
</head>
<body>
<?php
// Check if user is not logged in, redirect to login page
if (!isset($_SESSION['email'])) {
    header('Location: login.php');
    exit();
}

// Retrieve user's email from session
$email = $_SESSION['email'];

// Fetch data from database
$sql = "SELECT * FROM userpassword WHERE useremail = ?";
$stmt = mysqli_prepare($conn, $sql);

if ($stmt) {
    // Bind parameters to the statement
    mysqli_stmt_bind_param($stmt, "s", $email);

    // Execute the statement
    mysqli_stmt_execute($stmt);

    // Get result
    $result = mysqli_stmt_get_result($stmt);

    // Check if there are any rows
    if (mysqli_num_rows($result) > 0) {
        echo '<table border="1">
                <tr>
                    <th>Title</th>
                    <th>Website</th>
                    <th>Web Email</th>
                    <th>Password</th>
                    <th class="edit-delete">Edit</th>
                    <th class="edit-delete">Delete</th>
                </tr>';

        // Loop through each row
        while ($row = mysqli_fetch_assoc($result)) {
            // Display row data in table rows
            echo '<tr>';
            echo '<td>' .$row['title'] . '</td>';
            echo '<td>' .$row['website'] . '</td>';
            echo '<td>' .$row['webemail'] . '</td>';
            $encryptionKey = "qwertyuiop123456";
$passwd = openssl_decrypt($row["passwd"], "aes-256-cbc", $encryptionKey, 0, $encryptionKey);
echo "<td>" . $passwd. "</td>";
echo "<td class='edit-delete'><a href='editpassword.php?id=" . $row["id"] . "'>Edit</a></td>";
        echo "<td class='edit-delete'><a href='deletepassword.php?id=" . $row["id"] . "'>Delete</a></td>";
        echo "</tr>";
        }

        // Close table
        echo '</table>';
    } else {
        echo 'No passwords found.';
    }

    // Close statement
    mysqli_stmt_close($stmt);
} else {
    echo 'Error in preparing statement.';
}

// Close connection
mysqli_close($conn);
?>
</body>
</html>
