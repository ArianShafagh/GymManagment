<?php
ob_start();
session_start();
if (!isset($_SESSION['is_admin'])) { header("Location: ../../pages/admin/login.php"); exit(); }
include '../../../config/db.php';

$ticket_id = intval($_POST['ticket_id']);
$message = $conn->real_escape_string($_POST['message']);

$conn->query("INSERT INTO ticket_messages (ticket_id, sender_type, message) VALUES ('$ticket_id', 'Admin', '$message')");
$conn->query("UPDATE tickets SET status='In Progress' WHERE id='$ticket_id' AND status='Open'");

header("Location: ../../pages/admin/dashboard.php?ticket_id=$ticket_id");
exit();
?>
