<?php
session_start();
include '../../config/db.php';

if (!isset($_SESSION['user_email'])) {
    header("Location: ../pages/Login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_SESSION['user_email'];
    $user_res = $conn->query("SELECT id FROM users WHERE email='$email'");
    $user = $user_res->fetch_assoc();
    $user_id = $user['id'];

    $ticket_id = intval($_POST['ticket_id']);
    $message = $conn->real_escape_string($_POST['message']);

    // Ensure the ticket belongs to this user
    $ticket_res = $conn->query("SELECT id FROM tickets WHERE id=$ticket_id AND user_id=$user_id");
    if ($ticket_res->num_rows > 0) {
        $conn->query("INSERT INTO ticket_messages (ticket_id, sender_type, message) VALUES ($ticket_id, 'User', '$message')");
        // Mark as open so admin knows there's a new reply
        $conn->query("UPDATE tickets SET status='Open' WHERE id=$ticket_id AND status='In Progress'");
    }

    header("Location: ../pages/Account.php?view_ticket=$ticket_id");
    exit();
}
?>
