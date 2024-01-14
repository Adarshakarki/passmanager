<?php

$servername = "sql213.infinityfree.com";
$username = "if0_35636795";
$password = "uJLWwhDrZt2";
$dbname = "if0_35636795_passmanagerlogin";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>
