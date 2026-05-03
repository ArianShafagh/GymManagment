<?php
$host = getenv('DB_HOST') ?: 'db';
$db   = getenv('DB_NAME') ?: 'gymDB';
$user = getenv('DB_USER') ?: 'root';
$port = getenv('DB_PORT') ?: 3306;
$pass = getenv('DB_PASS') ?: 'root';
$conn = new mysqli($host, $user, $pass, $db, $port);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
