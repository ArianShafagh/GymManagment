<?php
ob_start();
session_start();
if (!isset($_SESSION['is_admin'])) { header("Location: ../../pages/admin/login.php"); exit(); }
include '../../../config/db.php';

$ticket_id = intval($_POST['ticket_id']);
$status = $conn->real_escape_string($_POST['status']);

$conn->query("UPDATE tickets SET status='$status' WHERE id='$ticket_id'");

header("Location: ../../pages/admin/dashboard.php?ticket_id=$ticket_id");
exit();
?>
