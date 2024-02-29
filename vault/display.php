<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sign";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM vault";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data to vault.html
    $htmlContent = "<!DOCTYPE html>
<html>

<head>
    <title>Vault</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        th {
            background-color: #f2f2f2;
        }

        .edit-delete {
            padding-left: 20px;
        }
    </style>
</head>

<body>
    <h2>Vault</h2>
    <table border='1'>
        <tr>
            <th>Title</th>
            <th>Website</th>
            <th>Email</th>
            <th>Password</th>
            <th>Category</th>
            <th class='edit-delete'>Edit</th>
            <th class='edit-delete'>Delete</th>
        </tr>";

    while($row = $result->fetch_assoc()) {
        $htmlContent .= "<tr>";
        $htmlContent .= "<td>" . $row["title"] . "</td>";
        $htmlContent .= "<td>" . $row["website"] . "</td>";
        $htmlContent .= "<td>" . $row["email"] . "</td>";
        $htmlContent .= "<td>" . $row["passwd"] . "</td>";
        $htmlContent .= "<td>" . $row["category"] . "</td>";
        $htmlContent .= "<td class='edit-delete'><a href='edit.php?id=" . $row["id"] . "'>Edit</a></td>";
        $htmlContent .= "<td class='edit-delete'><a href='delete.php?id=" . $row["id"] . "'>Delete</a></td>";
        $htmlContent .= "</tr>";
    }

    $htmlContent .= "</table>
</body>
</html>";

    // Write content to vault.html
    file_put_contents("vault.html", $htmlContent);

} else {
    echo "<p>No records found</p>";
}

$conn->close();
?>
