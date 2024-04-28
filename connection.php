<?php
$server = 'localhost';
$username = 'root';
$password = '';
$dbname = 'minor1';

$conn = mysqli_connect($server, $username, $password, $dbname);
if (!$conn)
{
    echo "Could not connect to the database";
}
