<?php
ob_start();
session_start();
if (!isset($_SESSION['is_admin'])) { header("Location: ../../pages/admin/login.php"); exit(); }
include '../../../config/db.php';

$ticket_id = intval($_POST['ticket_id']);
$message = trim($_POST['message']);

$stmt = $conn->prepare("INSERT INTO ticket_messages (ticket_id, sender_type, message) VALUES (?, 'Admin', ?)");
$stmt->execute([$ticket_id, $message]);

$update = $conn->prepare("UPDATE tickets SET status = 'In Progress' WHERE id = ? AND status = 'Open'");
$update->execute([$ticket_id]);

header("Location: ../../pages/admin/dashboard.php?ticket_id=$ticket_id");
exit();
?>
