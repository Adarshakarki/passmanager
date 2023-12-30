<?php
$servername = "sql213.infinityfree.com";
$username = "if0_35636795";
$password = "AAPxK5bKHdJ36k";
$dbname = "if0_35636795_Passmanager";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>