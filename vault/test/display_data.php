<?php
// Connect to the database
$conn = mysqli_connect("localhost", "username", "password", "database_name");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Retrieve data from the database
$result = mysqli_query($conn, "SELECT * FROM passwords");

// Display data in a table
while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>";
    echo "<td>".$row['title']."</td>";
    echo "<td>".$row['website']."</td>";
    echo "<td>".$row['email']."</td>";
    echo "<td>".$row['password']."</td>";
    echo "<td>";
    echo "<a href='edit.php?id=".$row['id']."'>Edit</a> | ";
    echo "<a href='delete.php?id=".$row['id']."'>Delete</a>";
    echo "</td>";
    echo "</tr>";
}

mysqli_close($conn);
?>
