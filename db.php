<?php
$host = 'localhost';
$db   = 'gymDB';
$user = 'root';
$port = 3306;
$pass = '';
$conn = new mysqli($host, $user, $pass, $db, $port);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo("connected")
?>