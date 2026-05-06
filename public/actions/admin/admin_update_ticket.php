<?php
ob_start();
session_start();
if (!isset($_SESSION['is_admin'])) { header("Location: ../../pages/admin/login.php"); exit(); }
include '../../../config/db.php';

$ticket_id = intval($_POST['ticket_id']);
$status = trim($_POST['status']);

$stmt = $conn->prepare("UPDATE tickets SET status = ? WHERE id = ?");
$stmt->execute([$status, $ticket_id]);

header("Location: ../../pages/admin/dashboard.php?ticket_id=$ticket_id");
exit();
?>
