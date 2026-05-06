<?php
session_start();
include '../../config/db.php';

if (!isset($_SESSION['user_email'])) {
    header("Location: ../pages/Login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_SESSION['user_email'];
    $ustmt = $conn->prepare("SELECT id FROM users WHERE email = ? LIMIT 1");
    $ustmt->execute([$email]);
    $user = $ustmt->fetch(PDO::FETCH_ASSOC);
    $user_id = $user['id'];

    $ticket_id = intval($_POST['ticket_id']);
    $message = $_POST['message'];

    // Ensure the ticket belongs to this user
    $tstmt = $conn->prepare("SELECT id FROM tickets WHERE id = ? AND user_id = ? LIMIT 1");
    $tstmt->execute([$ticket_id, $user_id]);
    if ($tstmt->rowCount() > 0) {
        $ins = $conn->prepare("INSERT INTO ticket_messages (ticket_id, sender_type, message) VALUES (?,?,?)");
        $ins->execute([$ticket_id, 'User', $message]);
        // Mark as open so admin knows there's a new reply
        $conn->prepare("UPDATE tickets SET status='Open' WHERE id = ? AND status = 'In Progress'")->execute([$ticket_id]);
    }

    header("Location: ../pages/Account.php?view_ticket=$ticket_id");
    exit();
}
?>
