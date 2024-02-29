<?php
// Retrieve password ID from URL parameter
$id = $_GET['id'];

// Assuming you have database connection code here

// Delete password data based on ID
$sql = "DELETE FROM passwords WHERE id = $id";
if (mysqli_query($conn, $sql)) {
    echo "Record deleted successfully";
} else {
    echo "Error deleting record: " . mysqli_error($conn);
}

// Redirect back to index.php or any other appropriate page
header("Location: index.php");
exit;
?>
