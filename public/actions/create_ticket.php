<?php
session_start();
include '../../config/db.php';
if(!isset($_SESSION['user_email'])) {
    header("Location: ../pages/Login.php");
    exit();
}

$email = $_SESSION['user_email'];
$subject = $_POST['subject'] ?? '';
$message = $_POST['message'] ?? '';

$user_res = $conn->query("SELECT id FROM users WHERE email='$email'");
$user = $user_res->fetch_assoc();
$user_id = $user['id'];

$conn->query("INSERT INTO tickets (user_id, subject) VALUES ('$user_id', '$subject')");
$ticket_id = $conn->insert_id;

$conn->query("INSERT INTO ticket_messages (ticket_id, sender_type, message) VALUES ('$ticket_id', 'User', '$message')");

header("Location: ../pages/Account.php");
exit();
?>
