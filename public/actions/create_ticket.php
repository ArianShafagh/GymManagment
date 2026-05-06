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

 $ustmt = $conn->prepare("SELECT id FROM users WHERE email = ? LIMIT 1");
 $ustmt->execute([$email]);
 $user = $ustmt->fetch(PDO::FETCH_ASSOC);
 $user_id = $user['id'];

 $stmt = $conn->prepare("INSERT INTO tickets (user_id, subject) VALUES (?,?)");
 $stmt->execute([$user_id, $subject]);
 $ticket_id = $conn->lastInsertId();

 $conn->prepare("INSERT INTO ticket_messages (ticket_id, sender_type, message) VALUES (?,?,?)")->execute([$ticket_id, 'User', $message]);

header("Location: ../pages/Account.php");
exit();
?>
